<?php
require("BaseDatos.php");

if (count($_POST) > 0)
{
    if (isset($_POST["addRow"]))
    {
        $baseDatos->insertar(

            $_POST["codigo"],
            $_POST["nombre"],
            $_POST["apellidos"],
            $_POST["email"],
            $_POST["telefono"],
            $_POST["edad"],
            $_POST["sexo"],
            $_POST["pericia"],
            $_POST["minutos"],
            $_POST["exito"],
            $_POST["exito"],
            $_POST["comentarios"],
            $_POST["propuestas"],
            $_POST["valoracion"]
        );


    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Ejercicio 6</title>
    <meta charset="utf-8" />
    <link href="Ejercicio6.css" rel="stylesheet" />

</head>

<body>

    <h1>Añadir datos a la tabla</h1>
    <div class="content">
    
    <a href="Ejercicio6.php" title="Volver">Volver a Inicio </a>

        <form method="post">
            <p>Codigo:<input type="text" name="codigo" /> </p>
            <p>Nombre: <input type="text" step="1" name="nombre" /></p>
            <p>Apellidos: <input type="text" step="1" name="apellidos" /></p>
            <p>Email: <input type="text" step="1" name="email" /></p>
            <p>Telefono: <input type="text" step="1" name="telefono" /></p>
            <p>Edad: <input type="number" step="1" name="edad" /></p>
            <p>Sexo:<input type="text" name="sexo" /> </p>
            <p>Pericia: <input type="number" step="1" name="pericia" /></p>
            <p>Minutos: <input type="number" step="1" name="minutos" /></p>
            <p>Exito [SI, NO]:<input type="text" name="exito" /> </p>
            <p>Comentarios:<input type="text" name="comentarios" /> </p>
            <p>Propuestas:<input type="text" name="propuestas" /> </p>
            <p>Valoracion: <input type="number" step="1" name="valoracion" /></p>
            <input type="submit" name="addRow" value="Añadir Fila" />
        </form>

    </div>


</body>

</html>