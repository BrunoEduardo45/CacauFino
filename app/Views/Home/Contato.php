<div class="content-wrapper">
  <section class="content">

    <div class="container-fluid p-3">

      <!-- Título da página -->
      <h3 class="text-center mt-3">Entre em Contato</h3>
      <hr class="w-50 mx-auto">

      <!-- Descrição -->
      <div class="row justify-content-center">
        <div class="col-md-8 text-center mb-4">
          <p>
            Estamos à disposição para esclarecer suas dúvidas, ouvir suas sugestões ou receber seu feedback. Preencha o formulário abaixo 
            ou entre em contato diretamente pelos nossos canais sociais.
          </p>
        </div>
      </div>

      <!-- Formulário de contato dentro de um card -->
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <form action="enviar-contato.php" method="POST">
                <div class="mb-3">
                  <label for="nome" class="form-label">Nome</label>
                  <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu nome completo" required>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">E-mail</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Seu e-mail" required>
                </div>
                <div class="mb-3">
                  <label for="mensagem" class="form-label">Mensagem</label>
                  <textarea class="form-control" id="mensagem" name="mensagem" rows="5" placeholder="Escreva sua mensagem aqui" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Enviar</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Informações de contato adicionais -->
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">

          <div class="mt-3">
            <h5>Informações de Contato</h5>
            <p>
              <strong>Endereço:</strong> São Miguel das Matas, Bahia, Brasil<br>
              <strong>E-mail:</strong> contato@exemplo.com<br>
              <strong>Telefone:</strong> +55 (71) 1234-5678
            </p>
          </div>
          
          <div class="mt-4">
            <a href="https://www.instagram.com/seu-perfil" target="_blank" class="btn btn-outline-dark mx-2">
              <i class="fab fa-instagram"></i> Instagram
            </a>
            <a href="https://wa.me/5517123456789" target="_blank" class="btn btn-outline-success mx-2">
              <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
          </div>

        </div>
      </div>

    </div>

  </section>
</div>
