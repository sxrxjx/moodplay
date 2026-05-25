<?php
require_once 'init.php';
require_once 'db.php';

$mensaje = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $recordarme = isset($_POST['recordarme']);

    $stmt = $conexion->prepare('SELECT nombre, password, rol from usuarios where email = :email');

    $stmt->bindParam(':email', $email);

    $stmt->execute();

    if($stmt->rowcount() > 0){
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        $hash = $fila['password'];
        $rol = $fila['rol'];
        $nombre = $fila['nombre'];

        if(password_verify($password, $hash)){
            $_SESSION['nombre'] = $nombre;
            $_SESSION['email'] = $email;
            $_SESSION['rol'] = $rol;

            if($recordarme){
                setcookie('session_activa', session_id(), time() + 60*60*24*365, '/');
            }

            if($_SESSION['rol'] != 'ADMIN' ){
                header("Location: index.php");
            }else{
                header("Location: admin.php");
            }
        }else{
            $mensaje = "<p class='text-red-500'>Email o contraseña incorrectos</p>";
        }
    }else{
        $mensaje = "<p class='text-red-500'>Email o contraseña incorrectos</p>";
    }
}


?>

<?php

include_once 'header.php';
?>



<body class="bg-gradient-to-tr from-violet-400 via-gray-950 to-green-300 flex flex-col items-center justify-center min-h-screen p-4 text-white font-museo">
    <div class="w-full max-w-xs flex flex-col items-center">
        <div class="mb-10 flex flex-col items-center">
            <img src="img/logomoodplaylogin.png" alt="MoodPlay Logo" class="h-28 w-auto">
        </div>
        
        <?php if($mensaje != ''){ ?>
            <div class="mb-4 text-red-400 text-sm font-semibold text-center bg-red-950/40 border border-red-800 p-2.5 rounded w-full">
                <?= $mensaje ?>
            </div>
        <?php } ?>
        
        <form action="login.php" method="POST" class="w-full flex flex-col gap-6">
            <div class="w-full border-b border-slate-500 focus-within:border-white transition-all py-1">
                <input type="email" name="email" placeholder="Username or Email" required class="w-full bg-transparent text-white outline-none py-2 placeholder-slate-400 pr-8 text-sm">
            </div>
            <div class="w-full border-b border-slate-500 focus-within:border-white transition-all py-1">
                <input type="password" name="password" placeholder="Contraseña" required class="w-full bg-transparent text-white outline-none py-2 placeholder-slate-400 pr-8 text-sm">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="recordarme" id="recordarme" class="w-4 h-4">
                <label for="recordarme" class="text-xs text-slate-300">
                    Recordar mi sesión
                </label>
            </div>
            <div class="flex justify-center mt-6">
                <button type="submit" class="border border-white bg-emerald-500/20 hover:bg-emerald-500/40 text-white font-bold py-2.5 px-16 rounded-full transition-all uppercase">
                    Log In
                </button>
            </div>
            <div class="text-center mt-4">
                <p class="text-xs text-slate-400">
                    ¿No tienes cuenta?
                    <a href="registro.php" class="text-emerald-400 hover:text-emerald-300 underline font-semibold transition">Registrarme</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>