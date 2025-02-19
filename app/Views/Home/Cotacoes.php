<?php

$url = 'https://www.noticiasagricolas.com.br/cotacoes/cacau/cacau-mercado-do-cacau';

// pega o html
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT,
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) '
    .'Chrome/58.0.3029.110 Safari/537.36');
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Erro cURL: ' . curl_error($ch);
}
curl_close($ch);

$cotacoesAgrupadas = [];

if (!empty($response)) {
    $response = mb_convert_encoding($response, 'HTML-ENTITIES', 'UTF-8');

    $dom = new DOMDocument();
    @$dom->loadHTML($response);
    $xpath = new DOMXPath($dom);

    $cotacaoDivs = $xpath->query("//div[@class='cotacao']");

    // pega os dados
    foreach ($cotacaoDivs as $div) {
        $fechamentoDiv = (new DOMXPath($dom))->query(".//div[@class='fechamento']", $div);
        $dataFechamento = '';
        if ($fechamentoDiv->length > 0) {
            $dataFechamento = trim($fechamentoDiv->item(0)->textContent);
        }

        $rows = (new DOMXPath($dom))->query(".//table[@class='cot-fisicas']/tbody/tr", $div);

        $linhaCotacoes = [];
        foreach ($rows as $row) {
            // Verifica se realmente é um <tr>
            if ($row->nodeName === 'tr') {
                // Busca os <td> dentro desse <tr> usando XPath
                $cols = $xpath->query('.//td', $row);
                if ($cols->length >= 3) {
                    $estado   = trim($cols->item(0)->textContent);
                    $preco    = trim($cols->item(1)->textContent);
                    $variacao = trim($cols->item(2)->textContent);

                    $linhaCotacoes[] = [
                        'estado'   => $estado,
                        'preco'    => $preco,
                        'variacao' => $variacao
                    ];
                }
            }
        }

        // Monta o array final
        $cotacoesAgrupadas[] = [
            'data' => $dataFechamento,
            'rows' => $linhaCotacoes
        ];
    }
} else {
    echo "Não foi possível capturar o HTML (resposta vazia).";
}

?>

<style>
    .card-cotacao {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .card-header {
        font-weight: bold;
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Cotações do Cacau</h2>

    <div class="row">

        <!-- COLUNA ESQUERDA: Cotação Nacional -->
        <div class="col-md-4 mb-4">
            <?php if (!empty($cotacoesAgrupadas[0]['rows'])): ?>
            <div class="card-cotacao h-100 w-100">
                <p class="titulo">Cotação Atual - Cacau BR</p>
                <table class="table table-bordered table-lg">
                    <thead class="">
                        <tr>
                            <th>Estado</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cotacoesAgrupadas[0]['rows'] as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['estado']) ?></td>
                            <td>R$ <?= htmlspecialchars($row['preco']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p><b>Fonte: </b>Mercado do Cacau</p>
                <?php else: ?>
                <p>Nenhuma cotação encontrada</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- COLUNA DIREITA: Card com Gráfico -->
        <div class="col-md-8 mb-4">
            <div class="card-cotacao m-0">
                <div class="header-cotacao w-100">
                    <img src="<?php echo $baseUrl ?>app/public/img/favicon.png" alt="Ícone Cacau">
                    <div>
                        <div class="titulo">Cotação do Cacau Internacional (Mar 2025)</div>
                        <div style="display: flex; align-items: baseline;">
                            <span class="info-preco" id="valorAtual"></span>
                            <span class="info-variacao" id="variacaoValor"></span>
                            <span class="info-variacao" id="variacaoPercentual"></span>
                        </div>
                    </div>
                </div>
                <div class="grafico-container">
                    <canvas id="chartCacau"></canvas>
                </div>
            </div>
        </div>

        <!-- Lista de Cotações -->
        <div class="col-md-8">
            <div class="row"> 
                <h4 class="mb-3">Cotações anteriores</h4>
                <?php if (!empty($cotacoesAgrupadas)) { ?>
                    <?php foreach ($cotacoesAgrupadas as $cota) { ?>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header" style="background-color: <?php echo $corPrimaria; ?>; color: <?php echo $corSecundaria; ?>;">
                                    <h5 class="m-0"><?= htmlspecialchars($cota['data']) ?></h5>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-bordered table-sm m-0">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>Estado</th>
                                                <th>Preço (R$)</th>
                                                <th>Variação (%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cota['rows'] as $row) { ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['estado']) ?></td>
                                                    <td><?= htmlspecialchars($row['preco']) ?></td>
                                                    <td><?= htmlspecialchars($row['variacao']) ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="text-center mt-5">Nenhuma cotação encontrada.</p>
                <?php } ?>

            </div> 
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <h4 class="mb-3">Cotação Atual do Dólar</h4>
            <div class="card">
                <div class="card-body text-center">
                    <?php
                    // Obter a cotação atual do dólar
                    $urlDolar = 'https://api.exchangerate-api.com/v4/latest/USD';
                    $responseDolar = file_get_contents($urlDolar);
                    $dataDolar = json_decode($responseDolar, true);
                    $cotacaoDolar = $dataDolar['rates']['BRL'];
                    ?>
                    <p class="p-0 m-0">1 USD = <?= number_format($cotacaoDolar, 2, ',', '.') ?> BRL</p>
                </div>
            </div>

            <p class="titulo mb-3 mt-4">Anuncios</p>
            <div class="anuncio rounded bg-light mt-3 p-3" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <img src="https://www.radioprata.com.br/img/anuncios/0ba546216e44ed9b872bb8afd2be6434.jpg" class="img-fluid" alt="Anúncio 1">
            </div>
            <div class="anuncio rounded bg-light mt-3 p-3" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <img src="https://www.radioprata.com.br/img/anuncios/0ba546216e44ed9b872bb8afd2be6434.jpg" class="img-fluid" alt="Anúncio 2">
            </div>
            <div class="anuncio rounded bg-light mt-3 p-3" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <img src="https://www.radioprata.com.br/img/anuncios/0ba546216e44ed9b872bb8afd2be6434.jpg" class="img-fluid" alt="Anúncio 2">
            </div>
        </div>

    </div>
</div>

<!-- Script do Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper(".mySwiper", {
        effect: "fade",
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
});

let chart;
let historicalData = [];

async function fetchDataAndRenderChart(range) {
    let apiUrl;
    const chaveAPI = 'u1LYqBjMyajincYGGDNM7i3qUSUQOld6'; // se tiver outra key, substitua

    // Se for '1d', buscamos dados intraday (1min); caso contrário, histórico 30 dias
    if (range === '1d') {
        apiUrl = `https://financialmodelingprep.com/api/v3/historical-chart/1min/CCUSD?apikey=${chaveAPI}`;
    } else {
        apiUrl = `https://financialmodelingprep.com/api/v3/historical-price-full/CCUSD?timeseries=30&apikey=${chaveAPI}`;
    }

    try {
        const response = await fetch(apiUrl);
        const data = await response.json();

        if (range === '1d') {
            // intraday: array direto
            historicalData = data.reverse();
        } else {
            // daily: {symbol, historical: [{ date, close, ... }, ...]}
            if (!data.historical) {
                throw new Error("Dados históricos não disponíveis.");
            }
            historicalData = data.historical.slice(0,30).reverse();
        }

        const labels = historicalData.map(entry => entry.date);
        const prices = historicalData.map(entry => entry.close);

        // Atualizar os valores na div
        const valorAtual = prices[prices.length - 1];
        const valorAnterior = prices[prices.length - 2];
        const variacaoValor = (valorAtual - valorAnterior).toFixed(2);
        const variacaoPercentual = ((variacaoValor / valorAnterior) * 100).toFixed(2);

        document.getElementById('valorAtual').textContent = valorAtual.toFixed(2);
        document.getElementById('variacaoValor').textContent = variacaoValor;
        document.getElementById('variacaoPercentual').textContent = `${variacaoPercentual}%`;

        // Destruir gráfico anterior se existir
        if (chart) {
            chart.destroy();
        }

        const ctx = document.getElementById('chartCacau').getContext('2d');
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Preço (USD)',
                    data: prices,
                    fill: true,
                    backgroundColor: 'rgba(233, 229, 227, 0.7)',
                    borderColor: '#522b19',
                    borderWidth: 2,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                    pointHoverBackgroundColor: '#FFF',
                    pointHoverBorderColor: '#522b19',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#fff',
                        titleColor: '#000',
                        titleFont: { family: 'Anek Telugu', weight: 'bold' },
                        bodyColor: '#000',
                        borderColor: '#d4d2cf',
                        borderWidth: 1,
                        callbacks: {
                            label: function(tooltipItem) {
                                const valor = tooltipItem.parsed.y.toFixed(2);
                                return 'Preço: ' + valor + ' USD';
                            },
                            title: function(tooltipItems) {
                                return 'Data: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    legend: { display: true }
                },
                scales: {
                    x: {
                        display: true
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Preço (USD)'
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                }
            }
        });
    } catch (error) {
        console.error("Erro ao buscar dados:", error);
        // Se não houver canvas, ou erro geral, substitui
        const chartEl = document.getElementById('chartCacau');
        if (chartEl) {
            chartEl.outerHTML = "<p>Ocorreu um erro ao carregar o gráfico.</p>";
        }
    }
}

// Exemplo: busca 30 dias diários
fetchDataAndRenderChart('30d');
</script>