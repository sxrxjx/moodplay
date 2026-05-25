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

        $stmt = $conexion->prepare("INSERT INTO usuarios(nombre, email, password, rol) values (:n, :e, :p, 'user')");
        $stmt->execute([':n'=>$nombre, ':p'=>$pass_hased, ':e'=>$email]);
    } else {
        $mensaje = "Email o contraseña vacíos";
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
        
        <form action="registro.php" method="POST" class="w-full flex flex-col gap-6">
            <div class="w-full border-b border-slate-500 focus-within:border-white transition-all py-1">
                <input type="text" name="nombre" placeholder="Nombre Completo" required class="w-full bg-transparent text-white outline-none py-2 placeholder-slate-400 pr-8 text-sm">
            </div>
            <div class="w-full border-b border-slate-500 focus-within:border-white transition-all py-1">
                <input type="email" name="email" placeholder="Email" required class="w-full bg-transparent text-white outline-none py-2 placeholder-slate-400 pr-8 text-sm">
            </div>
            <div class="w-full border-b border-slate-500 focus-within:border-white transition-all py-1">
                <input type="password" name="password" placeholder="Contraseña" required class="w-full bg-transparent text-white outline-none py-2 placeholder-slate-400 pr-8 text-sm">
            </div>
            <div class="flex justify-center mt-6">
                <button type="submit" class="border border-white bg-emerald-500/20 hover:bg-emerald-500/40 text-white font-bold py-2.5 px-16 rounded-full transition-all uppercase">
                    Registrarme
                </button>
            </div>

            <div class="text-center mt-4">
                <p class="text-xs text-slate-400">
                    ¿Ya eres miembro?
                    <a href="login.php" class="text-emerald-400 hover:text-emerald-300 underline font-semibold transition">Inicia sesión</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>