<?php
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION["logado"]) || $_SESSION["tipo_usuario"] != "administrador") {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do produto foi fornecido via GET
if(isset($_GET["id"]) && !empty($_GET["id"])) {
    // ID do produto a ser excluído
    $produto_id = $_GET["id"];

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

    // Prepara a query SQL para excluir o produto
    $sql = "DELETE FROM produtos WHERE id = ?";

    // Prepara a declaração SQL
    $stmt = $conn->prepare($sql);

    // Vincula o parâmetro
    $stmt->bind_param("i", $produto_id);

    // Executa a declaração
    $stmt->execute();

    // Fecha a declaração
    $stmt->close();

    // Fecha a conexão com o banco de dados
    $conn->close();
}

// Redireciona de volta para a página de gerenciamento de produtos
header("Location: cadastrar_produtos.php");
exit();
?>
