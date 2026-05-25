<?php

// FUNCIONALIDADES CRUD DEL PANEL DE ADMINISTRADOR
// Estas 3 primeras funciones son para recoger los datos de la base de datos mediante consultas (READ). Las siguientes son para el resto de las funcionalidades CRUD: CREATE, DELETE y UPDATE.
function obtenerPeliculas($conexion, $id_categoria = null) {
    if ($id_categoria) {
        $stmt = $conexion->prepare("SELECT * from peliculas where id_categoria = :id_categoria");
        $stmt->execute([':id_categoria' => $id_categoria]);
    } else {
        $stmt = $conexion->query("SELECT * from peliculas");
    }
    $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

    
    return $resultado;
}

function obtenerUsuarios($conexion) {
    $stmt = $conexion->query("SELECT * from usuarios order by id_usuario desc");
    $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $resultado;
}

function obtenerCategorias($conexion) {
    $stmt = $conexion->query("SELECT * from categorias");
    $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $resultado;
}

function obtenerIdPelicula($conexion, $id) {
    $stmt = $conexion->prepare("SELECT * from peliculas where id_pelicula = :id");
    $stmt->execute([':id' => $id]);
    $resultado = $stmt->fetch(PDO::FETCH_OBJ);
    return $resultado;
}

function subirPelicula($conexion, $titulo, $descripcion, $url_video, $fecha_estreno, $id_categoria, $precio, $stock, $archivoImagen = null) {
    $stmt = $conexion->prepare("INSERT INTO peliculas (titulo, descripcion, imagen, url_video, fecha_estreno, id_categoria, precio, stock) values (:titulo, :descripcion, :imagen, :url_video, :fecha_estreno, :id_categoria, :precio, :stock)");
    $stmt->execute([
        ':titulo' => $titulo,
        ':descripcion' => $descripcion,
        ':imagen' => null,
        ':url_video' => $url_video,
        ':fecha_estreno' => $fecha_estreno,
        ':id_categoria' => $id_categoria,
        ':precio' => $precio,
        ':stock' => $stock
    ]);
    
    $id_peli = $conexion->lastInsertId();

    if ($archivoImagen && isset($archivoImagen['name']) && $archivoImagen['name'] != '') {
        $nombreOriginal = $archivoImagen['name'];
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        $nuevoNombre = $id_peli . '.' . $extension;
        $destino = 'img/' . $nuevoNombre;
        
        move_uploaded_file($archivoImagen['tmp_name'], $destino);
        
        $stmtUpdate = $conexion->prepare("UPDATE peliculas set imagen = :imagen where id_pelicula = :id");
        $stmtUpdate->execute([':imagen' => $nuevoNombre, ':id' => $id_peli]);
    }

    return $id_peli;
}


function borrarPelicula($conexion, $id) {
    $stmt = $conexion->prepare("DELETE from peliculas where id_pelicula = :id");
    $resultado = $stmt->execute([':id' => $id]);
    return $resultado;
}


function editarPelicula($conexion, $id, $titulo, $descripcion, $url_video, $fecha_estreno, $id_categoria, $precio, $stock, $imagen = null) {
    if ($imagen) {
        $stmt = $conexion->prepare("UPDATE peliculas set titulo = :titulo, descripcion = :descripcion, url_video = :url_video, fecha_estreno = :fecha_estreno, id_categoria = :id_categoria, precio = :precio, stock = :stock, imagen = :imagen where id_pelicula = :id");
        return $stmt->execute([
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':url_video' => $url_video,
            ':fecha_estreno' => $fecha_estreno,
            ':id_categoria' => $id_categoria,
            ':precio' => $precio,
            ':stock' => $stock,
            ':imagen' => $imagen,
            ':id' => $id
        ]);
    } else {
        $stmt = $conexion->prepare("UPDATE peliculas set titulo = :titulo, descripcion = :descripcion, url_video = :url_video, fecha_estreno = :fecha_estreno, id_categoria = :id_categoria, precio = :precio, stock = :stock where id_pelicula = :id");
        return $stmt->execute([
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':url_video' => $url_video,
            ':fecha_estreno' => $fecha_estreno,
            ':id_categoria' => $id_categoria,
            ':precio' => $precio,
            ':stock' => $stock,
            ':id' => $id
        ]);
    }
}
?>