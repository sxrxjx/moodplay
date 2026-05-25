<?php
require_once 'init.php';
require_once 'db.php';
require_once 'functions.php';

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['rol'] != 'ADMIN' ){
    header("Location: index.php");
    exit;
}

if(isset($_GET['eliminar_peli'])){
    borrarPelicula($conexion, $_GET['eliminar_peli']);
    header("Location: admin.php");
    exit;

}

$peliculas = obtenerPeliculas($conexion, null);

$usuarios=obtenerUsuarios($conexion);

?>

<?php
include_once 'header.php';



?>



<body class="bg-gray-900 min-h-screen text-white font-sans">

    <nav class="sticky top-0 z-10 bg-gray-950/80 backdrop-blur-md text-white p-4 flex justify-between items-center shadow-lg border-b border-white/10">
        <a href="index.php"><img src="img/logomoodplay.png" class="h-10 w-auto hover:scale-105 transition-all duration-300"></a> 
        <h1 class="text-xl font-bold tracking-wider uppercase text-emerald-400">Panel Admin</h1>
        <div class="flex items-center gap-4">
            <a href="index.php" class="border border-emerald-500/50 bg-emerald-500/20 text-emerald-300 text-xs px-3.5 py-1.5 hover:bg-emerald-500/40 rounded-full transition-all uppercase font-semibold">Ver Tienda</a>
            <a href="logout.php" class="border border-red-500/50 bg-red-500/20  text-red-200 text-xs px-3.5 py-1.5 rounded-full transition-all uppercase font-semibold hover:bg-red-500/40">Cerrar Sesión</a>
        </div>
    </nav>

    <main class="p-8 max-w-6xl mx-auto">
        <a href="crearpeli.php" class="fixed bottom-8 right-8 z-50 flex items-center gap-2 border border-white/50 bg-emerald-600/30 hover:bg-emerald-500 hover:scale-105 backdrop-blur-md text-white font-bold py-3 px-6 rounded-full shadow-2xl transition-all duration-300 uppercase text-sm">
           + Añadir Nueva Película
        </a>
<!-- AQUÍ MOSTRAMOS TODAS LAS PELÍCULAS Y SERIES DISPONIBLES. Como no necesitamos dividir por categorías, en obtenerPeliculas hemos pasado el valor null como categoría. -->
        <section class="bg-violet-900/60 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-2xl mb-8">
            <h2 class="text-2xl font-bold mb-6 text-white drop-shadow-md">Inventario</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="p-3 text-slate-300 font-semibold uppercase text-xs">ID</th>
                            <th class="p-3 text-slate-300 font-semibold uppercase text-xs">Imagen</th>
                            <th class="p-3 text-slate-300 font-semibold uppercase text-xs">Título</th>
                            <th class="p-3 text-slate-300 font-semibold uppercase text-xs">Precio</th>
                            <th class="p-3 text-slate-300 font-semibold uppercase text-xs">Stock</th>
                            <th class="p-3 text-center text-slate-300 font-semibold uppercase text-xs"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                      <?php foreach($peliculas as $peli){ ?>
                        <tr class="hover:bg-white/5 transition">
                            <td class="p-3 text-slate-400"><?= $peli->id_pelicula ?></td>
                            <td class="p-3">
                                <img src="img/<?= $peli->imagen ?>" class="w-12 h-16 object-cover rounded shadow-md border border-white/10">
                            </td>
                            <td class="p-3 font-semibold text-white"><?= $peli->titulo ?></td>
                            <td class="p-3 text-emerald-400 font-bold"><?= $peli->precio ?>€</td>
                            <td class="p-3">
                                <?php if($peli->stock > 0){ ?>
                                    <span class="text-slate-300 font-medium"><?= $peli->stock ?> uds</span>
                                <?php }else{ ?>
                                    <span class="text-red-400 font-bold uppercase text-xs">Sin stock</span>
                                <?php } ?>
                            </td>
                            <td class="p-3">
                                <div class="flex justify-center gap-2">
                                    <a href="editarpeli.php?id=<?= $peli->id_pelicula ?>" class="border border-amber-500/50 bg-amber-500/20 hover:bg-amber-500/40 text-amber-300 text-xs px-3.5 py-1.5 rounded-full transition-all uppercase font-bold">Editar</a>
                                    <!-- Para que al pulsar el botón de eliminar, el administrador tenga que hacer una confirmación, he añadido un onclick con un confirm para que sea seguro. -->
                                    <a href="admin.php?eliminar_peli=<?= $peli->id_pelicula ?>" class="uppercase font-bold border border-red-500/50 bg-red-500/20 hover:bg-red-500/40 text-red-300 text-xs px-3.5 py-1.5 rounded-full transition-all" onclick="return confirm('¿Eliminar del inventario?')">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
<!-- también he añadido al panel admin una ventana para ver los usuarios registrados. -->
        <section class="bg-green-900/60 rounded-2xl p-6 shadow-2xl backdrop-blur-md border border-white/10">
            <h2 class="text-2xl font-bold mb-6 text-white drop-shadow-md">Clientes Registrados</h2>
            <ul class="divide-y divide-white/5">
              <?php foreach($usuarios as $usuario){ ?>
                <li class="py-3.5">
                    <div class="flex flex-col gap-0.5">
                        <p class="font-semibold text-white"><?= $usuario->nombre ?></p>
                        <p class="text-sm text-slate-400"><?= $usuario->email ?></p>
                    </div>
                </li>
              <?php } ?>
            </ul>
        </section>

    </main>
</body>
</html>