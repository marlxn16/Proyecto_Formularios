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

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Formulario de Ventas</title>
<link rel="stylesheet" href="estilo.css">

<script>
function seleccionarPaquete(paquete){

    let productos = {
        hamburguesa:0, papas:0, refresco:0,
        pizza:0, nuggets:0, ensalada:0,
        yogurth:0, agua:0
    };

    if(paquete == 1){
        productos.hamburguesa = 1;
        productos.papas = 1;
        productos.refresco = 1;
    }
    if(paquete == 2){
        productos.pizza = 1;
        productos.nuggets = 1;
        productos.refresco = 1;
    }
    if(paquete == 3){
        productos.ensalada = 1;
        productos.yogurth = 1;
        productos.agua = 1;
    }

    for(let p in productos){
        document.getElementsByName(p)[0].value = productos[p];
    }
}
</script>
</head>

<body>

<div class="contenedor">
<form method="post">

<div class="fila">

<!-- PAQUETES -->
<fieldset class="caja">
<legend>PAQUETES</legend>

<div class="paquete">
<input type="radio" name="paquete" value="1" onclick="seleccionarPaquete(1)">
Hamburguesa, Papas y Refresco
</div>

<div class="paquete">
<input type="radio" name="paquete" value="2" onclick="seleccionarPaquete(2)">
Pizza, Nuggets y Refresco
</div>

<div class="paquete">
<input type="radio" name="paquete" value="3" onclick="seleccionarPaquete(3)">
Ensalada, Yogurth y Agua
</div>

<div class="paquete">
<input type="radio" name="paquete" value="4" onclick="seleccionarPaquete(4)">
Otras opciones
</div>
</fieldset>

<!-- PEDIDOS -->
<fieldset class="caja pedidos">
<legend>PEDIDOS</legend>

<?php foreach($precios as $producto => $precio): ?>
<div class="pedido">
<input type="number" name="<?= $producto ?>" value="<?= $_POST[$producto] ?? 0 ?>" min="0">
<span><?= ucfirst($producto) ?></span>
<span>$<?= $precio ?></span>
</div>
<?php endforeach; ?>

</fieldset>
</div>

<!-- PAGO -->
<fieldset class="caja pago">
<legend>PAGO</legend>

<div class="pago-col">
<div class="fila-pago">
<label>Sub Total</label>
<input type="text" value="<?= number_format($subtotal,2) ?>" readonly>
</div>

<div class="fila-pago">
<label>IVA 16%</label>
<input type="text" value="<?= number_format($iva,2) ?>" readonly>
</div>
</div>

<div class="pago-col">
<div class="fila-pago">
<label>Total</label>
<input type="text" value="<?= number_format($total,2) ?>" readonly>
</div>

<div class="fila-pago">
<label>Pago</label>
<input type="number" name="pago" value="<?= $pago ?>" step="0.01">
</div>

<div class="fila-pago">
<label>Cambio</label>
<input type="text" value="<?= number_format($cambio,2) ?>" readonly>
</div>

<div style="display:flex; align-items:center; gap:8px;">
<button type="submit" name="pagar">PAGAR</button>

<?php if($errorPago): ?>
<small style="color:red;">Error de pago</small>
<?php endif; ?>
</div>

</div>
</fieldset>

</form>
</div>

</body>
</html>