<?php
session_start();
require("BaseDatos.php");

if (count($_POST) > 0)
{
    if (isset($_POST["createDb"]))
    {
        echo "<p><b>createDb</b></p>";
        $baseDatos->crearBase();
    }
    else if (isset($_POST["createTable"]))
    {
        echo "<p><b>createTable</b></p>";
        $baseDatos->crearTabla();
    }
    else if (isset($_POST["cargarDatos"]))
    {
        echo "<p><b>cargarDatos</b></p>";
        $baseDatos->cargarDatos();
    }
    else if (isset($_POST["exportarDatos"]))
    {
        echo "<p><b>exportarDatos</b></p>";
        $baseDatos->exportarDatos();
    }
    else if (isset($_POST["generarInforme"]))
    {
        echo "<p><b>generarInforme</b></p>";
        $baseDatos->generarInforme();
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

    <h1>Gestión de base de datos</h1>
    <div class="content">

    <section>
        <h2>Acciones disponibles</h2>
        <form method="post">
            <input type="submit" name="createDb" value="Crear Base de Datos" />
            <input type="submit" name="createTable" value="Crear Tabla 'PruebasUsabilidad'" />
            <input type="submit" name="cargarDatos" value="Cargar Datos" />
            <input type="submit" name="exportarDatos" value="Exportar Datos" />
            <input type="submit" name="generarInforme" value="Generar Informe" />
        </form>
        <ul>
            <li><a href="InsertarDatosTabla.php" title="InsertarDatosTabla">Insertar Datos
                    en tabla </a></li>
            <li><a href="BuscarDatosTabla.php" title="BuscarDatosTabla">Buscar Datos en
                    tabla </a></li>
                    <li><a href="ModificarDatosTabla.php" title="ModificarDatosTabla">Modificar datos en
                    tabla </a></li>
            <li><a href="EliminarDatosTabla.php" title="EliminarDatosTabla">Eliminar datos en
                    tabla </a></li>
            
        </ul>
    </section>
    </div>


</body>

</html>