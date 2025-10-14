<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Llistat de Videojocs</title>

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

a {
  color: hsl(222 47% 11%);
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s;
}

a:hover {
  color: hsl(222 47% 11% / 0.7);
}

table {
  width: 100%;
  max-width: 60rem;
  background: hsl(0 0% 100%);
  border-collapse: collapse;
  border-radius: 0.5rem;
  overflow: hidden;
  border: 1px solid hsl(214 32% 91%);
  margin-top: 1rem;
}

th {
  background: hsl(222 47% 11%);
  color: hsl(210 40% 98%);
  padding: 0.875rem 1rem;
  text-align: left;
  font-weight: 600;
  font-size: 0.875rem;
}

td {
  padding: 0.875rem 1rem;
  border-bottom: 1px solid hsl(214 32% 91%);
  font-size: 0.875rem;
}

tr:last-child td {
  border-bottom: none;
}

tr:hover {
  background: hsl(210 40% 98%);
}

td a {
  margin-right: 0.5rem;
  font-size: 0.875rem;
}

button {
  width: 40%;
  padding: 0.625rem 1rem;
  background: hsl(222 47% 11%);
  color: hsl(210 40% 98%);
  border: none;
  border-radius: 0.375rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
  margin: 50px;
}

button a {

    color: white;

}

button a:hover {

    color: gray;

}

button:hover {
  background: hsl(222 47% 11% / 0.9);
}

</style>

</head>

<?php

    require 'funcions.php';
    $videojocs = llistarVideojocs();

    echo "<h1>Llista de Videojocs</h1>";

    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Categoria</th>
                <th>Preu</th>
                <th>Multijugador</th>
                <th>Pes</th>
            </tr>";

    foreach ($videojocs as $videojoc) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($videojoc['id']) . "</td>";
        echo "<td>" . htmlspecialchars($videojoc['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($videojoc['categoria']) . "</td>";
        echo "<td>" . htmlspecialchars($videojoc['precio']) . " € </td>";
        echo "<td>"; if($videojoc['multijugador']>0) {

            echo "Si";
        } else {
            echo "No";

        } echo "</td>";
        echo "<td>" . htmlspecialchars($videojoc['peso']) . " GB </td>";
        echo "</tr>";
    }

    echo "</table>";

    echo "<button><a href='afegir.php'>Afegir Nou Videojoc</a></button><br><br>";

?>