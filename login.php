<?php

require_once 'db.php';

require_once 'init.php';
$mensaje = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $recordarme = isset($_POST['recordarme']);

    $stmt = $conexion->prepare('SELECT password, rol from usuarios where email = :email');

    $stmt->bindParam(':email', $email);

    $stmt->execute();

    if($stmt->rowcount() > 0){
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        $hash = $fila['password'];
        $rol = $fila['rol'];

        if(password_verify($password, $hash)){
            $_SESSION['email'] = $email;
            $_SESSION['rol'] = $rol;

            if($recordarme){
                setcookie('email', $email, time() + 86400 * 30, '/');
            }

            header("Location: index.php");
        }else{
            $mensaje = "<p class='text-red-500'>Email o contraseña incorrectos</p>";
        }
    }else{
        $mensaje = "<p class='text-red-500'>Email o contraseña incorrectos</p>";
    }
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - MoodPlay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-2xl w-96">
        <h1 class="text-2xl font-bold mb-6 text-center text-slate-800">Acceso MoodPlay</h1>
        <form action="login.php" method="POST" class="flex flex-col gap-4">
            <input type="email" name="email" placeholder="Email" required 
                   class="border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none">
            <input type="password" name="password" placeholder="Contraseña" required 
                   class="border p-2 rounded focus:ring-2 focus:ring-blue-500 outline-none">
            <button type="submit" class="bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Entrar
            </button>
    
            <div class="text-center mt-4 border-t pt-4">
                <p class="text-sm text-slate-500 mb-2">¿No tienes cuenta?</p>
                <a href="registro.php" class="inline-block w-full border border-blue-600 text-blue-600 py-2 rounded hover:bg-blue-50 transition font-medium">
                    Registrarme
                </a>
            </div>
        </form>
    </div>
</body>
</html>