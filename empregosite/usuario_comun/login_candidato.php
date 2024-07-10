<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css"  rel="stylesheet" type="text/css" >
    <title>Login Candidato</title>
</head>
<body>
    <h1>Login Candidato</h1>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="senha" required>
        <button type="submit">Login</button>
    </form>
    <a href="cadastra_candidato.php" class="btn">Novo? Cadastre-se aqui</a>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php';
    session_start();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, username, senha, is_admin FROM usuario WHERE email='$email' AND is_admin=0";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['is_admin'] = $row['is_admin'];

            header("Location: inicio_candidato.php");
        } else {
            echo "Senha invalida!";
        }
    } else {
        echo "Usuario nao encontrado!";
    }
}
?>
