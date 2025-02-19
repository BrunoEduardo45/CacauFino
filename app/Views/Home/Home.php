<?php

  $listaNoticias = selecionarDoBanco('noticias', '*', 'not_tipo = 1 AND not_status = 1 ORDER BY not_id DESC LIMIT 4');
  $listaEventos = selecionarDoBanco('noticias', '*', 'not_tipo = 2 AND not_status = 1 ORDER BY not_id DESC LIMIT 4');
  $listaBlog = selecionarDoBanco('noticias', '*', 'not_tipo = 3 AND not_status = 1 ORDER BY not_id DESC LIMIT 4');

  //////////////////////////////////////////////////////////////////

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

<div class="container my-4">

  <section id="hero" class="hero section dark-background rounded mb-4">
    <div class="swiper mySwiper" style="height: 400px;">
      <div class="swiper-wrapper">
        <!-- SLIDE 1 -->
        <div class="swiper-slide">
          <img src="https://cdn.divinechocolateria.com.br/media/wysiwyg/cacau-793125286.jpg" alt="">
          <div class="carousel-container">
            <h2 style="color: white;">Cacau Fino</h2>
            <p>Compartilhando conhecimento e unindo apaixonados pelo cacau brasileiro.</p>
          </div>
        </div>
        <!-- SLIDE 2 -->
        <div class="swiper-slide">
          <img src="https://www.ceara.gov.br/wp-content/uploads/2021/08/210806_CACAU-DO-CEARA__HS8591.jpg" alt="">
          <div class="carousel-container">
            <h2 style="color: white;">Sustentabilidade e qualidade</h2>
            <p>Práticas responsáveis e inovações para valorizar cada etapa do cultivo.</p>
          </div>
        </div>
        <!-- SLIDE 3 -->
        <div class="swiper-slide">
          <img src="https://static.portaldaindustria.com.br/portaldaindustria/noticias/media/16_9/plantacaodecacaumaltez.jpg" alt="">
          <div class="carousel-container">
            <h2 style="color: white;">Mercado e oportunidades</h2>
            <p>Insights, tendências e dicas para produtores e empreendedores do setor.</p>
          </div>
        </div>
      </div>
      <!-- Paginação e setas de navegação -->
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </section>

  <div class="row">

    <!-- COLUNA ESQUERDA: Cotação Nacional -->
    <div class="col-md-4">
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
    <div class="col-md-8">
      <div class="card-cotacao m-0">
        <div class="header-cotacao  w-100">
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

  </div>

  <div class="container my-4">

    <div class="row mt-4">

      <div class="col-lg-8">

        <!-- Noticias -->
        <div class="col-lg-12">

            <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
              <h3 class="m-0">Últimas Notícias</h3>
              <a href="noticias" class="btn btn-outline-dark p-2 m-0">Ver todas</a>
            </div>
            
            <?php foreach ($listaNoticias as $values) { ?>
              <div class="col-lg-12 mb-2">
                <a href="noticia?id=<?php echo $values['not_id']; ?>" class="card-cotacao h-100 d-block">
                  <div class="row no-gutters h-100">
                    <div class="col-md-4 post-img">
                      <img src="<?php echo $baseUrl . $values['not_url_imagem']; ?>" class="img-fluid" alt="<?php echo $values['not_titulo']; ?>">
                    </div>
                    <div class="col-md-8">
                      <div class="p-3">
                        <h5 class="titulo"><?php echo $values['not_titulo']; ?></h5>
                        <p class="descricao-limitada">
                          <?php echo strip_tags($values['not_descricao']); ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            <?php } ?>
            
        </div>

        <!-- Eventos -->
        <div class="col-lg-12 mt-5">

            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
              <h3 class="m-0">Últimos Eventos</h3>
              <a href="eventos" class="btn btn-outline-dark p-2 m-0">Ver todos</a>
            </div>

            <?php foreach ($listaEventos as $values) { ?>
              <div class="col-lg-12 mb-2">
                <a href="evento?id=<?php echo $values['not_id']; ?>" class="card-cotacao h-100 d-block">
                  <div class="row no-gutters h-100">
                    <div class="col-md-4 post-img">
                      <img src="<?php echo $baseUrl . $values['not_url_imagem']; ?>" class="img-fluid" alt="<?php echo $values['not_titulo']; ?>">
                    </div>
                    <div class="col-md-8">
                      <div class="p-3">
                        <h5 class="titulo"><?php echo $values['not_titulo']; ?></h5>
                        <p class="descricao-limitada">
                          <?php echo strip_tags($values['not_descricao']); ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            <?php } ?>

        </div>

        <!-- Blog -->
        <div class="col-lg-12 mt-5">

            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
              <h3 class="m-0">Últimas Postagens do Blog</h3>
              <a href="blog" class="btn btn-outline-dark p-2 m-0">Ver todas</a>
            </div>

            <?php foreach ($listaBlog as $values) { ?>
              <div class="col-lg-12 mb-2">
                <a href="evento?id=<?php echo $values['not_id']; ?>" class="card-cotacao h-100 d-block">
                  <div class="row no-gutters h-100">
                    <div class="col-md-4 post-img">
                      <img src="<?php echo $baseUrl . $values['not_url_imagem']; ?>" class="img-fluid" alt="<?php echo $values['not_titulo']; ?>">
                    </div>
                    <div class="col-md-8">
                      <div class="p-3">
                        <h5 class="titulo"><?php echo $values['not_titulo']; ?></h5>
                        <p class="descricao-limitada">
                          <?php echo strip_tags($values['not_descricao']); ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            <?php } ?>

        </div>
        
      </div>

      <div class="col-lg-4">
          <div class="h-100 mt-3">
              <h5 class="titulo">Anúncios</h5>
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