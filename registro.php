<?php

require_once "db.php";
require_once "init.php";

$mensaje = "";

if($_SERVER['REQUEST_METHOD'] =='POST'){

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $nombre = $_POST['nombre'] ?? '';


    if(!empty($nombre) && !empty($email) && !empty($password)){

        $pass_hased = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conexion->prepare("INSERT INTO usuarios(nombre, email, password, rol) VALUES (:n, :e, :p, 'user')");
        $stmt->execute([':n'=>$nombre, ':p'=>$pass_hased, ':e'=>$email]);

        $userId = $conexion->lastInsertId();

        if(isset($_FILES['foto'])){
            $fileName = $_FILES['foto']['name'];
            $fileTemp = $_FILES['foto']['tmp_name'];

            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $destino = 'uploads/' . $userId . '.' . "$fileExtension";

            move_uploaded_file($fileTemp,$destino);

        } else {
            $mensaje = "No has subido una imagen";
        }
        
    } else {
        $mensaje = "Email o contraseña vacíos";
    }


}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - MoodPlay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md">
        <h1 class="text-3xl font-bold mb-2 text-slate-800">Crea tu cuenta</h1>
        <p class="text-slate-500 mb-8">Únete a la plataforma de streaming líder.</p>

        <form action="registro.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nombre Completo</label>
                <input type="text" name="nombre" required class="w-full border p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full border p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
                <input type="password" name="password" required class="w-full border p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
                Crear cuenta
            </button>
            
            <p class="text-center text-sm text-slate-500 mt-4">
                ¿Ya eres miembro? <a href="login.php" class="text-blue-600 hover:underline">Inicia sesión</a>
            </p>
        </form>
    </div>
</body>
</html>