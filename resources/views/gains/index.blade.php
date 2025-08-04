@extends('layouts.main')

@section('title', 'Ganhos')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="mb-0 titulo">Lista de Ganhos</h1>
            <a href="{{ route('gains.create') }}" class="btn btn-success">Adicionar Novo Ganho</a>
        </div>
        <div class="divisor-underline mb-4"></div>

        <table id="gainsTable" class="table table-hover bg-fosco">
            <thead>
                <tr>
                    <th style="width: 30%;">Nome</th>
                    <th style="width: 20%;">Valor</th>
                    <th style="width: 20%;">Data</th>
                    <th class="text-center" style="width: 20%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gains as $gain)
                    <tr>
                        <td style="width: 30%;">{{ $gain->name ?? '' }}</td>
                        <td style="width: 20%;"> R$ {{ $gain->amount ?? '' }}</td>
                        <td style="width: 20%;">{{ \Carbon\Carbon::parse($gain->date)->format('d/m/Y') ?? '' }}</td>
                        <td class="text-center" style="width: 20%;">
                            <a href="{{ route('gains.show', $gain->id) }}" class="btn btn-sm" style="color: #43a047;"
                                title="Visualizar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="#43a047" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M2 12s4-8 10-8 10 8 10 8-4 8-10 8-10-8-10-8z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('gains.edit', $gain->id) }}" class="btn btn-sm" style="color: #43a047;"
                                title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="#43a047" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                                </svg>
                            </a>
                            <a href="#" class="btn btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteGainModal-{{ $gain->id }}" style="color: #DC2626;"
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
                    <div class="modal fade" id="deleteGainModal-{{ $gain->id }}" tabindex="-1"
                        aria-labelledby="deleteGainModalLabel-{{ $gain->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteGainModalLabel-{{ $gain->id }}">Confirmar
                                        Exclusão</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                    Tem certeza que deseja excluir o ganho <strong>{{ $gain->name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('gains.destroy', $gain->id) }}" method="POST">
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

        .bg-fosco #gainsTable,
        .bg-fosco #gainsTable thead,
        .bg-fosco #gainsTable tbody,
        .bg-fosco #gainsTable th,
        .bg-fosco #gainsTable td {
            background-color: #2a2a2a !important;
            color: #f1f1f1;
        }

        #gainsTable thead th {
            background-color: #1f1f1f !important;
            padding: 20px 20px;
            border-bottom: 1px solid #444;
        }

        #gainsTable td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #444;
        }

        #gainsTable tbody tr:hover {
            background-color: #3a3a3a !important;
            transition: background-color 0.3s ease;
        }

        #gainsTable {
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
            $('#gainsTable').DataTable({
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
