<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa</title>
</head>
<body>
    <h1>Registro de Empresa</h1>
    <form method="POST" action="registra_admin.php" enctype="multipart/form-data">
        <input type="hidden" name="is_admin" value="1">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Senha" required>
        <label for="imagem">Imagem:</label>
        <input type="file" id="imagem" name="imagem"><br><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
<?php
session_start();

// Incluir el archivo de configuración (ajusta la ruta según sea necesario)
include '../config.php';

// Verificar si se han recibido los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener los datos del formulario y asignar a variables
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : ''; 
    $linkedin = isset($_POST['linkedin']) ? $_POST['linkedin'] : ''; // Ajusta si es necesario

    // Procesamiento de la imagen
    $imagem = ''; // Variable para guardar la ruta de la imagen
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_dir = 'img/'; // Directorio donde se guardarán las imágenes
        $imagem_name = $_FILES['imagem']['name'];
        $imagem_tmp = $_FILES['imagem']['tmp_name'];
        $imagem_path = $imagem_dir . $imagem_name;

        if (move_uploaded_file($imagem_tmp, $imagem_path)) {
            $imagem = $imagem_path; // Guardar la ruta de la imagen en la base de datos
        } else {
            echo "Erro ao subir a imagem.";
            exit;
        }
    }

    // Insertar datos en la base de datos
    $sql = "INSERT INTO usuario (nome, email, isadmin, username, senha, linkedin, imagem)
            VALUES ('$nome', '$email', 1, '$username', '$senha', '$linkedin', '$imagem')";

    // Verificar si la consulta se ejecuta correctamente
    if ($conn) {
        if ($conn->query($sql) === TRUE) {
            echo "Administrador registrado con sucesso!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: No se pudo conectar a la base de datos.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Error: No se recibieron datos del formulario.";
}
?>
