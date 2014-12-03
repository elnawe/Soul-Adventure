<?php

$template = "
<b><u>Agregar Ciudad</u></b><br /><br />
<form action='administracion.php?opcion=anadirciudad' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td>Generado automáticamente</td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='name' size='30' maxlength='30' value='' /></td></tr>
<tr><td width='20%'>Latitud:</td><td><input type='text' name='latitude' size='5' maxlength='10' value='' /><br /><span class='small'>Puede ser positivo o negativo.</span></td></tr>
<tr><td width='20%'>Longitud:</td><td><input type='text' name='longitude' size='5' maxlength='10' value='' /><br /><span class='small'>Puede ser positivo o negativo.</span></td></tr>
<tr><td width='20%'>Precio de Hotel:</td><td><input type='text' name='innprice' size='5' maxlength='10' value='' /> de oro</td></tr>
<tr><td width='20%'>Precio de Mapa:</td><td><input type='text' name='mapprice' size='5' maxlength='10' value='' /> gold<br /><span class='small'>Cuanto cuesta comprar el mapa de esta ciudad.</span></td></tr>
<tr><td width='20%'>Puntos de Recorrido:</td><td><input type='text' name='travelpoints' size='5' maxlength='10' value='' /><br /><span class='small'>Cuantos PR cuesta viajar a esta ciudad.</span></td></tr>
<tr><td width='20%'>Lista de Item:</td><td><input type='text' name='itemslist' size='30' maxlength='200' value='' /><br /><span class='small'>Items separados por coma (,). Estos son los que se venderán en el negocio. Se debe ingresar el ID del item. (Ejemplo: <span class='highlight'>1,2,3,6,9,10,13,20</span>)</span></td></tr>
</table>
<input type='submit' name='submit' value='Crear' /> <input type='reset' name='reset' value='Cancelar' />
</form>";
?>