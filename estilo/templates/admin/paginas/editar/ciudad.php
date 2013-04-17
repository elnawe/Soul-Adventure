<?php

$template = "<b><u>Editar Ciudades</u></b><br /><br />
<form action='update.php?opcion=editarciudad' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td><input type='text' name='id' size='1' maxlength='0' value='{{id}}' /></td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='name' size='30' maxlength='30' value='{{name}}' /></td></tr>
<tr><td width='20%'>Latitud:</td><td><input type='text' name='latitude' size='5' maxlength='10' value='{{latitude}}' /><br /><span class='small'>Número entero positivo o negativo.</span></td></tr>
<tr><td width='20%'>Longitud:</td><td><input type='text' name='longitude' size='5' maxlength='10' value='{{longitude}}' /><br /><span class='small'>Número entero positivo o negativo.</span></td></tr>
<tr><td width='20%'>Precio de Hotel:</td><td><input type='text' name='innprice' size='5' maxlength='10' value='{{innprice}}' /> de oro</td></tr>
<tr><td width='20%'>Precio del Mapa:</td><td><input type='text' name='mapprice' size='5' maxlength='10' value='{{mapprice}}' /> de oro<br /><span class='small'>Define cuanto cuesta comprar el mapa.</span></td></tr>
<tr><td width='20%'>Puntos de Recorrido:</td><td><input type='text' name='travelpoints' size='5' maxlength='10' value='{{travelpoints}}' /><br /><span class='small'>Define cuantos PR nos cuesta viajar a esta ciudad.</span></td></tr>
<tr><td width='20%'>Lista de Items:</td><td><input type='text' name='itemslist' size='30' maxlength='200' value='{{itemslist}}' /><br /><span class='small'>Lista de items separadas por coma (,). Los items se deben definir por su ID. (Ejemplo: <span class='highlight'>1,2,3,6,9,10,13,20</span>)</span></td></tr>
</table>
<input type='submit' name='submit' value='Guardar' /> <input type='reset' name='reset' value='Cancelar' />
</form>";
?>
