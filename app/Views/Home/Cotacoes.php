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

<div class="container mt-5">

    <h2 class="text-center">Cotações do Cacau</h2>
    <?php 
        if (!empty($cotacoesAgrupadas)): 
    ?>
        <?php 
            foreach ($cotacoesAgrupadas as $cota): 
        ?>

        <h4 class="mt-5"><?= htmlspecialchars($cota['data']) ?></h4>
        <table class="table table-bordered mb-5">
            <thead class="table-secondary">
                <tr style="background-color: <?php echo $corPrimaria; ?> !important;">
                    <th>Estado</th>
                    <th>Preço (R$)</th>
                    <th>Variação (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($cota['rows'] as $row): 
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['estado']) ?></td>
                    <td><?= htmlspecialchars($row['preco']) ?></td>
                    <td><?= htmlspecialchars($row['variacao']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center mt-5">Nenhuma cotação encontrada.</p>
    <?php endif; ?>
</div>
