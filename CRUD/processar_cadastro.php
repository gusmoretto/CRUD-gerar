<?php
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION["logado"]) || $_SESSION["tipo_usuario"] != "administrador") {
    header("Location: login.php");
    exit();
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    
    // Tratamento da imagem
    $imagem = $_FILES["imagem"]["name"]; // Nome original do arquivo
    $imagem_temp = $_FILES["imagem"]["tmp_name"]; // Caminho temporário do arquivo
    
    // Diretório de destino para salvar a imagem
    $diretorio_destino = "imagens/";

    // Move a imagem para o diretório de destino
    move_uploaded_file($imagem_temp, $diretorio_destino . $imagem);
    
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

    // Prepara a query SQL para inserção dos dados
    $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)";
    
    // Prepara a declaração SQL
    $stmt = $conn->prepare($sql);
    
    // Vincula os parâmetros
    $stmt->bind_param("ssds", $nome, $descricao, $preco, $imagem);
    
    // Executa a declaração
    $stmt->execute();
    
    // Obtém o ID do produto recém-cadastrado
    $produto_id = $stmt->insert_id;
    
    // Fecha a declaração
    $stmt->close();
    
    // Fecha a conexão com o banco de dados
    $conn->close();
    
    // Redireciona para a página do produto recém-cadastrado
    header("Location: produto.php?id=" . $produto_id);
    exit();
} else {
    // Se o formulário não foi submetido, redireciona para a página de cadastro de produtos
    header("Location: cadastrar_produtos.php");
    exit();
}
?>
