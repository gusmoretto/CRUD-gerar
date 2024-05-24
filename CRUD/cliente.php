<?php
session_start();

// Verifica se o usuário está logado e se é cliente
if (!isset($_SESSION["logado"]) || $_SESSION["tipo_usuario"] != "cliente") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION["nome"]); ?>!</h2>
    <p>Esta é a página do cliente.</p>
    <a href="logout.php">Sair</a>
</div>

</body>
</html>
