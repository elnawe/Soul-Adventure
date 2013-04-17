<?php

$template = "<b><u>Editar Items</u></b><br /><br />
<form action='update.php?opcion=editaritem' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td><input type='text' name='id' size='1' maxlength='0' value='{{id}}' /></td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='name' size='30' maxlength='30' value='{{name}}' /></td></tr>
<tr><td width='20%'>Tipo:</td><td><select name='type'><option value='1' {{type1select}}>Arma</option><option value='2' {{type2select}}>Armadura</option><option value='3' {{type3select}}>Escudo</option></select></td></tr>
<tr><td width='20%'>Precio:</td><td><input type='text' name='buycost' size='5' maxlength='10' value='{{buycost}}' /> gold</td></tr>
<tr><td width='20%'>Atributo:</td><td><input type='text' name='attribute' size='5' maxlength='10' value='{{attribute}}' /><br /><span class='small'>Poder de Ataque/Defensa del Item.</span></td></tr>
<tr><td width='20%'>Especial:</td><td><input type='text' name='special' size='30' maxlength='50' value='{{special}}' /><br /><span class='small'>Debe utilizar un código especial o <span class='highlight'>X</span> Para desactivarlo. Editar esta linea puede traer problemas en el juego si se hace mal.</span></td></tr>
</table>
<input type='submit' name='submit' value='Guardar' /> <input type='reset' name='reset' value='Cancelar' />
</form>
<b>Códigos especiales:</b><br />
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
