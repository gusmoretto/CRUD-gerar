<?php
// Dados de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = ""; // Preencha com a senha do seu banco de dados
$dbname = "bdloja2024";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificando se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];

    // Preparando a declaração SQL para evitar SQL Injection
    $stmt = $conn->prepare("INSERT INTO tbcliente (nome, idade) VALUES (?, ?)");
    $stmt->bind_param("si", $nome, $idade);

    // Executando a declaração
    if ($stmt->execute()) {
        echo "Os dados foram cadastrados com sucesso";
    } else {
        echo "Dados não cadastrados :( [ERRO]: " . $stmt->error;
    }

    // Fechando a declaração
    $stmt->close();
}

// Fechando a conexão
$conn->close();
?>
