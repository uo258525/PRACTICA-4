<?php
require("BaseDatos.php");

if (count($_POST) > 0)
{
    if (isset($_POST["modificarDatos"]))
    {
        $baseDatos->modificar(

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

    <h1>Introducir datos a la tabla</h1>
    <div class="content">
    
    <a href="Ejercicio6.php" title="Volver">Volver a Inicio </a>

       
    <form method="post" >
                <p>Codigo de la persona a actualizar:<input type="text" name="codigo" /> </p>
                <p>Nuevo nombre: <input type="text" step="1" name="nombre" /></p>
                <p>Nuevos apellidos: <input type="text" step="1" name="apellidos" /></p>
                <p>Nuevo email: <input type="text" step="1" name="email" /></p>
                <p>Nuevo telefono: <input type="text" step="1" name="telefono" /></p>
                <p>Nueva Edad: <input type="number" step="1" name="edad" /></p>
                <p>Nuevo Sexo:<input type="text" name="sexo" /> </p>
                <p>Nueva Pericia: <input type="number" step="1" name="pericia" /></p>
                <p>Nuevos Minutos: <input type="number" step="1" name="minutos" /></p>
                <p>Nuevo Exito [SI, NO]:<input type="text" name="exito" /> </p>
                <p>Nuevos Comentarios:<input type="text" name="comentarios" /> </p>
                <p>Nuevas Propuestas:<input type="text" name="propuestas" /> </p>
                <p>Nueva Valoracion: <input type="number" step="1" name="valoracion" /></p>
                <input type="submit" name="modificarDatos" value="Actualizar Datos" />
            </form>

    </div>


</body>

</html>
