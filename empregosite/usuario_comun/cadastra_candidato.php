<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Candidato</title>
</head>
<body>
    <h1>Registro de Candidato</h1>
    <form method="POST" action="cadastra_candidato_candidato.php" enctype="multipart/form-data">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <input type="hidden" name="is_admin" value="0">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <label for="linkedin">LinkedIn:</label>
        <input type="text" id="linkedin" name="linkedin"><br><br>

        <label for="imagem">Imagem:</label>
        <input type="file" id="imagem" name="imagem"><br><br>

        <input type="submit" value="Registrar">
    </form>

</body>
</html>

<?php
include '../config.php';
session_start();

$nome = $_POST['nome'];
$email = $_POST['email'];
$username = $_POST['username'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); 
$linkedin = $_POST['linkedin'];

// Procesamiento de la foto
$imagem = ''; // Variable para guardar la ruta de la imagem
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $foto_dir = 'img/'; // Directorio donde se guardarán las imagenes
    $foto_name = $_FILES['imagem']['name'];
    $foto_tmp = $_FILES['imagem']['tmp_name'];
    $foto_path = $foto_dir . $foto_name;

    if (move_uploaded_file($foto_tmp, $foto_path)) {
        $foto = $foto_path; // Guardar la ruta de la foto en la base de datos
    } else {
        echo "Erro ao subir a imagem.";
        exit;
    }
}

// Insertar datos en la base de datos
$sql = "INSERT INTO usuario (nome, email, isadmin, username, senha, linkedin, imagem)
        VALUES ('$nome', '$email', 0, '$username', '$senha', '$linkedin', '$imagem')";

if ($conn->query($sql) === TRUE) {
    echo "Candidato registrado con sucesso!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>