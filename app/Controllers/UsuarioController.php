<?php

global $tabela;     $tabela = 'usuarios';
global $sigla;      $sigla = 'usu';

class UsuarioController extends Actions {

    //Paginas
    public function LoginPage(){
        global $tabela;
        loadView('Login', $tabela, [], false, false, false);
    } // ok

    public function Registro(){
        global $tabela;
        loadView('registro', $tabela, [], false, false, false);
    } // ok

    public function Resetar(){
        global $tabela;
        loadView('resetar-senha', $tabela, [], false, false, false);
    } // ok

    public function Perfil(){
        global $tabela;
        loadView('usuario', $tabela);
    } //ok

    public function Listar(){
        global $tabela;
        loadView('ListaUsuarios', $tabela);
    } //ok

    public function CadastrarUsuario(){
        global $tabela;
        loadView('cadastrarUsuario', $tabela);
    } // ok

    //Ação
    public function Login(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            session_start();

            $baseDir = dirname(__FILE__);
            include $baseDir . "/../utils/Database.php";
                
            $usuariocpf = $_POST['cpf'];
            $senhausuario = $_POST['senha'];
        
            $sql = selecionarDoBanco('usuarios', '*', 'usu_cpf = :cpf LIMIT 1', [':cpf' => $usuariocpf]);
            $total = count($sql);
        
            if ($total > 0) {
        
                foreach ($sql as $value) {
                    $usuID = $value['usu_id'];
                    $usuCPF = $value['usu_cpf'];
                    $usuSenha = $value['usu_senha'];
                    $usuNome = $value['usu_nome'];
                    $usuTipo = $value['usu_tipo'];
                    $usuStatus = $value['usu_status'];
                    $comprador = $value['usu_comprador'];
                    $vendedor = $value['usu_vendedor'];
                }
        
                if ($usuStatus == 2) {
                    $data = ['resultado' => 'aguardando', 'msg' => 'Atenção!'];
                    header('Content-type: application/json');
                    echo json_encode($data);
                    return false;

                } else if ($usuStatus == 3) {
                    $data = ['resultado' => 'reprovado', 'msg' => 'Atenção!'];
                    header('Content-type: application/json');
                    echo json_encode($data);
                    return false;

                } else if ($usuStatus == 4) {
                    $data = ['resultado' => 'bloqueado', 'msg' => 'Atenção!'];
                    header('Content-type: application/json');
                    echo json_encode($data);

                } else {
        
                    if (password_verify($senhausuario, $usuSenha)) {
        
                        //criptografia dos cookies
                        $cookies = [
                            "id" => $usuID,
                            "usuario" => $usuNome,
                            "tipo" => $usuTipo,
                            "cpf" => $usuCPF,
                            "comprador" => $comprador ?? 0,
                            "vendedor" => $vendedor ?? 0,
                        ];
                        
                        $expirationTime = time() + (86400 * 30);
                        
                        foreach ($cookies as $nome => $valor) {
                            $valorCriptografado = encryptData($valor, $encryptionKey);
                            setcookie($nome, $valorCriptografado, $expirationTime, "/");
                        }

                        $_SESSION['logged_in'] = true;
        
                        $data = ['resultado' => 'sucesso', 'msg' => 'OK!', 'nivel' => $usuTipo];
                        header('Content-type: application/json');
                        echo json_encode($data);
                    } else {
                        $data = ['resultado' => 'erro', 'msg' => 'Usuário ou Senha invalido!'];
                        header('Content-type: application/json');
                        echo json_encode($data);
                    }
                }
            } else {
        
                $data = ['resultado' => 'erro', 'msg' => 'Usuário ou Senha invalido!'];
                header('Content-type: application/json');
                echo json_encode($data);
            }
        }
    } //ok

    public function Logout($idUser){
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";

        setcookie("id", "null", 0, "/");
        setcookie("usuario", "null", 0, "/");
        setcookie("nivel", "null",  0, "/");
        setcookie("cpf", "null",  0, "/");

        if(!isset($_SESSION)){
            session_start();
        }

        session_unset();
        session_destroy();
        header("location: /");
    } //ok

    function Verificar(){
        $cpf = (isset($_POST['cpf']) ? $_POST['cpf'] : "");
        $dados = selecionarDoBanco('usuarios','*','usu_cpf = '.$cpf.' LIMIT 1');
        $count = $dados != null ? count($dados) : 0;

        if ($count == 0) {
            $data = ['acao' => 'ok'];
            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data = ['acao' => 'erro'];
            header('Content-type: application/json');
            echo json_encode($data);
        }
    } //ok

    public function InserirUsuario(){
        $dados = $_POST['dados'];
        $dados['usu_senha'] = password_hash($dados['usu_senha'], PASSWORD_DEFAULT, $options = ['cost' => 12]);
        $id = inserirNoBanco('usuarios', $dados, false);

        if ($id != 0) {
            $data = ['acao' => 'ok'];
            header('Content-type: application/json');
            echo json_encode($data);
        }
    } //ok

    public function DeletarUsuario(){
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";
        $Id = $_POST['Id'];
        try {
            $pdo->beginTransaction();
            //deleta o usuario
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE usu_id = ?");
            $stmt->execute([$Id]);
            $pdo->commit();

            $data = ['acao' => 'deletado'];
            header('Content-type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    } //ok

    function AtualizarUsuario(){
        $dados = $_POST['dados'];
        $id = $_POST['id'];
        if(isset($dados['usu_senha'])) {
            $dados['usu_senha'] = password_hash($dados['usu_senha'], PASSWORD_DEFAULT, $options = ['cost' => 12]);
        }
        atualizarNoBanco('usuarios', $dados, 'usu_id = '. $id);
    } //ok

    public function Visualizar(){
        $Id = $_POST['Id'];
        $dados = selecionarDoBanco('usuarios','*','usu_id = '.$Id.' LIMIT 1');
        header('Content-type: application/json');
        echo json_encode($dados);
    } //ok

    function UpdateAdm()
    {
        $id = $_POST['id'];
        $dados = $_POST['dados'];
        atualizarNoBanco('usuarios', $dados, 'usu_id = '.$id);
    } //ok

    public function ResetarSenha(){
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";
        $cpf = $_POST['cpf'];
        try {

            $dados = selecionarDoBanco('usuarios','usu_cpf','usu_cpf = '.$cpf.' LIMIT 1');
            $count = count($dados);

            if ($count != 0) {
                $senha = bin2hex(random_bytes(6));
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT, $options = ['cost' => 12]);

                $pdo->beginTransaction();
                $sql = $pdo->prepare("UPDATE usuarios SET usu_senha = ?, usu_update = now(), usu_erro = 0 WHERE usu_cpf = ?");
                $sql->execute([$senhaHash, $cpf]);
                $pdo->commit();

                ResetarSenhaEmail($cpf, $senha);

                $data = ['acao' => 'ok'];
                header('Content-type: application/json');
                echo json_encode($data);
            } else {
                $data = ['acao' => 'erro'];
                header('Content-type: application/json');
                echo json_encode($data);
            }
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    }

    function imagemPerfil(){
        $baseDir = dirname(__FILE__);
        include $baseDir . "/../utils/Database.php";
        $Id         = (isset($_POST['id']) ? $_POST['id'] : "");
        $imagem64    = (isset($_POST['dadosImagem']) ? $_POST['dadosImagem'] : "");
        try {
            if ($imagem64 != ""){
                $where = "usu_id = " . $Id;
                $bdNomeImagem = 'usu_imagem_nome';  
                $bdlUrlImagem = 'usu_imagem_url'; 
                uploadImagem('usuarios', $imagem64, $where, $bdNomeImagem, $bdlUrlImagem, false);

                $data = ['acao' => 'ok'];
                header('Content-type: application/json');
                echo json_encode($data);
            }
        } catch (Exception $e) {
            $pdo->rollBack();
        }
    } //ok
}
