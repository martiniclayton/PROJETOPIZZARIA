<?php
// Configuração de conexão com o banco de dados
$servidor = "localhost";
$user = "root";
$password = "Tricolor12@";
$bd = "cadastrocliente";

// Conectando ao banco de dados
$conexao = new mysqli($servidor, $user, $password, $bd);

// Verifica se a conexão foi bem-sucedida
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

// Consulta SQL para selecionar todos os clientes
$sql = "SELECT id, nome, telefone, endereco, email FROM clientes";
$result = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #7c1515;
        }

        .titulo{
            color: white;
        }
        table {
            width: 90%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            background-color: white;
            
        }
        th {
            background-color: #f2f2f2;
        }

        .final{
            padding: 10px;
        }

        button{
            width: 120px;
            height: 30px;
            border: none;
            cursor: pointer;
        }

        button:hover{
            background-color: coral;
            color: white;
        }
        .topo{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .topo button{
            width: 150px;
            height: 25px;
            background-color: #7c1515;
            border: 2px solid white;
            color: white;
            margin: 3px;
            border-radius: 5px;
        }

        .topo button:hover{
            background-color: white;
            color: black;
            border: 2px solid #7c1515;
        }
    </style>
</head>
<body>
    <div class="topo">
        <div class="logo">
            <img width="180" height="120" src="logopizza.png">
        </div>
        <div class="navegacao">
            <a href="menuprincipal.html" style="text-decoration: none">

                <button>Menu Principal</button>
            </a>
            <button>Pedidos</button>
            <button>Cadastrar Cliente</button>
            <button style="background-color: coral">Clientes</button>
            <button>teste</button>
            <button>teste</button>
        </div>
        <div class="titulo">

            <h2>Lista de Clientes</h2>
        </div>
    </div>
    
    <!-- Tabela HTML para exibir dados -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Email</th>
        </tr>
        
        <?php
        // Verifica se há resultados e exibe os dados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nome'] . "</td>";
                echo "<td>" . $row['telefone'] . "</td>";
                echo "<td>" . $row['endereco'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum cliente encontrado</td></tr>";
        }
        $conexao->close();
        ?>
    </table>
    <div class="final">
        <a href="menuprincipal.html" style="text-decoration: none;"><button>Menu Principal</button></a>
        <a href="cadastrarcliente.html" style="text-decoration: none;"><button>Cadastrar Cliente</button></a>
    </div>
</body>
</html>
