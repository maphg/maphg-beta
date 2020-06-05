<?php

session_start();
include 'conexion.php';
$conn = new Conexion();
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == "addCart") {//Agrgar items al carrito de compras
        if (isset($_POST['idMaterial']) && isset($_POST['cantidad'])) {
            $idMaterial = trim($_POST['idMaterial']);
            $cantidad = trim($_POST['cantidad']);


            if (empty($_SESSION['cart'])) {//si el carrito esta vacio, se añaden los elementos que vinieron en el POST
                $_SESSION["cart"] = array(array("idMaterial" => $idMaterial, "cantidad" => $cantidad));
            } else {//Si no esta vacio, se agrega un nuevo elemento al carrito.
                $cart = $_SESSION["cart"];
                $existe = false;
                for ($i = 0; $i < count($cart); $i++) {//Buscar si existe el item en el array
                    if ($cart[$i]['idMaterial'] == $idMaterial) {
                        $existe = true;
                        break;
                    }
                }

                if ($existe) {//Si existe es verdadero, buscamos el material y lo actualizamos
                    for ($i = 0; $i < count($cart); $i++) {
                        if ($cart[$i]['idMaterial'] == $idMaterial) {
                            $cart[$i]['cantidad'] += $cantidad;
                            break;
                        }
                    }
                } else {
                    array_push($cart, array("idMaterial" => $idMaterial, "cantidad" => $cantidad));
                }
                $_SESSION["cart"] = $cart;
//                $existeMaterial = false;
//                foreach ($cart as $c) {
//                    if ($c['idMaterial'] == $idMaterial) {
//                        $existeMaterial = true;
//                    }
//                }
//                if ($existeMaterial) {
//                    for ($i = 0; $i <= count($_SESSION["cart"]); $i++) {
//                        $_SESSION["cart"][$i]['cantidad']+=$cantidad;
//                    }
//                } else {
//                    
//                }
            }
            $count = count($_SESSION['cart']);
            echo $count;
//            $carrito = new Carritos();
//            $resp = $carrito->mostrarCarrito();
//            echo json_encode($resp);
        }
    }
    if ($action == "removeCart") {//Elimina elementos del cartito de compras
        if (!empty($_SESSION["cart"])) {
            $cart = $_SESSION["cart"];
            if (count($cart) == 1) { //si solo existe un elemento en el carrito este se destruye
                unset($_SESSION["cart"]);
            } else {//Si hay mas de un elemento
                $newcart = array();
                foreach ($cart as $c) {//Se recorre el carrito en busca del id obtenido, para descartarlo y crear un nuevo carrito con los elementos restantes.
                    if ($c["idMaterial"] != trim($_POST["id"])) {
                        $newcart[] = $c;
                    }
                }
                $_SESSION["cart"] = $newcart;
            }
        }
//        $carrito = new Carritos();
//        $resp = $carrito->mostrarCarrito();
//        echo json_encode($resp);
    }
    if($action == "eliminarCarrito"){
        if(isset($_SESSION['cart'])){
            unset($_SESSION["cart"]);
        }
        
    }
    if ($action == 3) {//mostrar el carrito 
        $carrito = new Carritos();
        $resp = $carrito->mostrarCarrito();
        echo json_encode($resp);
    }
}

Class Carrito {

    public $carrito;
    public $importeTotal;

}

Class Carritos {

    public function mostrarCarrito() {
        setlocale(LC_MONETARY, "en_US");
        $conn = new Conexion();
        $conn->conectar();
        $importeTotal = 0;
        $carrito = new Carrito();
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $idItem = $item['idMaterial'];

                $query = "SELECT * FROM t_subalmacenes_items WHERE id = $idItem";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $descripcion = $dts['descripcion'];
                            $precio = $dts['precio'];
                        }

                        $cantidad = $item['cantidad'];
                        $importe = $precio * $cantidad;
                        $carrito->carrito .= "<div class=\"row\">"
                                . "<div class=\"col-7\">"
                                . "<h1 class=\"fs-10\">$descripcion</h1>"
                                . "</div>"
                                . "<div class=\"col-3 text-center\">"
                                . "<h1 class=\"fs-10\">$cantidad</h1>"
                                . "</div>"
                                . "<div class=\"col-2 text-right\">"
                                . "<button class=\"btn btn-pure bnt-sm btn-danger fs-9\" onclick=\"removeCart($idItem)\"><img class=\"align-top\" src=\"../svg/cerrarn.svg\" width=\"7\"></button>"
                                . "</div>"
                                . "</div>"
                                . "<div class=\"dropdown-divider\"></div>";
                        $importeTotal += $importe;
                        $carrito->importeTotal = money_format("%.2n", $importeTotal);
                    } else {
                        $carrito->carrito .= "<div class=\"row\">"
                                . "<div class=\"col-12\">"
                                . "<h1 class=\"fs-9\">No hay items</h1>"
                                . "</div>"
                                . "</div>";
                        $carrito->importeTotal = money_format("%.2n", 0);
                    }
                } catch (Exception $ex) {
                    $carrito = $ex;
                }
            }
        } else {
            $carrito->carrito .= "<div class=\"row\">"
                    . "<div class=\"col-12\">"
                    . "<h1 class=\"fs-9\">No hay items</h1>"
                    . "</div>"
                    . "</div>";
            $carrito->importeTotal = money_format("%.2n", 0);
        }

        $conn->cerrar();
        return $carrito;
    }

}
?>

