<?php

session_start();
class CalculadoraBasica
{
    private $memoria;
    private $pantalla;

    public function __construct()
    {
        $this->pantalla = "";
        $this->memoria = "";
    }

    public function getPantalla()
    {
        return $this->pantalla;
    }

    public function getMemoria()
    {
        return $this->memoria;
    }

    public function cleanPantalla()
    {
        $this->pantalla = "";
    }

    public function digit($digit)
    {
        if ($this->pantalla === 0) {
            $this->pantalla = $digit;
        } else {
            $this->pantalla .= $digit;
        }
    }
    public function operator($op)
    {
        switch ($op) {
            case ("+"):
                $this->pantalla = $this->pantalla . "+";
                break;
            case ("-"):
                $this->pantalla = $this->pantalla . "-";
                break;
            case ("*"):
                $this->pantalla = $this->pantalla . "*";
                break;
            case ("/"):
                $this->pantalla = $this->pantalla . "/";
                break;
        }
    }
    public function mrc()
    {
        $this->pantalla = $this->memoria;
        $this->memoria = 0;
    }
    public function mMas()
    {
        try {
            $this->memoria += eval("return $this->pantalla;");
            $this->cleanPantalla();
        } catch (Exception $e) {
            $_SESSION["expresion"] = "Error: " . $e->getMessage();
        }
    }
    public function mMenos()
    {
        try {
            $this->memoria -= eval("return $this->pantalla;");
            $this->cleanPantalla();
        } catch (Exception $e) {
            $_SESSION["expresion"] = "Error: " . $e->getMessage();
        }
    }

    public function equals()
    {
        try {
            $this->pantalla = eval("return $this->pantalla;");
            $this->memoria = 0;
        } catch (Exception $e) {
            $_SESSION["expresion"] = "Error: " . $e->getMessage();
        }
    }
}

if (!isset($_SESSION["calculadora"])) {
    $_SESSION["calculadora"] = new CalculadoraBasica();
    $_SESSION["expresion"] = "";
}
$calc = $_SESSION["calculadora"];

if (count($_POST) > 0) {
    if (isset($_POST["0"])) $calc->digit("0");
    if (isset($_POST["1"])) $calc->digit("1");
    if (isset($_POST["2"])) $calc->digit("2");
    if (isset($_POST["3"])) $calc->digit("3");
    if (isset($_POST["4"])) $calc->digit("4");
    if (isset($_POST["5"])) $calc->digit("5");
    if (isset($_POST["6"])) $calc->digit("6");
    if (isset($_POST["7"])) $calc->digit("7");
    if (isset($_POST["8"])) $calc->digit("8");
    if (isset($_POST["9"])) $calc->digit("9");
    if (isset($_POST["punto"])) $calc->digit(".");
    if (isset($_POST["mrc"])) $calc->operator("mrc");
    if (isset($_POST["m+"])) $calc->operator("m+");
    if (isset($_POST["m-"])) $calc->operator("m-");
    if (isset($_POST["/"])) $calc->operator("/");
    if (isset($_POST["*"])) $calc->operator("*");
    if (isset($_POST["+"])) $calc->operator("+");
    if (isset($_POST["-"])) $calc->operator("-");
    if (isset($_POST["C"])) $calc->cleanPantalla();
    if (isset($_POST["="])) $calc->equals();


    $_SESSION["expresion"] = $calc->getPantalla();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CalculadoraBasica</title>
    <meta content="Elena Díaz Gutiérrez -UO258525" name="author">
    <meta content="width=device-width,user-scalable=yes" name="viewport">
    <link href="CalculadoraBasica.css" rel="stylesheet">
</head>

<body>
    <h1>Calculadora básica</h1>
    <main class="calculator" id="calculator">
        <form method='post' action='#'>
            <!--<input class="pantalla" id="pantalla" title="Pantalla" readonly disabled/>-->
            <p>
                <?php echo ("<input type='text' class'pantalla' id='pantalla' value='" . $calc->getPantalla() . "' disabled />");?>
            </p>
            <input type="submit" class="darkGrey" id="mrc" name="mrc" value="mrc"/>
            <input type="submit" class="darkGrey" id="mMenos" name="m-" value="m-" />
            <input type="submit" class="darkGrey" id="mMas" name="m+" value="m+"/>
            <input type="submit" class="red" id="div" name="/" value="/" />
            <input type="submit" class="numb" id="7" name="7" value="7" />
            <input type="submit" class="numb" id="8" name="8" value="8">
            <input type="submit" class="numb" id="9" name="9" value="9"/>
            <input type="submit" class="red" id="mul" name="*" value="*" />
            <input type="submit" class="numb" id="4" name="4" value="4" />
            <input type="submit" class="numb" id="5" name="5" value="5" />
            <input type="submit" class="numb" id="6" name="6" value="6" />
            <input type="submit" class="red" id="minus" name="-" value="-" />
            <input type="submit" class="numb" id="1" name="1" value="1" />
            <input type="submit" class="numb" id="2" name="2" value="2" />
            <input type="submit" class="numb" id="3" name="3" value="3" />
            <input type="submit" class="red" id="add" name="+" value="+"/>
            <input type="submit" class="numb" id="0" name="0" value="0"/>
            <input type="submit" class="punto" id="punto" name="punto" value="." />
            <input type="submit" class="C" id="C" name="C" value="C" />
            <input type="submit" class="equals" id="equals" name="=" value="=" />
        </form>
    </main>
</body>

</html>