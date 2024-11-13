<?php

$servidor = "localhost";
$user = "root";
$password = "Tricolor12@";
$bd = "cadastrocliente";

$conexao = new mysqli($servidor, $user, $password, $bd);

if ($conexao->connect_error) {
    echo "Erro de conexão: " . $conexao->connect_error;
} else {
    echo "Conexão realizada com sucesso";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $email = $_POST["email"];

    // Verificar se o telefone já existe
    $sql = "SELECT * FROM clientes WHERE telefone = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $telefone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Usuário já existente";
    } else if($nome != null && $telefone != null && $email != null && $endereco != null) {
        // Inserir novo cliente com placeholders
        $sql = "INSERT INTO clientes (nome, telefone, endereco, email) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("siss", $nome, $telefone, $endereco, $email);


        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso";
        } else {
            echo "Falha ao realizar cadastro: " . $stmt->error;
        }
    }

    // Fechar statement e conexão
    $stmt->close();
}

$conexao->close();
?>
