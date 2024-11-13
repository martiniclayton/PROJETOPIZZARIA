<?php
session_start(); // Inicia a sessão para armazenar informações de login

// Configurações do banco de dados
$servidor = "localhost";
$user = "root";
$password = "Tricolor12@";
$bd = "loginpizza";

// Conecta ao banco de dados
$conexao = new mysqli($servidor, $user, $password, $bd);

// Verifica se houve erro na conexão
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Verifica se os campos estão preenchidos
    if (!empty($_POST['usuario']) && !empty($_POST['senha'])) {
        // Obtém o usuário e a senha do formulário
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        // Consulta o banco de dados para obter a senha
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            // Usuário encontrado; agora verifica a senha
            $row = $resultado->fetch_assoc();
            $senhaArmazenada = $row['senha']; // Pega a senha do banco

            // Compara a senha informada com a senha armazenada
            if (password_verify($senha, $senhaArmazenada)) {
                // Senha correta, login bem-sucedido
                $_SESSION['usuario'] = $usuario;
                header("Location: menuprincipal.html"); // Redireciona para a página principal
                exit();
            } else {
                // Senha incorreta
                echo "Falha ao realizar login. Usuário ou senha incorretos.";

            }
        } else {
            // Usuário não encontrado
            echo "Falha ao realizar login. Usuário ou senha incorretos.";
        }
    } else {
        // Campos vazios
        echo "Por favor, preencha todos os campos.";
    }
}

$conexao->close(); // Fecha a conexão com o banco de dados
?>
