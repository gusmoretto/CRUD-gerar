<?php

session_start();

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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Prepara a consulta SQL
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    // Verifica se o usuário existe
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifica a senha com hash
        if (password_verify($senha, $row["senha"])) {
            $_SESSION["logado"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["nome"] = $row["nome"];
            $_SESSION["tipo_usuario"] = $row["tipo_usuario"];

            // Redireciona conforme o tipo de usuário
            if ($row["tipo_usuario"] == "administrador") {
                header("Location: index.php");
            } else {
                header("Location: cliente.php");
            }
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Login</h2>

        <?php if (isset($erro)) : ?>
            <p class="error"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="senha">Senha:</label><br>
            <input type="password" id="senha" name="senha" required><br><br>

            <input type="submit" value="Entrar">
        </form>

        <p>Ainda não tem cadastro? <a href="cadastro.php">Cadastre-se aqui</a>.</p>
    </div>
    <div class="image-container">
        <img src="imagens/craque.png" alt="Camisa de Craque FC">
        <p>Camisa de Craque FC</p>
    </div>
</div>

</body>
</html>
