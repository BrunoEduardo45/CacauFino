<style>
  .card {
      border-radius: 10px;
      overflow: hidden;
  }

  .card-body {
      padding: 20px;
  }

  .card-title {
      font-size: 1.5rem;
      margin-bottom: 15px;
  }

  .card-text {
      font-size: 1rem;
      color: #555;
  }

  .input-group-text {
      background-color: #f8f9fa;
      border: 1px solid #ced4da;
  }

  .input-group .form-control {
      border-left: 0;
  }

  h2, h5 {
      color: #333;
  }

  h5 {
      color: #555;
  }

  blockquote {
      font-size: 1.2rem;
      color: #333;
      border-left: 5px solid #ddd;
      padding-left: 15px;
  }
</style>

<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid p-3">

      <!-- Título da página -->
      <h2 class="text-center fw-bold">Entre em Contato</h2>
      <hr class="w-50 mx-auto mb-4">

      <!-- Descrição -->
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-4">
          <p class="lead">
            Estamos à disposição para esclarecer suas dúvidas, ouvir suas sugestões ou receber seu feedback. Preencha o formulário abaixo 
            ou entre em contato diretamente pelos nossos canais sociais.
          </p>
        </div>
      </div>

      <!-- Formulário de contato dentro de um card elegante -->
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <h5 class="card-title text-center mb-3">Envie sua Mensagem</h5>
              <form action="enviar-contato.php" method="POST">
                <div class="mb-3">
                  <label for="nome" class="form-label">Nome</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu nome completo" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">E-mail</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Seu e-mail" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="mensagem" class="form-label">Mensagem</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-comment"></i></span>
                    <textarea class="form-control" id="mensagem" name="mensagem" rows="5" placeholder="Escreva sua mensagem aqui" required></textarea>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Enviar Mensagem</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Informações de contato adicionais -->
      <div class="row justify-content-center mt-5">
        <div class="col-lg-6 text-center">
          <div class="card shadow-sm border-0 p-4">
            <h5 class="fw-bold">Informações de Contato</h5>
            <p class="mb-2"><strong>E-mail:</strong> contato@cacaufino.com.br</p>
            <p><strong>Telefone:</strong> +55 (75) 8199-8080</p>

            <!-- Redes Sociais -->
            <div class="mt-3 d-flex justify-content-center gap-3">
              <a href="https://www.instagram.com/cacaufino" target="_blank" class="btn btn-outline-dark">
                <i class="fab fa-instagram"></i> Instagram
              </a>
              <a href="https://wa.me/557581998080" target="_blank" class="btn btn-outline-success">
                <i class="fab fa-whatsapp"></i> WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
