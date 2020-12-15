<?php
class BaseDatos
{


    public function connect()
    {
        $servername = "127.0.0.1:3306";
        $username = "DBUSER2020";
        $password = "DBPSWD2020";
        $database = "mydb";

        $db = new mysqli($servername, $username, $password, $database);

        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        } else {
            return $db;
        }
    }
    public function crearBase()
    {
        $servername = "localhost";
        $username = "DBUSER2020";
        $password = "DBPSWD2020";
        $datab = new mysqli($servername, $username, $password);

        //comprobamos conexión
        if ($datab->connect_error) {
            exit("<p>ERROR de conexión:" . $datab->connect_error . "</p>");
        } else {
            echo "<p>Conexión establecida.</p>";
        }


        $cadenaSQL = "CREATE DATABASE IF NOT EXISTS mydb COLLATE utf8_spanish_ci";
        if ($datab->query($cadenaSQL) === true) {
            echo "<p>Base de datos creada con éxito</p>";
        } else {
            echo "<p>ERROR en la creación de la base de datos</p>";
            exit();
        }

        $datab->close();
    }

    public function crearTabla()
    {

        $db = $this->connect();

        //Crear la tabla PruebasUsabilidad DNI, Nombre, Apellido
        $crearTabla = "CREATE TABLE IF NOT EXISTS Peliculas (id INT NOT NULL AUTO_INCREMENT, 
        titulo VARCHAR(50) NOT NULL,
        anio INT NOT NULL, 
        puntuacion INT,
        PRIMARY KEY (id))";


        if ($db->query($crearTabla) === true) {
            echo "<p>Tabla Peliculas creada con éxito </p>";
        } else {
            echo "<p>ERROR en la creación de la tabla Peliculas</p>";
            exit();
        }
        $db->close();
    }
    public function insertar(
        $titulo,
        $anio,
        $puntuacion
    ) {
        $db = $this->connect();

        $consultaPre = $db->prepare("INSERT INTO Peliculas (titulo, anio, 
        puntuacion) 
        VALUES (?,?,?)");
        $consultaPre->bind_param(
            'sid',
                $titulo,
                $anio,
                $puntuacion
        );

        $consultaPre->execute();

        echo "<p>Filas agregadas: " . $consultaPre->affected_rows . "</p>";

        $consultaPre->close();
        $db->close();
    }
    public function buscar($titulo)
    {
        $db = $this->connect();
        
        $consultaPre = $db->prepare("SELECT * FROM Peliculas WHERE titulo = ?");
        $consultaPre->bind_param('s', $titulo);
        $consultaPre->execute();
        $resultado = $consultaPre->get_result();

        if ($resultado) {
            echo "<p>Datos de la Pelicula buscada son: ";

            while ($row = $resultado->fetch_assoc()) {
                echo "Titulo: " .$row['titulo']." - anio: ". $row['anio']." - Puntuacion: ".
                $row['puntuacion']."</p>";
            }
        } else {
            echo "Sin resultados";
        }
       
        $consultaPre->close();
        $db->close();
    }

    public function eliminar($titulo)
    {
        $db = $this->connect();

        $consultaPre = $db->prepare("SELECT * FROM Peliculas WHERE titulo = ?");
        $consultaPre->bind_param('s', $titulo);
        $consultaPre->execute();
        $resultado = $consultaPre->get_result();

        if ($resultado) {
            echo "<p>Los datos de la Pelicula que va a ser eliminada son:</p> ";
            while ($row = $resultado->fetch_assoc()) {
                $id = $row['id'];
                echo  "<p>".$row['id']." ".$row['titulo']." ".$row['anio']." ". $row['puntuacion']."</p>";
            }
        } else {
            echo "Sin resultados";
        }

        $consultaPre = $db->prepare("DELETE FROM Peliculas WHERE id = ?");
        $consultaPre->bind_param('i', $id);
        $consultaPre->execute();
        
        $consultaPre->close();
        $db->close();
    }
   

    public function cargarDatos()
        {
            if (($h = fopen("peliculas.csv", "r")) !== false) {
                while (($data = fgetcsv($h, 1000, ";")) !== false) {
                    $this->insertar($data[0], $data[1], $data[2]);
                }
                fclose($h);
            }
        }

        public function exportarDatos()
        {
            $db = $this->connect();

            $consultaPre = $db->prepare("SELECT * FROM Peliculas");
            $consultaPre->execute();
            $resultado = $consultaPre->get_result();

            if ($resultado) {

                $datos = "";
                while ($row = $resultado->fetch_assoc()) {
                    $datos .= $row['titulo'].";". $row['anio'].";" . $row['puntuacion']."\r\n";
                }
                $NombreArchivo ="peliculas.csv";
                file_put_contents($NombreArchivo, $datos);
                echo "<p>Datos escritos en el fichero ".$NombreArchivo."</p>";
            } else {
                echo "Sin resultados";
            }
           
            $consultaPre->close();
            $db->close();
        }

    public function generarInforme()
        {
            
            $db = $this->connect();

            $consultaPre = $db->prepare("SELECT * FROM Peliculas ORDER BY puntuacion DESC");
            $consultaPre->execute();
            $resultado = $consultaPre->get_result();

            if ($resultado) {
                echo "<p>Informe de las Peliculas ordenadas por su puntuacion: ";
                echo "<table>
                <tr>
                    <th>Titulo</th>
                    <th>año</th>
                    <th>Puntuación</th>
                </tr>";
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr> <td>" .$row['titulo']."</td> <td>". $row['anio']."</td> <td>" . $row['puntuacion'] ."</td> </tr>";
                }
                echo "</table>";
            } else {
                echo "Sin resultados";
            }
           
            $consultaPre->close();
            $db->close();
        }
}
$baseDatos = new BaseDatos();
?>
