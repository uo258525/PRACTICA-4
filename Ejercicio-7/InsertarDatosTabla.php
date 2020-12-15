<?php
require("BaseDatos.php");

if (count($_POST) > 0)
{
    if (isset($_POST["addRow"]))
    {
        $baseDatos->insertar(

            $_POST["titulo"],
            $_POST["anio"],
            $_POST["puntuacion"]
        );


    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 7</title>
    <meta charset="utf-8" />
    <link href="Ejercicio7.css" rel="stylesheet" />

</head>

<body>

    <h1>Añadir datos a la tabla</h1>
    <div class="content">
    
    <a href="Ejercicio7.php" title="Volver">Volver a Inicio </a>

    <form method="post" >
                <p>Titulo:<input type="text" name="titulo" /> </p>
                <p>Año: <input type="number" step="1" name="año" /></p>
                <p>Puntuacion: <input type="number" step="1" name="puntuacion" /></p>
                <input type="submit" value="Insertar Datos" name="addRow" />
            </form>

    </div>


</body>

</html>