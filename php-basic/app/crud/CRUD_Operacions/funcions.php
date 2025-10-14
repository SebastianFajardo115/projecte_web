<?php

require 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
    echo "Error de connexió: " . $e->getMessage();
}

function afegirVideojoc($nombre, $categoria, $precio, $multijugador, $peso) {

    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Videojuego WHERE nombre = ?");
    if ($stmt->execute([$nombre]) && $stmt->fetchColumn() > 0) {
        return 0;
    }
    elseif (!is_numeric($precio) || !is_numeric($peso)) {
    $missatge = 1;
    } 
    
    elseif ($precio < 0 || $peso < 0) {
    $missatge = 2;
    }

    else {
    $stmt = $pdo->prepare("INSERT INTO Videojuego (nombre, categoria, precio, multijugador, peso) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $categoria, $precio, $multijugador, $peso]);

    $missatge = $pdo->lastInsertId();

    
}

    return $missatge;

}

function llistarVideojocs() {

    global $pdo;
    $stmt = $pdo->query("SELECT id, nombre, categoria, precio, multijugador, peso FROM Dev_BiblioJuegos.Videojuego");
    return $stmt->fetchAll();

}

?>