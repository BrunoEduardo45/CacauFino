<?php

$joins = [
    'INNER JOIN tipo_usuario ON (tp_id = usu_tipo)'
];

$list = selecionarDoBanco('usuarios', '*', 'usu_id = :id', [':id' => $IdUser], $joins);

foreach ($list as $values) {
    $nome = $values['usu_nome'];
    $cpf = $values['usu_cpf'];
    $telefone = $values['usu_telefone'];
    $celular = $values['usu_celular'];
    $sexo = $values['usu_sexo'];
    $ativo = $values['usu_status'];
    $nivel = $values['usu_tipo'];
    $tipo = $values['tp_nome'];
    $imagemNome = $values['usu_imagem_nome'];
    $imagemURL = $values['usu_imagem_url'];
}

?>

<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <form id="formUsu" method="post">
                <div class="row">
                    <div class="col-lg-9">

                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <h3>Dados do Usuário</h3>
                                <hr>
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo $IdUser ?>" />
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="cpf">CPF</label>
                                            <input type="cpf" class="form-control" id="cpf" name="cpf" value="<?php echo $cpf ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="tipo">Tipo de Usuário</label>
                                            <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo" value="<?php echo $tipo ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="telefone">Telefone</label>
                                            <input type="text" class="form-control telefone" id="telefone" name="telefone" placeholder="(99) 9999-9999" value="<?php echo $telefone ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="celular">Celular</label>
                                            <input type="text" class="form-control celular" id="celular" name="celular" placeholder="(99) 9999-9999" 
                                            value="<?php echo $celular ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="sexo">Sexo</label>
                                            <select class="form-control" id="sexo" name="sexo">
                                                <option value="">Selecione</option>
                                                <option value="masculino" <?php echo ($sexo == 'masculino') ? "selected" : ""; ?>>Masculino</option>
                                                <option value="feminino" <?php echo ($sexo == 'feminino') ? "selected" : ""; ?>>Feminino</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label class="form-label" for="senha">Senha</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="senha" name="senha" placeholder="" value="">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button" onclick="toggleSenha()"><i class="far fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" id="Acao" name="Acao" value="atualizar">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Salvar Informações</button>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <h3>Foto</h3>
                                <hr class="mb-0">
                                <input type="hidden" id="imagemNome" name="imagemNome" value="<?php echo $imagemNome ?>">
                                <input type="hidden" id="dadosImagem" name="dadosImagem" value="">
                                <img src="" id="imagemPreview" name="imagemPreview" class="img-fluid w-100 rounded-circle mb-3">
                                <img src="<?php echo $imagemURL ?>" id="imagemBanco" class="img-fluid w-100 rounded-circle mb-3">
                                <label id="step07" class="btn btn-primary btn-block"><i class="fas fa-upload"></i> Upload
                                    <input type="file" id="imagem" name="image" class="image" hidden>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<div class="modal fade" id="modalImagem" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                        <!--  default image where we will set the src via jquery-->
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

<script>

    function toggleSenha() {
      var senhaInput = document.getElementById("senha");
      if (senhaInput.type === "password") {
        senhaInput.type = "text";
      } else {
        senhaInput.type = "password";
      }
    }

    $(document).ready(function() {

        var bs_modal = $('#modalImagem');
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
                aspectRatio: 1 / 1,
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
                    var base64data = reader.result;
                    $("#imagemPreview").attr("src", reader.result);
                    $("#dadosImagem").val(reader.result);
                    $("#nomeImagem").val("novaIamgem");
                    $("#imagemBanco").addClass("d-none");
                    

                    $.ajax({
                        type: "POST",
                        url: "/imagem-perfil",
                        data: {
                            'dadosImagem': base64data,
                            'id': $("#id").val()
                        },
                        success: function(data) {
                            debugger;
                            if (data.acao == 'ok') {
                                Notiflix.Loading.Remove();
                                Notiflix.Notify.Success('Imagem atualizada com Sucesso!');
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                Notiflix.Notify.Failure(data.msg);
                                Notiflix.Loading.Remove();
                            }
                        },
                        error: function(error) {
                            // Lida com erros, se houverem
                            debugger;
                            console.error("Erro na requisição AJAX:", error);
                        }
                    });


                };
                bs_modal.modal('toggle');
            });
        });
    });

    function Dados()
    {
        var senha = $('#senha').val();

        if(senha == '') {
            return {
                'usu_nome': $('#nome').val() ?? null, 
                'usu_telefone': $('#telefone').val() ?? null, 
                'usu_celular': $('#celular').val() ?? null, 
                'usu_sexo': $('#sexo').val() ?? null, 
            };
        } else {
            return {
                'usu_nome': $('#nome').val() ?? null, 
                'usu_telefone': $('#telefone').val() ?? null, 
                'usu_celular': $('#celular').val() ?? null, 
                'usu_sexo': $('#sexo').val() ?? null, 
                'usu_senha': $('#senha').val() ?? null, 
            };
        }
        
    }

    $("#formUsu").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        var id = $('#id').val();
        var dados = Dados();

        $.ajax({
            type: "POST",
            url: "/atualizar-usuario",
            data: {dados: dados, id: id},
            dataType: "json",
            success: function(data) {
                debugger;
                if (data.success == 'Atualizado com sucesso!') {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success('Usuário atualizado com Sucesso!');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Notiflix.Notify.Failure(data.msg);
                    Notiflix.Loading.Remove();
                }
            },
            error: function(error) {
                // Lida com erros, se houverem
                debugger;
                console.error("Erro na requisição AJAX:", error);
            }
        });

    });
</script>