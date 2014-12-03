<?php

$template = "<b><u>Editar Monstruos</u></b><br /><br />
<form action='update.php?opcion=editarmonstruo' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td><input type='text' name='id' size='30' maxlength='30' value='{{id}}' /></td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='name' size='30' maxlength='30' value='{{name}}' /></td></tr>
<tr><td width='20%'>PV Máx:</td><td><input type='text' name='maxhp' size='5' maxlength='10' value='{{maxhp}}' /></td></tr>
<tr><td width='20%'>Daño Máx:</td><td><input type='text' name='maxdam' size='5' maxlength='10' value='{{maxdam}}' /><br /><span class='small'>Comparado con el poder de ataque del personaje.</span></td></tr>
<tr><td width='20%'>Armadura:</td><td><input type='text' name='armor' size='5' maxlength='10' value='{{armor}}' /><br /><span class='small'>Comparado con el poder de defensa del personaje.</span></td></tr>
<tr><td width='20%'>Nivel del Monstruo:</td><td><input type='text' name='nivel' size='5' maxlength='10' value='{{nivel}}' /><br /><span class='small'>Determina donde aparece y que item deja caer.</span></td></tr>
<tr><td width='20%'>Exp Máx:</td><td><input type='text' name='maxexp' size='5' maxlength='10' value='{{maxexp}}' /><br /><span class='small'>Máxima experiencia ganada al derrotar al monstruo.</span></td></tr>
<tr><td width='20%'>Oro Máx:</td><td><input type='text' name='maxgold' size='5' maxlength='10' value='{{maxgold}}' /><br /><span class='small'>Máximo de Oro ganado al derrotar al monstruo.</span></td></tr>
<tr><td width='20%'>Inmunidad:</td><td><select name='immune'><option value='0' {{immune0select}}>Nada</option><option value='1' {{immune1select}}>Habilidades de Daño</option><option value='2' {{immune2select}}>Habilidades de Daño y Sueño</option></select><br /><span class='small'>Algunos monstruos no pueden ser atacados por ciertas habilidades.</span></td></tr>
</table>
<input type='submit' name='submit' value='Guardar' /> <input type='reset' name='reset' value='Cancelar' />
</form>";
?>
