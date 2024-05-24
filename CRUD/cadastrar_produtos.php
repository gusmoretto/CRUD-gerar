<?php
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION["logado"]) || $_SESSION["tipo_usuario"] != "administrador") {
    header("Location: login.php");
    exit();
}

// Dados de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loja";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Consulta SQL para buscar os produtos
$sql = "SELECT id, nome, descricao, preco FROM produtos";
$result = $conn->query($sql);

// Array para armazenar os produtos
$produtos = array();

// Verifica se encontrou algum produto
if ($result->num_rows > 0) {
    // Loop através dos resultados da consulta
    while ($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
}

$conn->close(); // Fecha a conexão com o banco de dados
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .options-container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Gerenciar Produtos</h2>

    <!-- Opções de gerenciamento -->
    <div class="options-container">
        <a href="index.php" style="text-decoration: none; color: #007bff;">Voltar</a>
        <a href="novo_produto.php" style="text-decoration: none; color: #007bff;">Cadastrar Novo Produto</a>
    </div>

    <!-- Tabela de produtos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto) : ?>
                <tr>
                    <td><?php echo $produto["id"]; ?></td>
                    <td><?php echo $produto["nome"]; ?></td>
                    <td><?php echo $produto["descricao"]; ?></td>
                    <td><?php echo 'R$ ' . number_format($produto["preco"], 2, ',', '.'); ?></td>
                    <td>
                        <a href="editar_produto.php?id=<?php echo $produto["id"]; ?>" style="margin-right: 10px;">Editar</a>
                        <a href="excluir_produto.php?id=<?php echo $produto["id"]; ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
