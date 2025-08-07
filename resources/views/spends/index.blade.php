@extends('layouts.main')

@section('title', 'Gastos')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="mb-0 titulo">Lista de Gastos</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('spends.create') }}" class="btn btn-success">Adicionar Novo Gasto</a>
                <a href="{{ route('gasto.gpt') }}" class="btn btn-info">Adicionar Novo Gasto por IA</a>
            </div>
        </div>
        <div class="divisor-underline mb-4"></div>

        <table id="spendsTable" class="table table-hover bg-fosco">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Categoria</th>
                    <th>Método de Pagamento</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($spends as $spend)
                    <tr>
                        <td>{{ $spend->name }}</td>
                        <td>{{ $spend->amount }}</td>
                        <td>{{ \Carbon\Carbon::parse($spend->date)->format('d/m/Y') }}</td>
                        <td>{{ $spend->category_spend_id ? $spend->categorySpend->name : '-' }}</td>
                        <td>{{ $spend->payment_method->label() }}</td>
                        <td class="text-center">
                            <a href="{{ route('spends.show', $spend->id) }}" class="btn btn-sm" style="color: #43a047;"
                                title="Visualizar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="#43a047" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M2 12s4-8 10-8 10 8 10 8-4 8-10 8-10-8-10-8z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('spends.edit', $spend->id) }}" class="btn btn-sm" style="color: #43a047;"
                                title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="#43a047" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                                </svg>
                            </a>
                            <a href="#" class="btn btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteSpendModal-{{ $spend->id }}" style="color: #DC2626;"
                                title="Apagar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                    <path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <div class="modal fade" id="deleteSpendModal-{{ $spend->id }}" tabindex="-1"
                        aria-labelledby="deleteSpendModalLabel-{{ $spend->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteSpendModalLabel-{{ $spend->id }}">Confirmar
                                        Exclusão</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                    Tem certeza que deseja excluir o gasto <strong>{{ $spend->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('spends.destroy', $spend->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Sim, excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('styles')
    <style>
        .bg-fosco {
            background-color: #1e1e1e !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
            color: #f1f1f1;
        }

        .bg-fosco #spendsTable,
        .bg-fosco #spendsTable thead,
        .bg-fosco #spendsTable tbody,
        .bg-fosco #spendsTable th,
        .bg-fosco #spendsTable td {
            background-color: #2a2a2a !important;
            color: #f1f1f1;
        }

        #spendsTable thead th {
            background-color: #1f1f1f !important;
            padding: 20px 20px;
            border-bottom: 1px solid #444;
        }

        #spendsTable td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #444;
        }

        #spendsTable tbody tr:hover {
            background-color: #3a3a3a !important;
            transition: background-color 0.3s ease;
        }

        #spendsTable {
            border-radius: 10px;
            overflow: hidden;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .dataTables_length select {
            background-color: #2a2a2a !important;
            color: #f1f1f1 !important;
            border: 1px solid #444 !important;
            border-radius: 4px;
            padding: 4px 8px;
            cursor: pointer;
        }

        .dataTables_length select:focus {
            background-color: #1e1e1e !important;
            border-color: #4caf50 !important;
            box-shadow: 0 0 8px #4caf50;
            outline: none;
        }
    </style>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#spendsTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json',
                    search: "",
                    searchPlaceholder: "Busque aqui...",
                    lengthMenu: "Linhas _MENU_"
                },
                paging: true,
                searching: true,
                lengthChange: true,
                pageLength: 10,
                pagingType: "simple_numbers",
                dom: "<'row'<'col-sm-12 d-flex mb-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-5'<'col-sm-12 d-flex justify-content-end align-items-center'<'dt-length me-3'l><'dt-pagination'p>>>"
            });
        });
    </script>
@endsection
