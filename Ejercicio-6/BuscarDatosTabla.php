<?php
require("BaseDatos.php");

if (count($_POST) > 0)
{
    if (isset($_POST["addRow"]))
    {
        $baseDatos->buscar(

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
    <link href="Ejercicio6.css" rel="stylesheet" />

</head>

<body>
<h1>Buscar datos en la tabla</h1>

    <div class="content">
        <section>
        
            <a href="Ejercicio6.php" title="Volver">Volver a Inicio </a>


            <form method="post">
                <p>Codigo: <input type="text" name="codigo" /> </p>
                <input type="submit" value="Buscar" name="buscarDatos" />
            </form>



        </section>
    </div>


</body>

</html>