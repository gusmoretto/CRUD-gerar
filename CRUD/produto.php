<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["logado"])) {
    header("Location: login.php");
    exit();
}

// Verifica se foi passado um ID de produto na URL
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php");
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

// Prepara e executa a consulta SQL para obter as informações do produto
$id = $_GET["id"];
$sql = "SELECT * FROM produtos WHERE id = $id";
$result = $conn->query($sql);

// Verifica se o produto foi encontrado
if ($result->num_rows > 0) {
    // Extrai os dados do produto
    $produto = $result->fetch_assoc();
} else {
    // Se o produto não foi encontrado, redireciona de volta para a página inicial
    header("Location: index.php");
    exit();
}

$conn->close(); // Fecha a conexão com o banco de dados
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>
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
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><?php echo $produto["nome"]; ?></h2>
    <img src="<?php echo $produto["imagem"]; ?>" alt="<?php echo $produto["nome"]; ?>">
    <p><strong>Descrição:</strong> <?php echo $produto["descricao"]; ?></p>
    <p><strong>Preço:</strong> R$ <?php echo number_format($produto["preco"], 2, ',', '.'); ?></p>
</div>

</body>
</html>
