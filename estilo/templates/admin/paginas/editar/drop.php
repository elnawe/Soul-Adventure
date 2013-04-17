<?php

$template = "<b><u>Edit Drops</u></b><br /><br />
<form action='update.php?opcion=editardrop' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td><input type='text' name='id' size='0' maxlength='0' value='{{id}}' /></td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='name' size='30' maxlength='30' value='{{name}}' /></td></tr>
<tr><td width='20%'>Nivel del monstro:</td><td><input type='text' name='mnivel' size='5' maxlength='10' value='{{mnivel}}' /><br /><span class='small'>Nivel minimo del monstruo quien dejará el item.</span></td></tr>
<tr><td width='20%'>Atributo 1:</td><td><input type='text' name='attribute1' size='30' maxlength='50' value='{{attribute1}}' /><br /><span class='small'>Debe ser el código especial. El primer atributo no puede estar deshabilitado. Al editar este campo se debe tener en cuenta que puede crear problemas en el juego.</span></td></tr>
<tr><td width='20%'>Atributo 2:</td><td><input type='text' name='attribute2' size='30' maxlength='50' value='{{attribute2}}' /><br /><span class='small'>Puede ser un código especial o <span class='highlight'>X</span> para deshabilitarlo. Al editar este campo se debe tener en cuenta que puede crear problemas en el juego.</span></td></tr>
</table>
<input type='submit' name='submit' value='Guardar' /> <input type='reset' name='reset' value='Cancelar' />
</form>
<b>Códigos Especiales:</b><br />
Los códigos especiales se pueden agregar al item para darla alguna habilidad o atributo. La formula para agregarlo es <span class='highlight'>atributo, valor</span>. <span class='highlight'>Atributo</span> Cambiará un atribo en la tabla de Usuarios en la base de datos. Puedes usar cualquier atributo que se indica más abajo en la lista. <span class='highlight'>Valor</span> Pueden ser positivos o negativos. Por ejemplo si quieres hacer que un arma agregue PV al jugador utilizas: <span class='highlight'>maxhp,50</span>.<br /><br />
Códigos Especiales:<br />
maxhp - Puntos de Vida máximos<br />
maxmp - Puntos de Magia máximos<br />
maxtp - Puntos de Recorrido máximos<br />
goldbonus - Bonus de Oro, en porcentaje<br />
expbonus - Bonus de Experiencia, en porcentaje<br />
strength - Fuerza (Aumenta el Poder de Ataque)<br />
dexterity - Destreza (Aumenta el Poder de Defensa)<br />
attackpower - Poder de Ataque total<br />
defensepower - Poder de Defensa total";
?>
