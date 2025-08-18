<?php

namespace App\Http\Controllers;

use App\Enums\FinancialPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Spend;
use App\Models\CategorySpend;
use Carbon\Carbon;

class GPTSpendController extends Controller
{
    public function index()
    {
        return view('gpt.create');
    }
    public function interpretar(Request $request)
    {
        $userId = Auth::id();
        $today = now('America/Sao_Paulo')->toDateString();
        $key = "user:{$userId}:gpt_requests:{$today}";

        $limit = 10;

        $requests = Cache::get($key, 0);

        if ($requests >= $limit) {
            return redirect()->back()->withErrors([
                'erro' => "Você atingiu o limite diário de {$limit} requisições por dia."
            ]);
        }


        Cache::put($key, $requests + 1, now()->endOfDay());

        $frase = $request->input('texto');
        $currentDate = now('America/Sao_Paulo')->format('Y-m-d');

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Você é um assistente que transforma frases de gastos em JSON com os campos: name, amount, date, category. A data deve estar no formato YYYY-MM-DD. As categorias possíveis são: alimentação, educação, transporte, lazer, moradia, saúde, contas, outros. A data de hoje é: {$currentDate}."
                ],
                [
                    'role' => 'user',
                    'content' => $frase
                ]
            ],
        ]);

        $resposta = $response->choices[0]->message->content;

        preg_match('/\{.*\}/s', $resposta, $matches);
        if (!isset($matches[0])) {
            return response()->json(['erro' => 'Não foi possível interpretar a resposta da IA.'], 422);
        }

        $dados = json_decode($matches[0], true);
        if (!$dados) {
            return response()->json(['erro' => 'JSON inválido'], 422);
        }
        if (empty($dados['date'])) {
            $dados['date'] = Carbon::now()->format('Y-m-d');
        }

        $categoria = CategorySpend::where('name', $dados['category'])->first();
        if (!$categoria) {
            $categoria = CategorySpend::create([
                'name' => $dados['category'],
                'user_id' => Auth::id(),
            ]);
        }

        Spend::create([
            'name' => $dados['name'],
            'amount' => $dados['amount'],
            'date' => $dados['date'],
            'category_spend_id' => $categoria->id,
            'payment_method' => FinancialPaymentMethod::PIX,
            'description' => null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('spends.index')->with('success', 'Gasto adicionado com sucesso!');
    }
}
