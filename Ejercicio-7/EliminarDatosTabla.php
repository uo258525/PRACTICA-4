<?php
require("BaseDatos.php");

if (count($_POST) > 0)
{
    if (isset($_POST["eliminar"]))
    {
        $baseDatos->eliminar(

            $_POST["codigo"]
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

    <h1>Eliminar datos de la tabla</h1>
    <div class="content">
    
    <a href="Ejercicio6.php" title="Volver">Volver a Inicio </a>
    <form method="post"">
                <p>Titulo: <input type="text" name="titulo" /> </p>
                <input type="submit" value="Eliminar" name="Eliminar" />
            </form>

    </div>


</body>

</html>