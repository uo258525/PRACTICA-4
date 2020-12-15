<?php
    require('BaseDatos.php');
    
if (count($_POST) > 0)
{
    if (isset($_POST["addRow"]))
    {
        $baseDatos->insertar(

            $_POST["nombre"],
            $_POST["anioNacimiento"],
            $_POST["tituloPelicula"]
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
                <p>Nombre:<input type="text" name="nombre" /> </p>
                <p>Año nacimiento: <input type="number" step="1" name="año" /></p>
                <p>Titulo pelicula: <input type="text" step="1" name="titulo" /></p>
                <input type="submit" value="Insertar Datos" name="addRow"/>
            </form>

    </div>


</body>

</html>