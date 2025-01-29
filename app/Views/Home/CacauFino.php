<style>
    .hero {
      position: relative;
      background: url('https://imagens-cdn.canalrural.com.br/wp-content/uploads/cacau-e-chocolate.jpg') no-repeat center center;
      background-size: cover;
      height: 60vh;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-shadow: 0 0 5px rgba(0, 0, 0, 0.7);
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0; 
      left: 0;
      width: 100%; 
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 1;
    }

    .hero > .text-center {
      position: relative;
      z-index: 2;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 700;
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 600px;
      text-align: center;
    }

    .card-header {
      background-color: #7B3F00;
      color: #fff;
    }

</style>
  
  <main class="content-wrapper">
    <header class="hero">
      <div class="text-center">
        <h1>Produção de Cacau Fino</h1>
        <p class="mt-3">
          Saiba mais sobre o processo de cultivo e preparo de um dos ingredientes mais apreciados no mundo.
        </p>
      </div>
    </header>
    <section class="content">
      <div class="container-fluid">

        <div class="row justify-content-center my-4 ">
          <div class="col-md-8 text-center">
            <h2 class="mb-3">O que é Cacau Fino?</h2>
            <p>
              O cacau fino é reconhecido pela sua alta qualidade, caracterizado por grãos cuidadosamente
              selecionados que apresentam sabores, aromas e texturas únicos. Geralmente produzido em menor
              escala, o cacau fino requer processos mais rigorosos de colheita e fermentação, resultando em
              um produto final de características sensoriais diferenciadas. Esse tipo de cacau é muito
              valorizado na produção de chocolates premium, apreciados por especialistas e consumidores
              que buscam experiências gastronômicas mais sofisticadas.
            </p>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-8 mb-4">
            <div class="card shadow">
              <div class="card-header">
                <h3 class="mb-0">Instruções para a Produção de Cacau Fino</h3>
              </div>
              <div class="card-body">
                <ol class="mt-2 text-justify">
                  <li class="mb-3"><strong>Seleção e Colheita:</strong> Escolha apenas os frutos maduros e saudáveis, evitando qualquer sinal de pragas ou fungos.</li>
                  <li class="mb-3"><strong>Fermentação:</strong> Os grãos devem ser fermentados em caixas ou sacos de juta, seguindo o tempo ideal para desenvolver sabores e aromas mais complexos.</li>
                  <li class="mb-3"><strong>Secagem:</strong> Após a fermentação, faça a secagem dos grãos em estufas ou ao sol, garantindo que percam a umidade de forma uniforme.</li>
                  <li class="mb-3"><strong>Armazenamento:</strong> Guarde os grãos em local fresco e seco, para manter a qualidade até o momento da torra e processamento.</li>
                  <li class="mb-3"><strong>Controle de Qualidade:</strong> Realize análises periódicas para avaliar sabor, aroma e textura, assegurando que o cacau atenda aos padrões de cacau fino.</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>