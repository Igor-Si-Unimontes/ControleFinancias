<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório Financeiro</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .totals { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Relatório de Ganhos e Gastos</h1>
    <p><strong>Período:</strong> {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} 
        até {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}</p>

    <h3>Ganhos</h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gains as $gain)
                <tr>
                    <td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $gain['date'])->format('d/m/Y') }}</td>
                    <td>{{ $gain['name'] }}</td>
                    <td>{{ $gain['description'] }}</td>
                    <td>R$ {{ number_format($gain['amount'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="totals">
                <td colspan="2">Total de Ganhos</td>
                <td>R$ {{ number_format($total_gains, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Gastos</h3>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spends as $spend)
                <tr>
                    <td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $spend['date'])->format('d/m/Y') }}</td>
                    <td>{{ $spend['name'] }}</td>
                    <td>{{ $spend['category'] }}</td>
                    <td>R$ {{ number_format($spend['amount'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="totals">
                <td colspan="2">Total de Gastos</td>
                <td>R$ {{ number_format($total_spends, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Resumo Final</h3>
    <table>
        <tr>
            <th>Saldo Total</th>
            <td style="color: {{ $total_balance >= 0 ? 'green' : 'red' }};">
                R$ {{ number_format($total_balance, 2, ',', '.') }}
            </td>
        </tr>
    </table>
</body>
</html>
