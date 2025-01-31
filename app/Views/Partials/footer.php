<footer class="main-footer text-sm">
  <strong>Copyright &copy; <a href="<?php echo $siteEmpresa ?>"><?php echo $nomeEmpresa ?></a>.</strong>
  Todos os doreitos reservados
  <div class="float-right d-none d-sm-inline-block">
    <b>Versão:</b> <?php echo $versao ?>
  </div>
</footer>

</div>

<script src="<?php echo $baseUrl ?>app/public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/script/c337de081b.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/bootstrap/js/bootstrap.bundle.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-aio-2.7.0.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-2.7.0.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/icons/js/bootstrap-iconpicker.bundle.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/cropper/cropper.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/inputmask/jquery.inputmask.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/kinetic/kinetic.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/tour/jquery.enjoyhint.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/tour/enjoyhint.js"></script>
<script src="<?php echo $baseUrl ?>app/public/js/adminlte.js"></script>
<script src="<?php echo $baseUrl ?>app/public/js/main.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/summernote/summernote-bs4.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/summernote/lang/summernote-pt-BR.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  
    $.widget.bridge('uibutton', $.ui.button)

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
