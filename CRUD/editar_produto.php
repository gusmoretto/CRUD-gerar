<?php
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION["logado"]) || $_SESSION["tipo_usuario"] != "administrador") {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do produto foi fornecido na URL
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

// Obtém o ID do produto da URL
$id_produto = $_GET["id"];

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

// Consulta SQL para buscar o produto pelo ID fornecido
$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o produto foi encontrado
if ($result->num_rows > 0) {
    // Obtém os dados do produto
    $produto = $result->fetch_assoc();
} else {
    // Se o produto não foi encontrado, redireciona de volta para a página inicial
    header("Location: index.php");
    exit();
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
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
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Editar Produto</h2>
    <form action="processar_edicao_produto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $produto["id"]; ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $produto["nome"]; ?>">
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"><?php echo $produto["descricao"]; ?></textarea>
        <label for="preco">Preço:</label>
        <input type="text" id="preco" name="preco" value="<?php echo $produto["preco"]; ?>">
        <label for="imagem">Imagem:</label>
        <input type="file" id="imagem" name="imagem">
        <input type="submit" value="Salvar Alterações">
    </form>
</div>

</body>
</html>
