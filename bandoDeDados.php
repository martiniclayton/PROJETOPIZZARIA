<?php

$servidor = "localhost";
$user ="root";
$password ="Tricolor12@";
$bd = "loginpizza";

// Conecta ao banco de dados
$conexao = new mysqli($servidor, $user, $password, $bd);

// Verifica se houve erro na conexão
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = trim($_POST["nome"]);
    $usuario = trim($_POST["usuario"]);
    $senha = $_POST["senha"];
    $confirmarSenha = $_POST["confirmarSenha"];
    $email = trim($_POST["email"]);

    // Verifica se as senhas são iguais
    if ($senha === $confirmarSenha) {
        // Verifica se o usuário já existe
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            echo "<p>Usuário já existente</p>";
        } else {
            // Criptografa a senha
            $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

            // Insere o novo usuário no banco de dados
            $sql = "INSERT INTO usuarios (nome, usuario, senha, email) VALUES (?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ssss", $nome, $usuario, $senhaHash, $email);

            // Executa a inserção
            if ($stmt->execute()) {
                echo "Cadastro Realizado com sucesso.";
            } else {
                echo "Erro ao cadastrar: " . $conexao->error;
            }
        }
    } else {
        echo "As senhas não coincidem.";
    }
}

$conexao->close(); // Fecha a conexão com o banco de dados
?>
