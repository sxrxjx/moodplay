<?php
require_once 'init.php';
require_once 'db.php';
require_once 'functions.php';

if($_SESSION['rol'] != 'ADMIN' ){
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id=$_POST['id'];
    $titulo =  $_POST['titulo'];
    $precio = $_POST['precio'];
    $stock= $_POST['stock'];
    $descripcion=$_POST['descripcion'];
    $url_video = $_POST['url_video'];
    $fecha_estreno = $_POST['fecha_estreno'];
    $id_categoria =  $_POST['id_categoria'];

    $imagenActualizada = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['name'] != '') {
        $nombreOriginal = $_FILES['imagen']['name'];
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        $imagenActualizada = $id . '.' . $extension;
        move_uploaded_file($_FILES['imagen']['tmp_name'], 'img/' . $imagenActualizada);
    }

    editarPelicula($conexion, $id, $titulo, $descripcion, $url_video, $fecha_estreno, $id_categoria, $precio, $stock, $imagenActualizada);
    header("Location: admin.php");
    exit;


}

$peli = obtenerIdPelicula($conexion, $_GET['id']);

if (!$peli) {
    header("Location: admin.php");
    exit;

}


$categorias = obtenerCategorias($conexion);

?>

<?php
include_once 'header.php';



?>
<body class="bg-gray-900 min-h-screen text-white font-sans">

    <nav class="sticky top-0 z-10 bg-gray-950/80 backdrop-blur-md text-white p-4 flex justify-between items-center shadow-lg border-b border-white/10">
        <a href="index.php"><img src="img/logomoodplay.png" class="h-10 w-auto hover:scale-105 transition-all duration-300"></a> 
        <h1 class="text-xl font-bold tracking-wider uppercase text-emerald-400">Editar</h1>
        <div class="flex items-center gap-4">
            <a href="admin.php" class="border border-emerald-500/50 bg-emerald-500/20 text-emerald-300 text-xs px-3.5 py-1.5 hover:bg-emerald-500/40 rounded-full transition-all uppercase font-semibold">Volver</a>
        </div>
    </nav>

    <main class="p-8 max-w-2xl mx-auto">
        <section class="bg-green-900/60 backdrop-blur-md border border-white/10 rounded-2xl p-8 shadow-2xl mb-8">
            <h2 class="text-2xl font-bold mb-6 text-white drop-shadow-md">Editar: <?= $peli->titulo ?></h2>
            <form action="editarpeli.php?id=<?= $peli->id_pelicula ?>" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
                <input type="hidden" name="id" value="<?= $peli->id_pelicula ?>">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Título</label>
                    <input type="text" name="titulo" value="<?= $peli->titulo ?>" required class="w-full p-3 bg-slate-950/50 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-white transition-all">
                </div>
                
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">URL del Video</label>
                    <input type="text" name="url_video" value="<?= $peli->url_video ?>" class="w-full p-3 bg-slate-950/50 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-white transition-all">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Fecha de Estreno</label>
                    <input type="date" name="fecha_estreno" value="<?= $peli->fecha_estreno ?>" required class="w-full p-3 bg-slate-950/50 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-white transition-all">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Categoría</label>
                    <select name="id_categoria" required class="w-full p-3 bg-slate-950 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-white transition-all">
                        <option value="">Selecciona una categoría</option>
                        <?php foreach($categorias as $categoria){ ?>
                            <option value="<?= $categoria->id_categoria ?>" <?php if($categoria->id_categoria == $peli->id_categoria){ echo 'selected'; } ?>><?= $categoria->nombre ?></option>
                        <?php } ?>
                    </select>
                </div>
            
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Precio</label>
                    <input type="number" step="0.01" name="precio" value="<?= $peli->precio ?>" required class="w-full p-3 bg-slate-950/50 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-white transition-all">
                </div>
                
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Unidades en Stock</label>
                    <input type="number" name="stock" value="<?= $peli->stock ?>" required class="w-full p-3 bg-slate-950/50 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:border-white transition-all">
                </div>
                
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Descripción</label>
                    <textarea name="descripcion" class="w-full bg-slate-950/50 border border-white/10 rounded-xl p-3 text-white focus:outline-none focus:border-white text-sm h-32"><?= $peli->descripcion ?></textarea>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Imagen Actual</label>
                    <?php if($peli->imagen): ?>
                        <img src="img/<?= $peli->imagen ?>" class="w-32 h-48 object-cover rounded-xl shadow-md border border-white/10 mb-2">
                    <?php else: ?>
                        <div class="w-32 h-48 bg-slate-950/50 border border-white/10 rounded-xl flex items-center justify-center text-slate-400 font-semibold mb-2">Sin Imagen</div>
                    <?php endif; ?>
                </div>
                
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Nueva Imagen</label>
                    <input type="file" name="imagen" class="w-full bg-slate-950/50 border border-white/10 rounded-xl p-3 text-sm text-slate-400 file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/20 file:text-emerald-300 hover:file:bg-emerald-500/30 file:cursor-pointer transition-all">
                </div>
                <button type="submit" class="w-full border border-white bg-emerald-500/20 hover:bg-emerald-500/40 text-white font-bold py-3 rounded-full transition-all uppercase text-sm tracking-wider mt-4">
                    Guardar Cambios
                </button>
            </form>
        </section>
    </main>
</body>
</html>
