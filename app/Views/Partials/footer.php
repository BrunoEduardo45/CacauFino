</div>

<footer id="footer" class="footer light-background">
    <div class="footer-top" style="background-color: <?php echo $corPrimaria ?>; color: <?php echo $corSecundaria ?>;">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="<?php echo $baseUrl ?>" class="logo d-flex align-items-center">
                        <span class="sitename" style="color: <?php echo $corSecundaria ?>;">Cacau Fino</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Rua das Amendoeiras, 123</p>
                        <p>Bahia, Brasil</p>
                        <p class="mt-3"><strong>Telefone:</strong> <span>+55 71 99999-9999</span></p>
                        <p><strong>Email:</strong> <span>contato@cacaufino.com.br</span></p>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4 style="color: <?php echo $corSecundaria ?>;">Links Úteis</h4>
                    <ul>
                        <li><a href="<?php echo $baseUrl ?>">Home</a></li>
                        <li><a href="<?php echo $baseUrl ?>sobre">Sobre</a></li>
                        <li><a href="<?php echo $baseUrl ?>servicos">Serviços</a></li>
                        <li><a href="<?php echo $baseUrl ?>termos">Termos de Serviço</a></li>
                        <li><a href="<?php echo $baseUrl ?>politica">Política de Privacidade</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4 style="color: <?php echo $corSecundaria ?>;">Produtos</h4>
                    <ul>
                        <li><a href="<?php echo $baseUrl ?>produtos">Produtos</a></li>
                        <li><a href="<?php echo $baseUrl ?>cacaus">Cacau</a></li>
                        <li><a href="<?php echo $baseUrl ?>cotacoes">Cotações</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4 style="color: <?php echo $corSecundaria ?>;">Notícias e Eventos</h4>
                    <ul>
                        <li><a href="<?php echo $baseUrl ?>noticias">Notícias</a></li>
                        <li><a href="<?php echo $baseUrl ?>eventos">Eventos</a></li>
                        <li><a href="<?php echo $baseUrl ?>blog">Blog</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-3 footer-links">
                    <h4 style="color: <?php echo $corSecundaria ?>;">Contato</h4>
                    <ul>
                        <li><a href="<?php echo $baseUrl ?>contato">Fale Conosco</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="copyright text-center"  style="background-color: <?php echo $corSecundaria ?>; color: <?php echo $corPrimaria ?>;">
        <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
            <div class="d-flex flex-column align-items-center align-items-lg-start">
                <div>
                    <strong>Copyright &copy; <a href="<?php echo $siteEmpresa ?>" style="color: white;">Cacau Fino</a>.</strong>
                    Todos os direitos reservados
                </div>
            </div>
            
            <div class="social-links order-first order-lg-last mb-3 mb-lg-0" style="color: white;">
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="<?php echo $baseUrl ?>app/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/vendor/php-email-form/validate.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/vendor/glightbox/js/glightbox.min.js"></script>

<script src="<?php echo $baseUrl ?>app/public/js/main.js"></script>

<script src="<?php echo $baseUrl ?>app/public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/inputmask/jquery.inputmask.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/datatables/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/tour/jquery.enjoyhint.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/script/c337de081b.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-aio-2.7.0.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/icons/js/bootstrap-iconpicker.bundle.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/cropper/cropper.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/kinetic/kinetic.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/tour/enjoyhint.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/summernote/summernote-bs4.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/summernote/lang/summernote-pt-BR.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

<script>
    // Remove o preloader após a página carregar
    window.addEventListener("load", function() {
        var preloader = document.getElementById("preloader");
        if (preloader) {
            preloader.style.display = "none";
        }
    });
  
    $(document).ready(function() {
        $(".celular").inputmask("(99) 99999-9999");
        $(".telefone").inputmask("(99) 9999-9999");
        $(".cpf").inputmask("999.999.999-99");
        $(".cnpj").inputmask("99.999.999/9999-9")
    });

    $('#datatable').DataTable({
        "language": {
            "decimal": ",",
            "thousands": ".",
            "emptyTable": "Nenhum dado disponível na tabela",
            "info": "Mostrando _START_ até _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 até 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros no total)",
            "infoPostFix": "",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "loadingRecords": "Carregando...",
            "processing": "Processando...",
            "search": "Buscar:",
            "zeroRecords": "Nenhum registro encontrado",
            "paginate": {
                "first": "Primeiro",
                "last": "Último",
                "next": "Próximo",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": ativar para ordenar a coluna em ordem crescente",
                "sortDescending": ": ativar para ordenar a coluna em ordem decrescente"
            }
        }
    });

</script>

</body>

</html>

