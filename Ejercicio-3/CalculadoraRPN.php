<?php

session_start();
class Stack
{
    protected $pila;
    protected $limit;

    public function __construct($values = array(), $limit = 100)
    {
        $this->pila = array_reverse($values);
        $this->limit = $limit;
    }

    public function push($i)
    {
        if (count($this->pila) < $this->limit) {
            array_unshift($this->pila, $i);
        } else {
            throw new RunTimeException('La pila está llena!');
        }
    }

    public function pop()
    {
        if ($this->isEmpty()) {
            throw new RunTimeException('La pila está vacía!');
        } else {
            return array_shift($this->pila);
        }
    }

    public function top()
    {
        return current($this->pila);
    }

    public function isEmpty()
    {
        return empty($this->pila);
    }
}

class CalculadoraRPN
{
    protected $display;
    protected $stackRPN;
    private $borrar;

    public function __construct()
    {
        $this->display = "";
        $this->stackRPN = new Stack();
    }
    public function getPantalla()
    {
        return $this->display;
    }
    public function cleanPantalla()
    {
        $this->display = "";
    }

    public function button($button)
    {
        if ($this->borrar) {
            $this->borrar = false;
            $this->cleanPantalla();
        }
        if ($this->display === 0) {
            $this->display = $button;
        } else {
            $this->display .= $button;
        }
    }
    public function operadorSimple($op)
    {


        $left = floatval($this->stackRPN->pop());
        $right = floatval($this->stackRPN->pop());
        $expr = 'return ' . $left . $op . $right . ';';
        $result = eval($expr);
        $this->stackRPN->push($result);
        $this->display = $result;
        $this->borrar = true;
    }

    public function enter()
    {
        $this->stackRPN->push($this->getPantalla());
        $this->display = "";
    }
    public function math($op)
    {
        $aux = floatval($this->stackRPN->pop());
        $result = 0;
        switch ($op) {


            case ("log"):
                $result = log10($aux);
                break;
            case ("PI"):
                $result = pi();
            case ("exp"):
                $result = exp($aux);
                break;
            case ("x2"):
                $result = pow($aux, 2);
                break;
            case ("10x"):
                $result = pow(10, $aux);
                break;
            case ("sqrt"):
                $result = sqrt($aux);
                break;
            case ("sin"):
                $result = sin($aux);
                break;
            case ("cos"):
                $result = cos($aux);
                break;
            case ("tan"):
                $result = tan($aux);
                break;
        }
        $this->stackRPN->push($result);
        $_SESSION["expresion3"] = $result;
        $this->borrar = true;
    }

    public function borrar()
    {
        session_destroy();
    }
}
if (!isset($_SESSION["calculadoraRPN"])) {
    $_SESSION["calculadoraRPN"] = new CalculadoraRPN();
    $_SESSION["expresion3"] = "";
}
$calc = $_SESSION["calculadoraRPN"];



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

    if (isset($_POST["/"])) $calc->operadorSimple("/");
    if (isset($_POST["*"])) $calc->operadorSimple("*");
    if (isset($_POST["+"])) $calc->operadorSimple("+");
    if (isset($_POST["-"])) $calc->operadorSimple("-");
    if (isset($_POST["PI"])) $calc->Math("PI");
    if (isset($_POST["sin"])) $calc->math("sin");
    if (isset($_POST["cos"])) $calc->math("cos");
    if (isset($_POST["tan"])) $calc->math("tan");
    if (isset($_POST["x^2"])) $calc->math("x^2");
    if (isset($_POST["10^x"])) $calc->math("10^x");
    if (isset($_POST["e"])) $calc->math("e");
    if (isset($_POST["log"])) $calc->math("log");
    if (isset($_POST["sqrt"])) $calc->math("sqrt");
    if (isset($_POST["C"])) $calc->borrar();
    if (isset($_POST["Enter"])) $calc->enter();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CalculadoraRPN</title>
    <meta content="Elena Díaz Gutiérrez -UO258525" name="author">
    <meta content="width=device-width,user-scalable=yes" name="viewport">
    <link href="CalculadoraRPN.css" rel="stylesheet">
</head>

<body>
    <h1>Calculadora RPN</h1>
    <main class="calculator" id="calculator">
        <form method='post'>

            <p>
                <input type='text' class='pantalla' id='pantalla' value="<?php echo $calc->getPantalla() ?>" disabled />
            </p>

            <div>
                <input type="submit" class="op" id="x2" name="x2" value="x^2" />
                <input type="submit" class="op" id="sin" name="sin" value="sin" />
                <input type="submit" class="op" id="cos" name="cos" value="cos" />
                <input type="submit" class="op" id="tan" name="tan" value="tan" />
            </div>
            <div>
                <input type="submit" class="op" id="10x" name="10x" value="10^x" />
                <input type="submit" lass="op" id="sqrt" name="sqrt" value="sqrt" />
                <input type="submit" lass="op" id="log" name="log" value="log">
                <input type="submit" class="op" id="exp" name="exp" value="exp">
            </div>
            <div>
                <input type="submit" class="red" id="div" name="/" value="/" />
                <input type="submit" class="red" id="mul" name="*" value="*" />
                <input type="submit" class="red" id="minus" name="-" value="-" />
                <input type="submit" class="red" id="add" name="+" value="+" />
            </div>
            <div>
                <input type="submit" class="numb" id="7" name="7" value="7" />
                <input type="submit" class="numb" id="8" name="8" value="8">
                <input type="submit" class="numb" id="9" name="9" value="9" />
                <input type="submit" class="numb" id="4" name="4" value="4" />
            </div>
            <div>
                <input type="submit" class="numb" id="5" name="5" value="5" />
                <input type="submit" class="numb" id="6" name="6" value="6" />
                <input type="submit" class="numb" id="1" name="1" value="1" />
                <input type="submit" class="numb" id="2" name="2" value="2" />
            </div>
            <div>
                <input type="submit" class="numb" id="3" name="3" value="3" />
                <input type="submit" class="numb" id="0" name="0" value="0" />
                <input type="submit" class="punto" id="punto" name="punto" value="." />
                <input type="submit" class="C" id="C" name="C" value="C" />
            </div>
            <input type="submit" class="enter" id="enter" name="Enter" value="Enter" />
        </form>
    </main>
</body>

</html>