<?php
namespace App\Repositories;
use App\Models\Spend;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SpendRepository
{
    public function create(array $data)
    {
        return Spend::create($data);
    }

    public function update(int $id, array $data)
    {
        return Spend::where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return Spend::destroy($id);
    }

    public function findById($id)
    {
        return Spend::find($id);
    }
    public function all()
    {
        return Spend::all()->where('user_id', auth()->id());
    }
    public function sumAmountsMonth()
    {
        return Spend::whereMonth('date', now()->month)->where('user_id', auth()->id())->sum('amount');
    }
    public function totalSpentByCategory()
    {
        return DB::table('spends')
            ->join('category_spends', 'spends.category_spend_id', '=', 'category_spends.id')
            ->select('category_spends.name', DB::raw('SUM(spends.amount) as total'))
            ->where('spends.user_id', auth()->id())
            ->groupBy('category_spends.name')
            ->get();
    }
    public function filtersForDateRange($start, $end)
    {
        return Spend::whereBetween('date', [$start, $end])
            ->where('user_id', auth()->id())
            ->orderBy('date')
            ->get()
            ->map(function ($spend) {
                return [
                    'name' => $spend->name,
                    'category' => $spend->categorySpend->name,
                    'amount' => $spend->amount,
                    'date' => Carbon::parse($spend->date)->format('d/m/Y'),
                    'category_spend_id' => $spend->category_spend_id
                ];
            });
    }
}