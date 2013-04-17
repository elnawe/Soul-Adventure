<?php

$template = "<b><u>Editar Habilidades</u></b><br /><br />
<form action='update.php?opcion=editarhabilidad' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td><input type='text' name='id' size='30' maxlength='30' value='{{id}}' /></td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='name' size='30' maxlength='30' value='{{name}}' /></td></tr>
<tr><td width='20%'>Puntos de Magia:</td><td><input type='text' name='mp' size='5' maxlength='10' value='{{mp}}' /><br /><span class='small'>PM requeridos para utilizar la habilidad.</span></td></tr>
<tr><td width='20%'>Atributo:</td><td><input type='text' name='attribute' size='5' maxlength='10' value='{{attribute}}' /><br /><span class='small'>Valor númerico para el efecto de la habilidad. Concuerda con el tipo.</span></td></tr>
<tr><td width='20%'>Tipo:</td><td><select name='type'><option value='1' {{type1select}}>Sanar</option><option value='2' {{type2select}}>Daño</option><option value='3' {{type3select}}>Sueño</option><option value='4' {{type4select}}>Auras de Ataque</option><option value='5' {{type5select}}>Auras de Defensa</option></select><br /><span class='small'>- Sanar: Cura a los jugadores por [atributo] PV.<br />- Daño: Ataca a los monstruos por [atributo] puntos de daño.<br />- Sueño: Duerme a los monstruos (La chance del monstruo a despertarse se define entre posibilidades. Estas son [atributo] de 15).<br />- Aura de Ataque: Aumenta el ataque del personaje por [atributo] porciento.<br />- Aura de Defensa: Aumenta la defensa del personaje por [atributo] porciento.</span></td></tr>
</table>
<input type='submit' name='submit' value='Guardar' /> <input type='reset' name='reset' value='Cancelar' />
</form>";
?>
