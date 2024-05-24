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
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    
    // Tratamento da imagem (se uma nova imagem foi enviada)
    if ($_FILES["imagem"]["name"]) {
        $imagem = $_FILES["imagem"]["name"]; // Nome original do arquivo
        $imagem_temp = $_FILES["imagem"]["tmp_name"]; // Caminho temporário do arquivo
        
        // Diretório de destino para salvar a imagem
        $diretorio_destino = "imagens/";

        // Move a imagem para o diretório de destino
        move_uploaded_file($imagem_temp, $diretorio_destino . $imagem);
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

    // Prepara a query SQL para atualização dos dados
    if ($_FILES["imagem"]["name"]) {
        $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, imagem = ? WHERE id = ?";
    } else {
        $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ? WHERE id = ?";
    }
    
    // Prepara a declaração SQL
    $stmt = $conn->prepare($sql);

    if ($_FILES["imagem"]["name"]) {
        // Vincula os parâmetros (com imagem)
        $stmt->bind_param("ssdsi", $nome, $descricao, $preco, $imagem, $id);
    } else {
        // Vincula os parâmetros (sem imagem)
        $stmt->bind_param("ssdi", $nome, $descricao, $preco, $id);
    }
    
    // Executa a declaração
    $stmt->execute();
    
    // Fecha a declaração
    $stmt->close();
    
    // Fecha a conexão com o banco de dados
    $conn->close();
    
    // Redireciona de volta para a página de gerenciamento de produtos
    header("Location: cadastrar_produtos.php");
    exit();
} else {
    // Se o formulário não foi submetido, redireciona para a página de gerenciamento de produtos
    header("Location: cadastrar_produtos.php");
    exit();
}
?>
