<?php
require_once "init.php";
require_once "db.php";
require_once "functions.php";

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit;

}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];

// AQUÍ OBTENEMOS LA CATEGORÍA. Si no hay categoría en el GET es null y si sí hay se actualiza la variable $categoría_seleccionada con el id de la categoría del GET.
$categoria_seleccionada = null;

if (isset($_GET['categoria'])) {
    $categoria_seleccionada = (int)$_GET['categoria'];
}


$peliculas= obtenerPeliculas($conexion, $categoria_seleccionada);
$categorias = obtenerCategorias($conexion);


?>

<?php


include_once 'header.php';

?>




<body class="bg-gradient-to-tr from-violet-400 via-gray-950 to-green-300 min-h-screen text-white font-sans">
    <nav class="sticky top-0 z-1 bg-gray-950/80 backdrop-blur-md text-white p-4 flex justify-between items-center shadow-lg border-b border-white/10">
    <a href="index.php"><img src="img/logomoodplay.png" class="h-10 w-auto hover:scale-105 transition-all duration-300"></a>   
        <div class="flex items-center gap-4">
            <span class="text-slate-300 text-sm font-medium">Hola, <strong class="text-white font-semibold"><?= $nombre ?></strong></span>
            <!-- COMPROBAMOS SI SOMOS ADMIN O USER. Mediante el rol que hemos guardado en $rol cuando iniciamos sesión. Así mostramos el botón del PANEL ADMIN o no. -->
            <?php if($rol == 'ADMIN'){ ?>
                <a href="admin.php" class="border border-emerald-500/50 bg-emerald-500/20 hover:bg-emerald-500/40 text-emerald-300 text-xs px-3.5 py-1.5 rounded-full transition-all uppercase font-semibold">Panel Admin</a>
            <?php } ?>
            <a href="logout.php" class="border border-red-500/50 bg-red-500/20 hover:bg-red-500/40 text-red-200 text-xs px-3.5 py-1.5 rounded-full transition-all uppercase font-semibold">Cerrar Sesión</a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-8">
        <h2 class="text-3xl font-extrabold text-center mb-6 text-white drop-shadow-md">Catálogo de Películas</h2>
        <h2 class="text-7xl font-extrabold text-center mb-6 bg-gradient-to-r from-red-500 to-orange-400 bg-clip-text text-transparent drop-shadow-md">Furiosx</h2>
        <!-- NAV PARA LAS CATEGORÍAS. Accedemos a ellas mediante el GET. De esa forma solo se cargarán las películas que tengan el id de la categoría seleccionada en el GET. En la función obtenerPeliculas(), cogemos las películas de cada categoría con la consulta. -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <a href="index.php" class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full border transition-all duration-300 <?php
            if (!$categoria_seleccionada) {
                 echo 'border-emerald-500/50 bg-emerald-500/20 text-emerald-300';
            } else {
                echo 'border-white/10 bg-slate-900/60 text-slate-300 hover:bg-white/5';
            }
            ?>">
                Todas
            </a>
            <?php foreach ($categorias as $categoria){ ?>
                <a href="index.php?categoria=<?= $categoria->id_categoria ?>" class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full border transition-all duration-300 <?php
                if ($categoria_seleccionada === (int)$categoria->id_categoria) {
                    echo 'border-emerald-500/50 bg-emerald-500/20 text-emerald-300';
                } else {
                    echo 'border-white/10 bg-slate-900/60 text-slate-300 hover:bg-white/5';
                }
                ?>">
                    <?= $categoria->nombre ?>
                </a>
            <?php } ?>
        </div>

        <!-- AQUÍ MOSTRAMOS LAS PELÍCULAS DE CADA CATEGORÍA. Si no hay películas en el array de películas, mostramos un mensaje de que no hay películas en la categoría.  -->
        <?php if (empty($peliculas)){ ?>
            <div class="text-center py-16 bg-slate-900/40 rounded-2xl border border-white/5 backdrop-blur-sm">
                <p class="text-slate-400 text-lg font-medium">No hay películas en esta categoría.</p>
            </div>
        <?php } else { ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
              <?php foreach($peliculas as $peli){ ?>
                <div class="bg-slate-900/60 backdrop-blur-md border border-white/10 rounded-2xl p-5 flex flex-col justify-between shadow-2xl  transition-all duration-300 hover:scale-[1.02] hover:border-emerald-500/45">
                    <div>
                        <img src="img/<?= $peli->imagen  ?>" class="w-full h-80 shadow-inner object-cover mb-4 rounded-xl ">
                        <h3 class="text-xl font-bold mb-2 text-white line-clamp-1"><?= $peli->titulo ?></h3>
                        <p class="text-slate-300 text-sm mb-4 h-16 overflow-hidden line-clamp-3 leading-relaxed"><?= $peli->descripcion ?></p>
                    </div>
                    <div>
                        <div class="border-white/10 flex justify-between items-center mb-4 border-t  pt-4"> 
                            <?php if($peli->stock > 0){ ?>
                                <p class="text-2xl font-black text-emerald-400"><?= $peli->precio ?>€</p>
                                <p class="text-xs bg-slate-800 border border-white/10 text-slate-300 px-2.5 py-1 rounded-full font-medium">Stock: <?= $peli->stock ?></p>
                            <?php }else{ ?>
                                <p class="text-2xl font-black text-slate-400"><?= $peli->precio ?>€</p>
                                <p class="text-xs bg-red-800 border border-red/10 text-red-300 px-2.5 py-1 rounded-full font-medium">Stock: <?= $peli->stock ?></p>
                            <?php } ?>
                        </div>

                        <?php if($peli->stock > 0){ ?>
                            <button class="w-full border border-white bg-emerald-500/20 hover:bg-emerald-500/40 text-white font-bold py-2.5 rounded-full transition-all uppercase text-sm tracking-wider">Comprar</button>
                        <?php }else{ ?>
                            <button disabled class="w-full border border-slate-700 bg-slate-800/50 text-slate-500 py-2.5 rounded-full cursor-not-allowed uppercase text-sm tracking-wider">Agotado</button>
                        <?php } ?>
                    </div>

                </div>

              <?php } ?>
            </div>

        <?php } ?>
    </main>

</body>
</html>