<?php

    $id = $id[0] ?? 0;
    $result = selecionarDoBanco('noticias', '*', 'not_id = :id LIMIT 1', ['id' => $id]);
    $defaultValues = ['not_id', 'not_titulo', 'not_descricao', 'not_data_publicacao', 'not_categoria', 'not_url_imagem', 'not_nome_imagem', 'not_status', 'not_usuario_id'];

    foreach ($defaultValues as $value) {
        ${$value} = ($result !== false && isset($result[0][$value])) ? $result[0][$value] : "";
    }

?>

<div class="content-wrapper">
    
    <section class="content pt-4">
        <form id="form" method="post">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <h3>Dados da Notícia</h3>
                                <hr>
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                                    <input type="hidden" id="not_usuario_id" name="not_usuario_id" value="<?php echo $IdUser ?>">
                                    <input type="hidden" id="not_data_publicacao" name="not_data_publicacao" value="<?php echo date('Y-m-d') ?>">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="not_titulo">Título</label>
                                            <input type="text" class="form-control" id="not_titulo" name="not_titulo" value="<?php echo $not_titulo ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div id="step01" class="form-group" style="height: 350px">
                                            <label class="form-label" for="not_descricao">Descrição</label>
                                            <div id="editor"><?php echo $not_descricao ?></div>
                                            <input type="hidden" id="not_descricao" name="not_descricao" value="">
                                        </div>
                                    </div>

                                    <div id="step04" class="col-lg-6">
                                        <div class="form-group">
                                            <label>Categoria</label>
                                            <select class="form-control" id="not_categoria" name="not_categoria">
                                                <?php
                                                $stmt = $pdo->prepare("SELECT * FROM categoria WHERE cat_status = 1");
                                                $stmt->execute();
                                                $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($list as $values) {
                                                ?>
                                                    <option value="<?php echo $values['cat_id'] ?>" <?php echo ($values['cat_id'] == $not_categoria) ? "selected" : ""; ?>><?php echo $values['cat_nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="not_status">Status</label>
                                            <select class="form-control" id="not_status" name="not_status" required>
                                                <option value="1" <?php echo ($not_status == 1) ? "selected" : ""; ?>>Ativo</option>
                                                <option value="0" <?php echo ($not_status == 0) ? "selected" : ""; ?>>Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>

                            </div>
                            <div class="card-footer">
                                <?php if ($id) { ?>
                                    <input type="hidden" id="Acao" name="Acao" value="atualizar">
                                <?php } else { ?>
                                    <input type="hidden" id="Acao" name="Acao" value="salvar">
                                <?php } ?>
                                <a href="<?php echo $baseUrl ?>lista-noticias" class="btn btn-warning"><i class="fas fa-arrow-left mr-2"></i> Voltar</a>
                                <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-save mr-2"></i> Salvar</button>
                                <?php if ($id) { ?>
                                    <button type="button" id="deleta" class="btn btn-danger ml-2" data-acao="deletar"><i class="fas fa-trash mr-2"></i> Deletar</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <label class="form-label" for="cadastro">Imagem</label>
                                <input type="hidden" id="not_nome_imagem" value="<?php echo $not_nome_imagem ?>">
                                <img src="" id="imagemPreview" class="img-fluid w-100 img-rounded mb-2 <?php echo $id == 0 ? 'd-none' : '' ?>">
                                <img src="<?php echo $baseUrl.$not_url_imagem ?>" id="imagemBanco" class="img-fluid w-100 img-rounded mb-2 <?php echo $id == 0 ? 'd-none' : '' ?>">

                                <label id="step07" class="btn btn-primary btn-block">Upload de Imagem
                                    <input type="file" id="imagem" name="image" class="image" hidden>
                                </label>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

</div>

<div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Cortar Imagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <img id="image" class="cropper-hidden" style="max-width:100%">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="crop">Cortar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $baseUrl ?>app/public/plugins/summernote/summernote-bs4.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/summernote/lang/summernote-pt-BR.min.js"></script>

<script>

    function Dados()    
    {
        // validação dos campos
        var dados = {
            'not_titulo': $("#not_titulo").val(),
            'not_descricao': $("#not_descricao").val(),
            'not_data_publicacao': $("#not_data_publicacao").val(),
            'not_categoria': $("#not_categoria").val(),
            'not_status': $("#not_status").val(),
            'not_usuario_id': $("#not_usuario_id").val(),
            'not_situacao': 2,
        };
        return dados;
    }

    $("#form").submit(function(e) {
        e.preventDefault();

        if ($("#imagemPreview").attr('src') == '' && $("#imagemBanco").attr('src') == '') {
            Notiflix.Notify.Failure('Adicione por favor uma imagem.');
            return false;
        }

        var texto = $('#editor').summernote('code');
        var textoSemEstilos = $('<div>').html(texto).find('*').removeAttr('style').end().html();
        $('#not_descricao').val(textoSemEstilos);
        //$('#not_descricao').val(texto);

        Notiflix.Loading.Pulse('Carregando...');

        var acao = $('#Acao').val();

        if(acao == "salvar"){
            var url = "/inserir-noticia";
        } else {
            var url = "/atualizacao-noticia";
        }

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id': $("#id").val(),
                'dados': Dados(),
                'nomeImagem': $("#not_nome_imagem").val(),
                'imagem': $('#imagemPreview').attr('src'),
            },
            success: function(data) {
                if (data.success != "") {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success(data.success);
                    setTimeout(function() {
                        window.location.href = "/lista-noticias";
                    }, 2000);
                } else {
                    Notiflix.Notify.Failure(data.error);
                    Notiflix.Loading.Remove();
                }
            },
            error: function(error) {
                if (error.success != "") {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success(error.success);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Notiflix.Notify.Failure(error.msg);
                    Notiflix.Loading.Remove();
                    console.error("Erro na requisição AJAX:", error);
                }
            }
        });
    });

    $('#deleta').click(function() {
        event.preventDefault();
        var id = $("#id").val();
        var acao = $("#deleta").data("acao");
        var nome = $("#not_nome_imagem").val();

        Notiflix.Confirm.Show(
            'Deletar',
            'Tem certeza que deseja deletar?',
            'Sim',
            'Não',
            function okCb() {
                Notiflix.Loading.Pulse('Carregando...');
                $.ajax({
                    type: "POST",
                    url: "/deletar-noticia",
                    data: {
                        'id': id,
                        'acao': acao,
                        'not_imagem_nome': nome
                    },
                    success: function(data) {
                        if (data.success != "") {
                            Notiflix.Loading.Remove();
                            Notiflix.Notify.Success(data.success);
                            setTimeout(function() {
                                window.location.href = "<?php echo $baseUrl ?>lista-noticias";
                            }, 2000);
                        } else {
                            Notiflix.Notify.Failure(data.error);
                            Notiflix.Loading.Remove();
                        }
                    },
                    error: function(error) {
                        console.error("Erro na requisição AJAX:", error);
                    }
                });
            },
            function cancelCb() {}, {},
        );

    });

    $(document).ready(function() {
        $('#editor').summernote({
            placeholder: 'Texto...',
            tabsize: 2,
            height: 250,
            lang: 'pt-BR',
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['picture', 'link', 'video']],
                ['view', ['fullscreen']]
            ]
        });

        <?php if(empty($id)){
            echo "$('#not_status').val('1')";
        } ?>

        var bs_modal = $('#modal');
        var image = document.getElementById('image');
        var cropper, reader, file;

        $("body").on("change", ".image", function(e) {
            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                bs_modal.modal('show');
            };

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        bs_modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 16 / 9,
                viewMode: 1,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });

        $("#crop").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    //var base64data = reader.result;
                    $("#imagemPreview").attr("src", reader.result);
                    $("#imagemBanco").attr("style", "display:none");
                    $("#imagemPreview").removeClass("d-none");
                    $("#nomeImagem").val("novaImagem");
                };
                bs_modal.modal('toggle');
            });
        });
    });
</script>
