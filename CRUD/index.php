<?php
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION["logado"]) || $_SESSION["tipo_usuario"] != "administrador") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Painel do Administrador</h2>
    <p>Bem-vindo, Administrador <?php echo htmlspecialchars($_SESSION["nome"]); ?>!</p>

    <div class="admin-options">
        <ul>
            <li><a href="gerenciar_usuarios.php">Gerenciar Usuários</a></li>
            <li><a href="cadastrar_produtos.php">Gerenciar Produtos</a></li>
            <li><a href="configuracoes.php">Configurações</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </div>
</div>

</body>
</html>
