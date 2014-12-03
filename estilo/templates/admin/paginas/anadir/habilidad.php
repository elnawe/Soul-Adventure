<?php

$template = "
<b><u>Agregar Habilidad</u></b><br /><br />
<form action='administracion.php?opcion=anadirhabilidad' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td>Generado automáticamente</td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='name' size='30' maxlength='30' value='' /></td></tr>
<tr><td width='20%'>PM:</td><td><input type='text' name='mp' size='5' maxlength='10' value='' /><br /><span class='small'>Puntos de Magia requeridos para utilizar la habilidad.</span></td></tr>
<tr><td width='20%'>Atributo:</td><td><input type='text' name='attribute' size='5' maxlength='10' value='' /><br /><span class='small'>Valor númerico del atributo de la habilidad. Se relaciona con el tipo de habilidad.</span></td></tr>
<tr><td width='20%'>Tipo:</td><td><select name='type'><option value='1' >Sanar</option><option value='2' >Daño</option><option value='3' >Sueño</option><option value='4' >Auras de Ataque</option><option value='5' >Auras de Defensa</option></select><br /><span class='small'>- Sanar: Cura a los jugadores por [atributo] PV.<br />- Daño: Ataca a los monstruos por [atributo] puntos de daño.<br />- Sueño: Duerme a los monstruos (La chance del monstruo a despertarse se define entre posibilidades. Estas son [atributo] de 15).<br />- Aura de Ataque: Aumenta el ataque del personaje por [atributo] porciento.<br />- Aura de Defensa: Aumenta la defensa del personaje por [atributo] porciento.</span></td></tr>
</table>
<input type='submit' name='submit' value='Crear' /> <input type='reset' name='reset' value='Cancelar' />
</form>";
?>