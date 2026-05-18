<?php
require_once 'init.php';
require_once "db.php";
require_once "functions.php";


if(!isset($_SESSION['email'])){
    header("Location: login.php");
}

if($_SESSION['rol'] !== 'admin' ){
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - MoodPlay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans">

   
    <nav class="bg-slate-900 text-white p-4 flex justify-between items-center shadow-lg">
        <h1 class="text-xl font-bold">MoodPlay Backend</h1>
        <a href="logout.php" class="bg-red-500 px-4 py-2 rounded hover:bg-red-600 transition">Cerrar Sesión</a>
    </nav>

    <main class="p-8 max-w-6xl mx-auto">
        
      
        <section class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-slate-800">Añadir Nueva Película / Serie</h2>
            <form action="procesar_peli.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-4">
                <input type="text" name="titulo" placeholder="Título" required class="border p-2 rounded ring-1 ring-slate-200 focus:ring-blue-500 outline-none">
                <input type="number" step="0.01" name="precio" placeholder="Precio (Ej: 9.99)" required class="border p-2 rounded ring-1 ring-slate-200 focus:ring-blue-500 outline-none">
                <textarea name="descripcion" placeholder="Descripción" class="border p-2 rounded col-span-2 ring-1 ring-slate-200 focus:ring-blue-500 outline-none"></textarea>
                <div class="flex flex-col">
                    <label class="text-sm text-slate-500 mb-1">Imagen de Portada</label>
                    <input type="file" name="imagen" class="text-sm">
                </div>
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700 transition col-span-2">
                    Guardar Producto
                </button>
            </form>
        </section>

       
        <section class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-slate-800">Inventario de Películas</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-slate-100">
                            <th class="p-3 text-slate-600">ID</th>
                            <th class="p-3 text-slate-600">Miniatura</th>
                            <th class="p-3 text-slate-600">Título</th>
                            <th class="p-3 text-slate-600">Precio</th>
                            <th class="p-3 text-center text-slate-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($peliculas as $peli): ?>
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                            <td class="p-3 text-slate-500"><?= $peli->id_pelicula ?></td>
                            <td class="p-3">
                                <img src="img/<?= $peli->imagen ?>" class="w-12 h-16 object-cover rounded shadow-sm" alt="Portada">
                            </td>
                            <td class="p-3 font-medium text-slate-700"><?= $peli->titulo ?></td>
                            <td class="p-3 text-blue-600 font-bold"><?= $peli->precio ?>€</td>
                            <td class="p-3 flex justify-center gap-2">
                                <a href="editar_peli.php?id=<?= $peli->id_pelicula ?>" class="bg-amber-400 text-white px-3 py-1 rounded text-sm hover:bg-amber-500">Editar</a>
                                <a href="admin.php?eliminar_peli=<?= $peli->id_pelicula ?>" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600" onclick="return confirm('¿Eliminar película?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

       
        <section class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4 text-slate-800">Clientes Registrados</h2>
            <ul class="divide-y divide-slate-100">
                <?php foreach($usuarios as $user): ?>
                <li class="py-3 flex justify-between items-center">
                    <div>
                        <p class="font-medium text-slate-700"><?= $user->nombre ?></p>
                        <p class="text-sm text-slate-400"><?= $user->email ?></p>
                    </div>
                    <button class="text-red-500 hover:underline text-sm font-semibold">Eliminar Acceso</button>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>

    </main>
</body>
</html>