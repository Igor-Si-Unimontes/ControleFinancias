@extends('layouts.main')

@section('title', 'qrcode')

@section('content')
    <div class="container rounded bg-fosco shadow-sm mt-4 p-5">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="mb-0 titulo">Leitor de NFC-e (QR Code)</h1>
        </div>
        <div class="divisor-underline mb-4"></div>

        <div class="text-center">
            <button id="startButton" class="btn btn-success mb-3">Iniciar Leitura</button>
            <div id="reader" style="width: 500px; margin: auto;"></div>
        </div>
        
        <div id="results" class="mt-4 text-center"></div>
        <div id="status" class="mt-2 text-center text-muted"></div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const startButton = document.getElementById('startButton');
        const resultsDiv = document.getElementById('results');
        const readerDiv = document.getElementById('reader');
        const statusDiv = document.getElementById('status');

        const html5QrCode = new Html5Qrcode("reader");

        // Função chamada quando um QR Code é lido com sucesso
        const onScanSuccess = (decodedText, decodedResult) => {
            html5QrCode.stop().then(ignore => {
                readerDiv.style.display = 'none';
                startButton.style.display = 'block';
                statusDiv.innerHTML = '';
                resultsDiv.innerHTML = `<div class="alert alert-success">URL lida: <br><strong>${decodedText}</strong></div>`;
                console.log(`Leitura bem-sucedida. URL: ${decodedText}`);

                // Sua lógica para enviar a URL para o backend...

            }).catch(err => {
                console.error("Erro ao parar o leitor: ", err);
            });
        };

        // Função chamada quando a leitura falha (para diagnóstico)
        const onScanFailure = (error) => {
            // Este callback é acionado várias vezes por segundo, então evitamos logs excessivos
            // console.warn(`Nenhum QR Code detectado: ${error}`);
            statusDiv.innerHTML = 'Procurando QR Code...';
        };

        // Função para iniciar a leitura
        const startScanning = () => {
            readerDiv.style.display = 'block';
            startButton.style.display = 'none';
            resultsDiv.innerHTML = '';
            statusDiv.innerHTML = 'Aguardando permissão da câmera...';

            const config = { 
                fps: 10,
                qrbox: { width: 250, height: 250 }
            };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanFailure // Adiciona o callback de falha
            ).then(() => {
                console.log("Leitor de QR Code iniciado com sucesso.");
                statusDiv.innerHTML = 'Câmera iniciada. Aponte para o QR Code.';
            }).catch(err => {
                console.error("Erro ao iniciar o leitor: ", err);
                resultsDiv.innerHTML = `<div class="alert alert-danger">Erro ao acessar a câmera. Verifique as permissões.</div>`;
                startButton.style.display = 'block';
                readerDiv.style.display = 'none';
                statusDiv.innerHTML = '';
            });
        };

        startButton.addEventListener('click', startScanning);

    </script>
@endsection