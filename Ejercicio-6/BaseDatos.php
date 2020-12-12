<?php
class BaseDatos
{


    public function connect()
    {
        $servername = "Local";
        $username = "DBUSER2020";
        $password = "DBPSWD2020";
        $database = "mydb";

        $db = new mysqli($servername, $username, $password, $database);

        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        } else {
            echo "<p>Conexión establecida.</p>";
            return $db;
        }
    }
    public function crearBase()
    {
        $servername = "Local";
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
        $crearTabla = "CREATE TABLE IF NOT EXISTS PruebasUsabilidad (id INT NOT NULL AUTO_INCREMENT, 
                  codigo VARCHAR(9) NOT NULL,
                  nombre VARCHAR(20) NOT NULL,
                  apellidos VARCHAR(30) NOT NULL,
                  email VARCHAR(50) NOT NULL,
                  telefono VARCHAR(10) NOT NULL,
                  edad INT NOT NULL, 
                  sexo VARCHAR(9) NOT NULL,
                  pericia INT,
                  minutos INT,
                  exito VARCHAR(9),
                  comentarios VARCHAR(140),
                  propuestas VARCHAR(140),
                  valoracion INT,
                  CHECK (pericia>=0 AND pericia<=10),
                  CHECK (valoracion>=0 AND valoracion<=10),  
                  PRIMARY KEY (id))";


        if ($db->query($crearTabla) === true) {
            echo "<p>Tabla PruebasUsabilidad creada con éxito </p>";
        } else {
            echo "<p>ERROR en la creación de la tabla PruebasUsabilidad</p>";
            exit();
        }
        $db->close();
    }
    public function insertar(
        $codigo,
        $nombre,
        $apellidos,
        $email,
        $telefono,
        $edad,
        $sexo,
        $pericia,
        $minutos,
        $exito,
        $comentarios,
        $propuestas,
        $valoracion
    ) {
        $db = $this->connect();

        $consultaPre = $db->prepare("INSERT INTO PruebasUsabilidad (codigo, nombre, apellidos, email, telefono,edad, sexo,
    pericia, minutos, exito, comentarios, propuestas, valoracion) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $consultaPre->bind_param(
            'sisiisssi',
            $codigo,
            $nombre,
            $apellidos,
            $email,
            $telefono,
            $edad,
            $sexo,
            $pericia,
            $minutos,
            $exito,
            $comentarios,
            $propuestas,
            $valoracion
        );

        $consultaPre->execute();

        echo "<p>Filas agregadas: " . $consultaPre->affected_rows . "</p>";

        $consultaPre->close();
        $db->close();
    }
    public function buscar($codigo)
    {
        $db = $this->connect();
        $consultaPre = $db->prepare("SELECT * FROM PruebasUsabilidad WHERE codigo = ?");
        $consultaPre->bind_param('s', $codigo);
        $consultaPre->execute();
        $resultado = $consultaPre->get_result();

        if ($resultado) {
            echo "<p>Datos de la Prueba de Usabilidad buscada son: ";

            while ($row = $resultado->fetch_assoc()) {
                echo "CODIGO: " . $_POST["codigo"] . " - Edad: " . $row['edad'] . " - Sexo: " . $row['sexo'] . " - Pericia: " . $row['pericia'] . " - Minutos: " .
                    $row['minutos'] . " - Exito: " . $row['exito'] . " - Comentarios: " . $row['comentarios'] . " - Propuestas: " . $row['propuestas'] .
                    " - Valoracion: " . $row['valoracion'] . "</p>";
            }
        } else {
            echo "Sin resultados";
        }
        $consultaPre->close();
        $db->close();
    }

    public function modificar(
        $codigo,
        $nombre,
        $apellidos,
        $email,
        $telefono,
        $edad,
        $sexo,
        $pericia,
        $minutos,
        $exito,
        $comentarios,
        $propuestas,
        $valoracion
    ) {
        $db = $this->connect();

        //preparo la sentencia de inserción
        $consultaPre = $db->prepare("UPDATE PruebasUsabilidad SET edad =?, sexo=?,
        pericia=?, minutos=?, exito=?, comentarios=?, propuestas=?, valoracion=?
        WHERE codigo = ?");

        //añado los parámetros de la variable Predefinida $_POST
        $consultaPre->bind_param(
            'isiisssis',
            $codigo,
            $nombre,
            $apellidos,
            $email,
            $telefono,
            $edad,
            $sexo,
            $pericia,
            $minutos,
            $exito,
            $comentarios,
            $propuestas,
            $valoracion,
            
        );

        $consultaPre->execute();

        echo "<p>Filas actualizadas: " . $consultaPre->affected_rows . "</p>";

        $consultaPre->close();
        $db->close();
    }
    public function delete($codigo)
    {
        $db = $this->connect();


        $consultaPre = $db->prepare("SELECT * FROM PruebasUsabilidad WHERE codigo = ?");
        $consultaPre->bind_param('s', $codigo);
        $consultaPre->execute();
        $resultado = $consultaPre->get_result();
        if ($resultado) {
            echo "<p>Los datos de la Prueba de Usabilidad que va a ser eliminada son:</p> ";
            while ($row = $resultado->fetch_assoc()) {
                $id = $row['id'];
                echo  $row['id'] . " " . $row['codigo'] . " " . $row['edad'] . " " . $row['sexo'] . " " . $row['pericia'] . " " .
                    $row['minutos'] . " " . $row['exito'] . "</p>";
            }
        } else {
            echo "Sin resultados";
        }

        $consultaPre = $db->prepare("DELETE FROM PruebasUsabilidad WHERE id = ?");
        $consultaPre->bind_param('i', $id);
        $consultaPre->execute();

        $consultaPre->close();
        $db->close();
    }
    function generarInforme(){

        $db = $this->connect();


        $consultaPre = $db->prepare("SELECT * FROM persona");      

        $consultaPre->execute();

        $resultado = $consultaPre->get_result();

        if ($resultado) {
            
            echo "<p>Informe con los siguientes datos: CODIGO  NOMBRE  APELLIDOS</p>";

            while($row = $resultado->fetch_assoc()) {

                echo "<p>CODIGO:" . $row['codigo'] . " Nombre y apellidos: ".$row['nombre'].", ". $row['apellidos'] ."</p>"; 
            }
 
        } else {

            echo "Sin resultados";
        }

        $consultaPre->close();
        $db->close();

    }

    public function cargarDatos()
        {
            if (($h = fopen("data.csv", "r")) !== false) {
                while (($data = fgetcsv($h, 1000, ";")) !== false) {
                    $this->insertar($data[0], $data[1],$data[2],$data[3],$data[4],
                    $data[5],$data[6],$data[7],$data[8],$data[9],$data[10], $data[11],$data[12]);
                }
                fclose($h);
            }
        }

        public function exportarDatos()
        {
            $db = $this->connect();

            $consultaPre = $db->prepare("SELECT * FROM PruebasUsabilidad");
            $consultaPre->execute();
            $resultado = $consultaPre->get_result();

            if ($resultado) {

                $datos = "";
                while ($row = $resultado->fetch_assoc()) {
                    $datos .= $row["codigo"].";".$row['nombre'].";".$row['apellidos'].";".$row['email'].";".$row['telefono'].";".$row['edad'].";". $row['sexo'].";". $row['pericia'].";".
                    $row['minutos'].";" . $row['exito'] .";" . $row['comentarios'] .";" . $row['propuestas'] .
                    ";" . $row['valoracion']."\r\n";
                }
                $NombreArchivo = date("d.m.y").time().".csv";
                file_put_contents($NombreArchivo, $datos);
                echo "<p>Datos escritos en el fichero ".$NombreArchivo."</p>";
            } else {
                echo "Sin resultados";
            }
           
            $consultaPre->close();
            $db->close();
        }

    public function informeMedio()
        {
            $db = $this->connect();

            $consultaPre = $db->prepare("SELECT avg(edad) AS edadMedia, avg(pericia) AS periciaMedia,
            avg(minutos) AS minutosMedia, avg(valoracion) AS valoracionMedia FROM PruebasUsabilidad");
            $consultaPre->execute();
            $resultado = $consultaPre->get_result();

            if ($resultado) {
                echo "<p>Informe de las Prueba de Usabilidad: ";
                echo "<table>
                <tr>
                    <th>Edad Media</th>
                    <th>Pericia Media</th>
                    <th>Minutos de media</th>
                    <th>Valoracion media</th>
                </tr>";
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr> <td>" .$row['edadMedia']." años </td> <td>". $row['periciaMedia']."</td> <td>".
                    $row['minutosMedia']."</td> <td>" . $row['valoracionMedia'] ."</td> </tr>";
                }
                echo "</table>";
            } else {
                echo "Sin resultados";
            }
           
            $consultaPre->close();
            $db->close();
        }
}
