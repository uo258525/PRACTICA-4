<?php

session_start();
class CalculadoraBasica
{
    protected $memoria;
    protected $pantalla;

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

    public function button($button)
    {
        if ($this->pantalla === 0) {
            $this->pantalla = $button;
        } else {
            $this->pantalla .= $button;
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
class CalculadoraCientifica extends CalculadoraBasica
{
    public function factorial()
    {
        $this->pantalla = "". $this->_factorial(eval($this->pantalla));
    }
    public function _factorial(float $n) : float
    {
        if ($n == 0)
            return 1;

        return $n * $this->_factorial($n-1);
    }

    public function functions($op)
    {
        switch ($this->$op) {


            case ("log"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = log10($resultado);
                break;
            case ("exp"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = exp($resultado);
                break;
            case ("x2"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = pow($resultado, 2);
                break;
            case ("10x"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = pow(10, $resultado);
                break;
            case ("sqrt"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = sqrt($resultado);
                break;
            case ("sin"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = sin($resultado);
                break;
            case ("cos"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = cos($resultado);
                break;
            case ("tan"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = tan($resultado);
                break;
            case ("arcsin"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = asin($resultado);
                break;
            case ("arcos"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = acos($resultado);
                break;
            case ("arctan"):
                $resultado = eval("return $this->pantalla;");
                $this->pantalla = atan($resultado);
                break;
            
        }
    }
}
if (!isset($_SESSION["calculadora"])) {
    $_SESSION["calculadora"] = new CalculadoraCientifica();
    $_SESSION["expresion"] = "";
}
$_SESSION["calculadora"] = new CalculadoraCientifica();
$calc = $_SESSION["calculadora"];

if (count($_POST) > 0) {
    if (isset($_POST["0"])) $calc->button("0");
    if (isset($_POST["1"])) $calc->button("1");
    if (isset($_POST["2"])) $calc->button("2");
    if (isset($_POST["3"])) $calc->button("3");
    if (isset($_POST["4"])) $calc->button("4");
    if (isset($_POST["5"])) $calc->button("5");
    if (isset($_POST["6"])) $calc->button("6");
    if (isset($_POST["7"])) $calc->button("7");
    if (isset($_POST["8"])) $calc->button("8");
    if (isset($_POST["9"])) $calc->button("9");
    if (isset($_POST["punto"])) $calc->button(".");
    if (isset($_POST["mrc"])) $calc->operator("mrc");
    if (isset($_POST["m+"])) $calc->operator("m+");
    if (isset($_POST["m-"])) $calc->operator("m-");
    if (isset($_POST["/"])) $calc->operator("/");
    if (isset($_POST["*"])) $calc->operator("*");
    if (isset($_POST["+"])) $calc->operator("+");
    if (isset($_POST["-"])) $calc->operator("-");
    if (isset($_POST["C"])) $calc->cleanPantalla();
    if (isset($_POST["="])) $calc->equals();
    if (isset($_POST["PI"])) $calc->button(pi());
    if (isset($_POST["sin"])) $calc->functions("sin");
    if (isset($_POST["cos"])) $calc->functions("cos");
    if (isset($_POST["tan"])) $calc->functions("tan");
    if (isset($_POST["arcsin"])) $calc->functions("arcsin");
    if (isset($_POST["arcos"])) $calc->functions("arcos");
    if (isset($_POST["arctan"])) $calc->functions("arctan");
    if (isset($_POST["x2"])) $calc->functions("x2");
    if (isset($_POST["10x"])) $calc->functions("10x");
    if (isset($_POST["fact"])) $calc->factorial();
    if (isset($_POST["exp"])) $calc->functions("e");
    if (isset($_POST["log"])) $calc->functions("log");
    if (isset($_POST["sqrt"])) $calc->functions("sqrt");
    if (isset($_POST["mod"])) $calc->button("%");
    if (isset($_POST["("])) $calc->button("(");
    if (isset($_POST[")"])) $calc->button(")");


    $_SESSION["expresion"] = $calc->getPantalla();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CalculadoraCientifica</title>
    <meta content="Elena Díaz Gutiérrez -UO258525" name="author">
    <meta content="width=device-width,user-scalable=yes" name="viewport">
    <link href="CalculadoraCientifica.css" rel="stylesheet">
</head>

<body>
    <h1>Calculadora científica</h1>
    <main class="calculator" id="calculator">
        <form method='post' action='#'>
            <!--<input class="pantalla" id="pantalla" title="Pantalla" readonly disabled/>-->
            <p>
                <?php echo ("<input type='text' class'pantalla' id='pantalla' value='" . $calc->getPantalla() . "' disabled />"); ?>
            </p>
            <input type="submit" class="darkGrey" id="mrc" name="mrc" value="mrc" />
            <input type="submit" class="darkGrey" id="mMenos" name="m-" value="m-" />
            <input type="submit" class="darkGrey" id="mMas" name="m+" value="m+" />
            <input type="submit" class="op" id="x2"  name="x2" value="x^2"/>

            <input type="submit" class="op"  id="mrc" name="mrc" value="mrc"/>
            <input type="submit" class="op"  id="sin" name="sin" value="sin"/>
            <input type="submit" class="op"  id="cos" name="cos" value="cos"/>
            <input type="submit" class="op" id="tan" name="tan" value="tan"/>

            <input type="submit" class="op"  id="arcsin" name="arcsin" value="arcsin"/>
            <input type="submit" class="op"  id="arcos" name="arcos" value="arcos"/>
            <input type="submit" class="op"  id="arctan" name="arctan" value="arctan"/>
            <input type="submit" class="op" id="10x" name="10x" value="10^x"/>
            <input type="submit" class="op" id="fact" name="fact" value="!"/>

            <input type="submit" lass="op" id="sqrt" name="sqrt" value="sqrt" />
            <input type="submit" lass="op" id="log" name="log" value="log">
            <input type="submit" class="op" id="exp" name="exp" value="exp">
            <input type="submit" class="op" id="mod" name="mod" value="mod"/>
            <input type="submit" class="red" id="div" name="/" value="/" />
            <input type="submit" class="numb" id="7" name="7" value="7" />
            <input type="submit" class="numb" id="8" name="8" value="8">
            <input type="submit" class="numb" id="9" name="9" value="9" />
            <input type="submit" class="red" id="mul" name="*" value="*" />
            <input type="submit" class="numb" id="4" name="4" value="4" />
            <input type="submit" class="numb" id="5" name="5" value="5" />
            <input type="submit" class="numb" id="6" name="6" value="6" />
            <input type="submit" class="red" id="minus" name="-" value="-" />
            <input type="submit" class="numb" id="1" name="1" value="1" />
            <input type="submit" class="numb" id="2" name="2" value="2" />
            <input type="submit" class="numb" id="3" name="3" value="3" />
            <input type="submit" class="red" id="add" name="+" value="+" />
            <input type="submit" class="numb" id="0" name="0" value="0" />
            <input type="submit" class="punto" id="punto" name="punto" value="." />
            <input type="submit" class="C" id="C" name="C" value="C" />
            <input type="submit" class="equals" id="equals" name="=" value="=" />
        </form>
    </main>
</body>

</html>