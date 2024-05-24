<?php

// Dados de conexão com o banco de dados (os mesmos da tela de login)
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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Hash da senha

    // Prepara a consulta SQL
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

    if ($conn->query($sql) === TRUE) {
        $sucesso = "Usuário cadastrado com sucesso!";
    } else {
        $erro = "Erro ao cadastrar usuário: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Cadastro de Cliente</h2>

        <?php if (isset($erro)) : ?>
            <p class="error"><?php echo $erro; ?></p>
        <?php endif; ?>

        <?php if (isset($sucesso)) : ?>
            <p class="success"><?php echo $sucesso; ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="senha">Senha:</label><br>
            <input type="password" id="senha" name="senha" required><br><br>

            <input type="submit" value="Cadastrar">
        </form>

        <p>Já possui cadastro? <a href="login.php">Faça login aqui</a>.</p>
    </div>
    <div class="image-container">
        <img src="imagens/craque.png" alt="Camisa de Craque">
        <p>Camisa de Craque</p>
    </div>
</div>

</body>
</html>
