<?php
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION["logado"]) || $_SESSION["tipo_usuario"] != "administrador") {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do usuário a ser editado está presente na URL
if (!isset($_GET["id"])) {
    header("Location: gerenciar_usuarios.php");
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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];

    // Atualiza os dados do usuário no banco de dados
    $sql = "UPDATE usuarios SET nome='$nome', email='$email' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redireciona para a página de gerenciar usuários após a edição ser concluída
        header("Location: gerenciar_usuarios.php");
        exit();
    } else {
        $erro = "Erro ao editar usuário: " . $conn->error;
    }
}

// Obtém o ID do usuário da URL
$id_usuario = $_GET["id"];

// Consulta SQL para buscar as informações do usuário pelo ID
$sql = "SELECT * FROM usuarios WHERE id=$id_usuario";
$result = $conn->query($sql);

// Verifica se encontrou o usuário
if ($result->num_rows == 1) {
    // Armazena os dados do usuário em um array associativo
    $usuario = $result->fetch_assoc();
} else {
    // Se o usuário não for encontrado, redireciona de volta para a página de gerenciar usuários
    header("Location: gerenciar_usuarios.php");
    exit();
}

$conn->close(); // Fecha a conexão com o banco de dados
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
        /* Adicione estilos CSS aqui conforme necessário */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p.error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Editar Usuário</h2>

    <?php if (isset($erro)) : ?>
        <p class="error"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo $usuario["id"]; ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $usuario["nome"]; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $usuario["email"]; ?>" required>

        <input type="submit" value="Salvar">
    </form>
</div>

</body>
</html>
