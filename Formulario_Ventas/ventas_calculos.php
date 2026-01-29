<?php
$subtotal = 0;
$iva = 0;
$total = 0;
$cambio = 0;
$pago = 0;
$errorPago = false;

$precios = [
    "hamburguesa"=>35,
    "papas"=>15,
    "refresco"=>12,
    "pizza"=>70,
    "nuggets"=>25,
    "ensalada"=>30,
    "yogurth"=>15,
    "agua"=>12
];

if(isset($_POST['pagar'])){

    foreach($precios as $producto => $precio){
        $cantidad = intval($_POST[$producto] ?? 0);
        $subtotal += $cantidad * $precio;
    }

    $iva = $subtotal * 0.16;
    $total = $subtotal + $iva;
    $pago = floatval($_POST['pago'] ?? 0);

    if($pago > 0){
        if($pago < $total){
            $errorPago = true;
            $cambio = 0;
        } else {
            $cambio = $pago - $total;
        }
    }
}
?>
