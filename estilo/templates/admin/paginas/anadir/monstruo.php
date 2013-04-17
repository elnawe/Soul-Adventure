<?php

$template = "
<b><u>Agregar Monstruo</u></b><br /><br />
<form action='administracion.php?opcion=anadirmonstruo' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td>Generado automáticamente</td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='name' size='30' maxlength='30' value='' /></td></tr>
<tr><td width='20%'>PV Máx:</td><td><input type='text' name='maxhp' size='5' maxlength='10' value='' /></td></tr>
<tr><td width='20%'>Daño Máx:</td><td><input type='text' name='maxdam' size='5' maxlength='10' value='' /><br /><span class='small'>Comparado con el poder de ataque del jugador.</span></td></tr>
<tr><td width='20%'>Armadura:</td><td><input type='text' name='armor' size='5' maxlength='10' value='' /><br /><span class='small'>Comparado con el poder de defensa del jugador.</span></td></tr>
<tr><td width='20%'>Nivel:</td><td><input type='text' name='nivel' size='5' maxlength='10' value='' /><br /><span class='small'>Determina donde aparece y que dropea.</span></td></tr>
<tr><td width='20%'>Experiencia Máx:</td><td><input type='text' name='maxexp' size='5' maxlength='10' value='' /><br /><span class='small'>Experiencia máxima ganada por el monstruo.</span></td></tr>
<tr><td width='20%'>Oro Máx:</td><td><input type='text' name='maxgold' size='5' maxlength='10' value='' /><br /><span class='small'>Oro máximo ganado por el monstruo.</span></td></tr>
<tr><td width='20%'>Inmunidad:</td><td><select name='immune'><option value='0'>Nada</option><option value='1' >Daño</option><option value='2'>Daño y Sueño</option></select><br /><span class='small'>Algunas monstruos pueden ser inmunes a algunos ataques.</span></td></tr>
</table>
<input type='submit' name='submit' value='Crear' /> <input type='reset' name='reset' value='Cancelar' />
</form>";
?>