<?php

function hora() {

$diferenciahoraria = "1"; // hours difference between server time and local time
$ajustehora = ($diferenciahoraria * 60 * 60);

$mostrar = date("l, d F Y h:i a",time() + $ajustehora);

print ("$mostrar");

}

?>
