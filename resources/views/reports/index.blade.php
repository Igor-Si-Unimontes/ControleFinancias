@extends('layouts.main')

@section('title', 'Relatórios')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="mb-0 titulo">Relatórios de Ganhos e Gastos</h1>
        </div>
        <div class="divisor-underline mb-4"></div>

        <form id="reportForm">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Data Inicial:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label">Data Final:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                </div>
                <div class="col-md-6 mt-4">
                    <input type="checkbox" name="generate_pdf" id="generate_pdf">
                    <label for="generate_pdf" class="form-label">Gerar PDF</label>
                </div>
            </div>
            <div class="text-start">
                <button type="submit" class="btn btn-success">Gerar Relatório</button>
            </div>
        </form>

        <div id="reportResults" class="mt-4"></div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const form = document.getElementById('reportForm');
        const resultsDiv = document.getElementById('reportResults');

        function formatToIso(dateString) {
            if (dateString.includes('-')) {
                return dateString;
            }
            const [day, month, year] = dateString.split('/');
            return `${year}-${month}-${day}`;
        }
        
        function createLocalDate(isoString) {
            const [year, month, day] = isoString.split('-').map(Number);
            return new Date(year, month - 1, day); // month é 0-indexado
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const generatePdf = document.getElementById('generate_pdf').checked;
            if (new Date(startDate) > new Date(endDate)) {
                resultsDiv.innerHTML =
                    `<div class="alert alert-danger">A data inicial não pode ser maior que a data final.</div>`;
                return;
            }
            if (generatePdf) {
                window.location.href = `/reports/pdf?start_date=${startDate}&end_date=${endDate}`;
            }
            try {
                const response = await fetch('/reports', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        start_date: startDate,
                        end_date: endDate
                    })
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error('Erro na resposta do servidor.');
                }
                
                const gainsMap = {};
                const spendsMap = {};
                const allDates = new Set();

                data.gains.forEach(item => {
                    const formattedDate = formatToIso(item.date);
                    allDates.add(formattedDate);
                    gainsMap[formattedDate] = item.amount;
                });
                data.spends.forEach(item => {
                    const formattedDate = formatToIso(item.date);
                    allDates.add(formattedDate);
                    spendsMap[formattedDate] = item.amount;
                });

                const labels = Array.from(allDates);
                labels.sort((a, b) => createLocalDate(a) - createLocalDate(b));

                const gainsData = labels.map(date => gainsMap[date] || 0);
                const spendsData = labels.map(date => spendsMap[date] || 0);

                resultsDiv.innerHTML = `
                    <div class="mb-4">
                        <table class="table table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Total de Ganhos</th>
                                    <th>Total de Gastos</th>
                                    <th>Total da Renda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-success fw-bold"> ${formatarValor(data.total_gains)}</td>
                                    <td class="text-danger fw-bold"> ${formatarValor(data.total_spends)}</td>
                                    <td class="fw-bold">${getRendaFormatada(data.total_balance)}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <canvas id="lineChart" class="bg-white rounded p-3 w-100"></canvas>
                `;

                const ctx = document.getElementById('lineChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                                label: 'Gastos',
                                data: spendsData,
                                borderColor: 'red',
                                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                                tension: 0.4
                            },
                            {
                                label: 'Ganhos',
                                data: gainsData,
                                borderColor: 'green',
                                backgroundColor: 'rgba(0, 255, 0, 0.2)',
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            x: {
                                ticks: {
                                    callback: function(value, index, ticks) {
                                        const date = createLocalDate(labels[index]);
                                        const day = String(date.getDate()).padStart(2, '0');
                                        const month = String(date.getMonth() + 1).padStart(2, '0');
                                        const year = date.getFullYear();
                                        return `${day}/${month}/${year}`;
                                    }
                                }
                            }
                        }
                    }
                });

            } catch (error) {
                resultsDiv.innerHTML =
                    `<div class="alert alert-danger">Erro ao gerar gráfico: ${error.message}</div>`;
            }
        });

        function formatarValor(valor) {
            return Number(valor).toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
        }

        function getRendaFormatada(valor) {
            const valorNumerico = Number(valor);
            const classe = valorNumerico >= 0 ? 'text-success' : 'text-danger';
            return `<span class="${classe}">${formatarValor(valorNumerico)}</span>`;
        }
    </script>
@endsection