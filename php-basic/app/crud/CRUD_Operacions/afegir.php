<?php

$missatge = '';

require 'funcions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $multijugador = $_POST['multijugador'];
    $peso = $_POST['peso'];

    $idvideojocnou = afegirVideojoc($nombre, $categoria, $precio, $multijugador, $peso);

    if ($idvideojocnou == 0) {

        $missatge = "Error, ja existeix aquest videojoc";

    } elseif ($idvideojocnou == 1) {

        $missatge = "El preu i el pes han de ser numèrics.";

    } elseif ($idvideojocnou == 2) {

        $missatge = "El preu i el pes han de ser valors positius.";

    }

    else {
    
    if ($idvideojocnou >= 0) {
        $missatge = "Videojoc afegit correctament.";
    } else {
        $missatge = "Error en afegir el videojoc.";
    }

    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Afegir Videojoc</title>
    <style>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
  background: hsl(0 0% 98%);
  color: hsl(222 84% 5%);
  padding: 2rem;
  line-height: 1.6;
  display: flex;
  flex-direction: column;
  align-items: center;
  min-height: 100vh;
}

h1 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 2rem;
  color: hsl(222 47% 11%);
  text-align: center;
}

form {
  max-width: 28rem;
  width: 100%;
  background: hsl(0 0% 100%);
  padding: 2rem;
  border-radius: 0.5rem;
  border: 1px solid hsl(214 32% 91%);
}

label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 0.5rem;
  color: hsl(222 47% 11%);
}

input, select {
  width: 100%;
  padding: 0.625rem 0.75rem;
  border: 1px solid hsl(214 32% 91%);
  border-radius: 0.375rem;
  font-size: 0.875rem;
  margin-bottom: 1.25rem;
  background: hsl(0 0% 100%);
  transition: all 0.2s;
}

input:focus {
  outline: none;
  border-color: hsl(222 84% 5%);
  box-shadow: 0 0 0 3px hsl(222 84% 5% / 0.1);
}

button {
  width: 100%;
  padding: 0.625rem 1rem;
  background: hsl(222 47% 11%);
  color: hsl(210 40% 98%);
  border: none;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
}

button:hover {
  background: hsl(222 47% 11% / 0.9);
}

p {
  padding: 0.75rem 1rem;
  margin-bottom: 1rem;
  border-radius: 0.375rem;
  background: hsl(210 40% 96%);
  color: hsl(222 47% 11%);
  font-size: 0.875rem;
}

    </style>

</head>
<body>
    <h1>Afegir Nou Videojoc</h1>
    <form action="afegir.php" method="post">

    <?php if (isset($missatge) && $missatge): ?>
    <p><?= htmlspecialchars($missatge) ?></p>
    <?php endif; ?>
        <label for="nombre">Nom:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>
        <label for="categoria">Categoria:</label>
        <input type="categoria" id="categoria" name="categoria" required>
        <br>
        <label for="precio">Preu:</label>
        <input type="number" id="precio" name="precio" required>
        <br>
        <label for="multijugador">Multijugador:</label>
        <select id="multijugador" name="multijugador" required>
        <option value="1">Si</option>
        <option value="0">No</option>
        </select>
        <br>
        <label for="peso">Pes (en GB):</label>
        <input type="number" id="peso" name="peso" required>
        <br>
        <button type="submit">Afegir</button>
    </form>
</body>
</html>

