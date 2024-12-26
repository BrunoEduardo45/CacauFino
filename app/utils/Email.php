<?php

function enviarPush($idUsuario, $tituloPush, $mensagemPush, $urlPush)
{

    $baseDir = dirname(__FILE__);
    include $baseDir . "/../utils/Database.php";

    $stmt = $pdo->prepare("SELECT usu_token FROM usuarios WHERE usu_id = ? LIMIT 1");
    $stmt->execute([$idUsuario]);
    $count = $stmt->rowCount();

    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dados as $values) {
        $token = $values['usu_token'];
    }

    if ($count > 0) {

        $url = "https://fcm.googleapis.com/fcm/send";

        $server_key = "AAAAt1HwTjc:APA91bHqb2FyDnBbYhRrZcGj0YW8pqxdVIYNLkFlYPXhX3eEupBKlEN3P0z6sm30uWe72CxrM7paQXrelAxyXa4CPbvobz_S6C3KQs057-t9EF95weQy5yKToYYuammI-QYCcXk20fVC";

        $message = array(
            "data" => array(
                "title" => "$tituloPush",
                "body" => "$mensagemPush",
                "icon" => "https://cdn-icons-png.flaticon.com/512/1041/1041916.png",
                "image" => "https://images.unsplash.com/photo-1543702404-38c2035462ad?auto=format&fit=crop&q=80&w=1740&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                "click_action" => "$urlPush"
            ),
            "registration_ids" => [
                "$token"
            ]
        );

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true, // Adicione esta linha
            //CURLOPT_VERBOSE => false, // Adicione esta linha para desativar logs
            CURLOPT_HTTPHEADER => array(
                "Authorization: key=" . $server_key,
                "Content-Type: application/json",
            ),
            CURLOPT_POSTFIELDS => json_encode($message),
        );

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        if ($response === false) {
            //echo "erro ao enviar mensagem " . curl_error($curl);
            sendTelegramMessage("Erro ao enviar mensagem " . curl_error($curl));
        } else {
            //echo "Mensagem enviada com sucesso";
            //sendTelegramMessage("Push enviado com sucesso");
        }

        curl_close($curl);

    }
}

function sendTelegramMessage($e)
{

    $baseDir = dirname(__FILE__);
    include $baseDir . "/../utils/Database.php";

    $errorMessage = 

        '⚠️ ATENÇÃO FALHA NO SISTEMA! ⚠️

        ❌ ERRO: ' . $e->getMessage() . '

        ⚙️ FUNÇÃO: '. $e->getTrace()[1]['function'] . '

        📂 ARQUIVO: ' . $e->getTrace()[1]['file'] . '  

        📍 LINHA: ' . $e->getTrace()[1]['line'];

    $url = "https://api.telegram.org/bot" . $TokenTelegram . "/sendMessage";
    $data = [
        'chat_id' => $chatIdTelegram,
        'text' => $errorMessage,
    ];

    $options = [
        'http' => [
            'header' => "Content-Type:application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result !== false;
}

function ErroSystem($erro, $msg, $line)
{

    $baseDir = dirname(__FILE__);
    include $baseDir . "/../utils/Database.php";

    $nomeMail = $nomeSistema;
    $assunto = 'Erro no sistema';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=uft-8' . "\r\n";
    $headers .= 'From: ' . $nomeMail . ' <' . $emailPadrao . '>' . "\r\n";

    $mensagem = 'Erro: ' . $erro . '<br> 
                Mensagem: ' . $msg . '<br> 
                Linha: ' . $line . '<hr>';

    $enviaremail = mail($emailMal, $assunto, $mensagem, $headers);
    if ($enviaremail) {
        //echo "Sucesso";
    } else {
        //echo "Erro";
    }
}

function NovoCadastro($nome, $email, $telefone, $celular, $nomeIgreja, $emailIgreja)
{
    $baseDir = dirname(__FILE__);
    include $baseDir . "/../utils/Database.php";

    //$nomeMail = $nomeSistema;
    $assunto = '💬 Novo Membro Cadastrado';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=uft-8' . "\r\n";
    $headers .= 'From: ' . $nomeIgreja . ' <' . $emailIgreja . '>' . "\r\n";

    $mensagem = '<body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1; font-family: sans-serif; font-weight: 400; font-size: 15px; line-height: 1.8; color: rgba(0, 0, 0, .6); min-height: 600px">
        <div style="width: 100%; background-color: #f1f1f1;">
            <div style="max-width: 600px; margin: 0 auto;">
                <div align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="padding-top: 30px;">
                <div style="padding:2em 0 2em 0;background:#343a40;border-radius:20px 20px 0px 0px">
                    <img src="' . $baseUrl . $urlLogo . '" alt=" ' . $nomeSistema . ' " width="300">
                </div>
                    <div style="padding: 2em 0 4em 0; background: #ffffff; border-radius: 20px 20px 0px 0px; padding-top: 20px;">
                        <div style="padding: 0 2.5em; text-align: center; color: rgba(0, 0, 0, .6)">
                      
                            <h2>Novo Membro Cadastrado no Sistema</h2>
                            <h4>Segue abaixo as informações</h4>
                            <p>Nome: ' . $nome . '<br>
                            Telefone: ' . $telefone . '<br>
                            Celular: ' . $celular . '<br>
                            E-mail: ' . $email . '</p>
                            <p><strong>Observação:</strong> Acesse o painel para liberar o cadastro do novo membro.</p>
                            <p>
                                <a href="' . $baseUrl . '" style="padding: 10px 15px; display: inline-block;border-radius: 5px; background: #9c27b0; color: #ffffff; text-decoration: none;">
                                    Painel de Controle
                                </a>
                            </p>
                        </div>
                    </div>
                    <div style="text-align: center; background: #f7fafa; padding: 10px; border-radius: 0px 0px 20px 20px;">
                        <p>Sistema desenvolvido por <a href="' . $siteEmpresa . '" style="color: rgba(0,0,0,.8); font-weight: bold; text-decoration: none">' . $nomeEmpresa . '</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>';

    $enviaremail = mail($emailPadrao, $assunto, $mensagem, $headers);
    if ($enviaremail) {
        //echo "Sucesso";
    } else {
        //echo "Erro";
    }
}

function Bemvindo($email, $senha, $nomeIgreja, $emailIgreja)
{
    $baseDir = dirname(__FILE__);
    include $baseDir . "/../utils/Database.php";

    //$nomeMail = $nomeSistema;
    $assunto = '😉 Olá! Bem-Vindo ao Meu Cartão Online';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=uft-8' . "\r\n";
    $headers .= 'From: ' . $nomeIgreja . ' <' . $emailIgreja . '>' . "\r\n";
    $headers .= 'Bcc: Novo Cadastro <$emailEmrpesa>';

    $mensagem = '<body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1; font-family: sans-serif; font-weight: 400; font-size: 15px; line-height: 1.8; color: rgba(0, 0, 0, .6); min-height: 650px"">
        <div style="width: 100%; background-color: #f1f1f1;">
            <div style="max-width: 600px; margin: 0 auto;">
                <div align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="padding-top: 30px;">
                <div style="padding:2em 0 2em 0;background:#343a40;border-radius:20px 20px 0px 0px">
                    <img src="' . $baseUrl . $urlLogo . '" alt=" ' . $nomeSistema . ' " width="300">
                </div>
                    <div style="padding: 2em 0 4em 0; background: #ffffff; border-radius: 20px 20px 0px 0px; padding-top: 20px;">
                        <div style="padding: 0 2.5em; text-align: center; color: rgba(0, 0, 0, .6)">
                            
                            <h2>Bem-vindo!</h2>
                            <h4>Segue abaixo informações para você acessar o painel</h4>
                            <p>Login: ' . $email . '<br>
                            Senha: ' . $senha . '</p>
                            <p>
                                <a href="' . $baseUrl . '" style="padding: 10px 15px; display: inline-block;border-radius: 5px; background: #9c27b0; color: #ffffff; text-decoration: none;">
                                    Painel de Controle
                                </a>
                            </p>
                            <p><strong>Observação:</strong> Aguarde a liberação de acesso.</p>
                        </div>
                    </div>
                    <div style="text-align: center; background: #f7fafa; padding: 10px; border-radius: 0px 0px 20px 20px;">
                        <p>Sistema desenvolvido por <a href="' . $siteEmpresa . '"
                                style="color: rgba(0,0,0,.8); font-weight: bold; text-decoration: none">' . $nomeEmpresa . '</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>';

    $enviaremail = mail($email, $assunto, $mensagem, $headers);
    if ($enviaremail) {
        //echo "Sucesso";
    } else {
        //echo "Erro";
    }
}

function ResetarSenhaEmail($email, $senha)
{
    $baseDir = dirname(__FILE__);
    include $baseDir . "/../utils/Database.php";

    $nomeMail = $nomeSistema;
    $assunto = "🔒 Reset de Senha";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=uft-8' . "\r\n";
    $headers .= 'From: ' . $nomeMail . ' <' . $emailPadrao . '>';

    $mensagem = '<body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1; font-family: sans-serif; font-weight: 400; font-size: 15px; line-height: 1.8; color: rgba(0, 0, 0, .6); min-height: 650px"">
        <div style="width: 100%; background-color: #f1f1f1;">
            <div style="max-width: 600px; margin: 0 auto;">
                <div align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="padding-top: 30px;">
                <div style="padding:2em 0 2em 0;background:#343a40;border-radius:20px 20px 0px 0px">
                    <img src="' . $baseUrl . $urlLogo . '" alt=" ' . $nomeSistema . ' " width="300">
                </div>
                    <div style="padding: 2em 0 2em 0; background: #ffffff;padding-top:20px">
                        <div style="padding: 0 2.5em; text-align: center; color: rgba(0, 0, 0, .6)">
                            <h2>Senha resetada com Sucesso!</h2>
                            <h4>Segue abaixo sua nova senha para acessar o painel</h4>
                            <p>Login: ' . $email . '<br>
                            Nova Senha: ' . $senha . '</p>
                            <p>
                                <a href="' . $baseUrl . '" style="padding: 10px 15px; display: inline-block;border-radius: 5px; background: #9c27b0; color: #ffffff; text-decoration: none;">
                                    Painel de Controle
                                </a>
                            </p>
                            <p><strong>Observação:</strong> Não esqueça de alterar sua senha no primeiro acesso.</p>
                        </div>
                    </div>
                    <div style="text-align: center; background: #f7fafa; padding: 10px; border-radius: 0px 0px 20px 20px;">
                        <p>Sistema desenvolvido por <a href="' . $siteEmpresa . '"
                                style="color: rgba(0,0,0,.8); font-weight: bold; text-decoration: none">' . $nomeEmpresa . '</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>';


    $enviaremail = mail($email, $assunto, $mensagem, $headers);
    if ($enviaremail) {
        //echo "Sucesso";
    } else {
        //echo "Erro";
    }
}

function ContatoCard($emailCard, $nome, $email, $celular, $assunto, $mensagem)
{
    $baseDir = dirname(__FILE__);
    include $baseDir . "/../utils/Database.php";

    $Empresa = $nomeSistema;
    $assuntoMail = "💬 Você recebeu uma mensagem";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=uft-8' . "\r\n";
    $headers .= 'From: ' . $Empresa . ' <' . $emailCard . '>';

    $mensagemMail = '<body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1; font-family: sans-serif; font-weight: 400; font-size: 15px; line-height: 1.8; color: rgba(0, 0, 0, .6); min-height: 750px"">
        <div style="width: 100%; background-color: #f1f1f1;">
            <div style="max-width: 600px; margin: 0 auto;">
                <div align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="padding-top: 30px;">
                <div style="padding:2em 0 2em 0;background:#343a40;border-radius:20px 20px 0px 0px">
                    <img src="' . $baseUrl . $urlLogo . '" alt=" ' . $nomeSistema . ' " width="300">
                </div>
                    <div style="padding: 2em 0 4em 0; background: #ffffff; border-radius: 20px 20px 0px 0px;">
                        <div style="padding: 0 2.5em; text-align: center; color: rgba(0, 0, 0, .6)">
                            <h2>Você recebeu uma mensagem!</h2>
                            <p style="text-align: left; margin: 15px; padding: 18px; background: #f1f1f1; border-radius: 15px;">
                            <strong>Nome:</strong> ' . $nome . ' <br>
                            <strong>E-mail:</strong> ' . $email . ' <br>
                            <strong>Contato:</strong> ' . $celular . ' <br>
                            <strong>Assunto:</strong> ' . $assunto . ' <br>
                            <strong>Mensagem:</strong> ' . $mensagem . '</p>
                            <h4>Acesse o painel para visualizar outras mensagens!</h4>
                            <p>
                                <a href="' . $baseUrl . '" style="padding: 10px 15px; display: inline-block;border-radius: 5px; background: #9c27b0; color: #ffffff; text-decoration: none;">
                                    Painel de Controle
                                </a>
                            </p>
                        </div>
                    </div>
                    <div style="text-align: center; background: #f7fafa; padding: 10px; border-radius: 0px 0px 20px 20px;">
                        <p>Sistema desenvolvido por <a href="' . $siteEmpresa . '"
                                style="color: rgba(0,0,0,.8); font-weight: bold; text-decoration: none">' . $nomeEmpresa . '</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>';


    $enviaremail = mail($emailCard, $assuntoMail, $mensagemMail, $headers);
    if ($enviaremail) {
        //echo "Sucesso";
    } else {
        //echo "Erro";
    }
}
