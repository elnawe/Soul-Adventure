<?php

$template = "
<b><u>Agregar Item</u></b><br /><br />
<form action='administracion.php?opcion=anadiritem' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td>Generado autom�ticamente</td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='name' size='30' maxlength='30' value='' /></td></tr>
<tr><td width='20%'>Tipo:</td><td><select name='type'>
<option value='1'>Arma</option>
<option value='2'>Armadura</option>
<option value='3'>Escudo</option>
</select></td></tr>

<tr><td width='20%'>Costo:</td><td><input type='text' name='buycost' size='5' maxlength='10' value='' /> oro</td></tr>
<tr><td width='20%'>Atributo:</td><td><input type='text' name='attribute' size='5' maxlength='10' value='' /><br /><span class='small'>Cuantos puntos de poder de ataque o defensa tiene el item.</span></td></tr>
<tr><td width='20%'>Especial:</td><td><input type='text' name='special' size='30' maxlength='50' value='' /><br /><span class='small'>Debe utilizar un c�digo especial o <span class='highlight'>X</span> Para desactivarlo. Editar esta linea puede traer problemas en el juego si se hace mal.</span></td></tr>
</table>
<input type='submit' name='submit' value='Crear' /> <input type='reset' name='reset' value='Cancelar' />
</form>
<b>C�digos especiales:</b><br />
Los c�digos especiales se pueden agregar al item para darla alguna habilidad o atributo. La formula para agregarlo es <span class='highlight'>atributo, valor</span>. <span class='highlight'>Atributo</span> Cambiar� un atribo en la tabla de Usuarios en la base de datos. Puedes usar cualquier atributo que se indica m�s abajo en la lista. <span class='highlight'>Valor</span> Pueden ser positivos o negativos. Por ejemplo si quieres hacer que un arma agregue PV al jugador utilizas: <span class='highlight'>maxhp,50</span>.<br /><br />
C�digos Especiales:<br />
maxhp - Puntos de Vida m�ximos<br />
maxmp - Puntos de Magia m�ximos<br />
maxtp - Puntos de Recorrido m�ximos<br />
goldbonus - Bonus de Oro, en porcentaje<br />
expbonus - Bonus de Experiencia, en porcentaje<br />
strength - Fuerza (Aumenta el Poder de Ataque)<br />
dexterity - Destreza (Aumenta el Poder de Defensa)<br />
attackpower - Poder de Ataque total<br />
defensepower - Poder de Defensa total";
?>