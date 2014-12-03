<?php
global $controlrow;
	$race1name = $controlrow["race1name"];
	$race2name = $controlrow["race2name"];
	$race3name = $controlrow["race3name"];
	$race4name = $controlrow["race4name"];
	$race5name = $controlrow["race5name"];
	$class1name = $controlrow["class1name"];
    $class2name = $controlrow["class2name"];
    $class3name = $controlrow["class3name"];
$template = "<b><u>Editar Usuario</u></b><br /><br />
<form action='update.php?opcion=editarusuario' method='post'>
<table width='90%'>
<tr><td width='20%'>ID:</td><td><input type='text' name='id' size='30' maxlength='100' value='{{id}}' /></td></tr>
<tr><td width='20%'>Usuario:</td><td>{{usuario}}</td></tr>
<tr><td width='20%'>E-mail:</td><td><input type='text' name='email' size='30' maxlength='100' value='{{email}}' /></td></tr>
<tr><td width='20%'>Verificar:</td><td><input type='text' name='verify' size='30' maxlength='8' value='{{verify}}' /></td></tr>
<tr><td width='20%'>Nombre:</td><td><input type='text' name='charname' size='30' maxlength='30' value='{{charname}}' /></td></tr>
<tr><td width='20%'>Fecha de Registro:</td><td>{{regdate}}</td></tr>
<tr><td width='20%'>Ultima Vez Online:</td><td>{{onlinetime}}</td></tr>
<tr><td width='20%'>Rango:</td>
<td><select name='autorizacion'><option value='0' {{auth0select}}>Usuario</option><option value='1' {{auth1select}}>Administrador</option><option value='1' {{auth1select}}>Moderador</option><option value='2' {{auth2select}}>Baneado</option></select><br /><span class='small'>Elegir bloqueado para banear al usuario.</span></td></tr>

<tr><td colspan='2' style='background-color:#cccccc;' align='center'>Principales</td></tr>

<tr><td width='20%'>Latitud:</td><td><input type='text' name='latitude' size='5' maxlength='6' value='{{latitude}}' /></td></tr>
<tr><td width='20%'>Longitud:</td><td><input type='text' name='longitude' size='5' maxlength='6' value='{{longitude}}' /></td></tr>
<tr><td width='20%'>Dificultad:</td><td><select name='difficulty'><option value='1' {{diff1select}}>Facil</option><option value='2' {{diff2select}}>Medio</option><option value='3' {{diff3select}}>Dificil</option></select></td></tr>

<tr>
	<td width='20%'>Raza:</td>
		<td><select name='charrace'>
			<option value='1' {{race1select}}>$race1name</option>
			<option value='2' {{race2select}}>$race2name</option>
			<option value='3' {{race3select}}>$race3name</option>
			<option value='4' {{race4select}}>$race4name</option>
			<option value='5' {{race5select}}>$race5name</option>
		</select>
	</td>
</tr>

<tr>
	<td width='20%'>Clase:</td>
		<td><select name='charclass'>
			<option value='1' {{class1select}}>$class1name</option>
			<option value='2' {{class2select}}>$class2name</option>
			<option value='3' {{class3select}}>$class3name</option>
		</select>
	</td>
</tr>

<tr><td colspan='2' style='background-color:#cccccc;' align='center'>Actualidad</td></tr>

<tr><td width='20%'>Acción Actual:</td><td><input type='text' name='currentaction' size='30' maxlength='30' value='{{currentaction}}' /></td></tr>
<tr><td width='20%'>Pelea Actual:</td><td><input type='text' name='currentfight' size='5' maxlength='4' value='{{currentfight}}' /></td></tr>
<tr><td width='20%'>Monstruo Actual:</td><td><input type='text' name='currentmonster' size='5' maxlength='6' value='{{currentmonster}}' /></td></tr>
<tr><td width='20%'>PV del Monstruo:</td><td><input type='text' name='currentmonsterhp' size='5' maxlength='6' value='{{currentmonsterhp}}' /></td></tr>
<tr><td width='20%'>Dormir Monstruo:</td><td><input type='text' name='currentmonsterimmune' size='5' maxlength='3' value='{{currentmonsterimmune}}' /></td></tr>
<tr><td width='20%'>Inmunidad del Monstruo:</td><td><input type='text' name='currentmonstersleep' size='5' maxlength='3' value='{{currentmonstersleep}}' /></td></tr>
<tr><td width='20%'>Aura de Ataque:</td><td><input type='text' name='currentuberdamage' size='5' maxlength='3' value='{{currentuberdamage}}' /></td></tr>
<tr><td width='20%'>Aura de Defensa:</td><td><input type='text' name='currentuberdefense' size='5' maxlength='3' value='{{currentuberdefense}}' /></td></tr>

<tr><td colspan='2' style='background-color:#cccccc;' align='center'>Balance de Datos</td></tr>

<tr><td width='20%'>PV:</td><td><input type='text' name='currenthp' size='5' maxlength='6' value='{{currenthp}}' /></td></tr>
<tr><td width='20%'>PM:</td><td><input type='text' name='currentmp' size='5' maxlength='6' value='{{currentmp}}' /></td></tr>
<tr><td width='20%'>PR:</td><td><input type='text' name='currenttp' size='5' maxlength='6' value='{{currenttp}}' /></td></tr>
<tr><td width='20%'>PV Máx:</td><td><input type='text' name='maxhp' size='5' maxlength='6' value='{{maxhp}}' /></td></tr>
<tr><td width='20%'>PM Máx:</td><td><input type='text' name='maxmp' size='5' maxlength='6' value='{{maxmp}}' /></td></tr>
<tr><td width='20%'>PR Máx:</td><td><input type='text' name='maxtp' size='5' maxlength='6' value='{{maxtp}}' /></td></tr>

<tr><td colspan='2' style='background-color:#cccccc;' align='center'>Bonus y Estadísticas</td></tr>

<tr><td width='20%'>Nivel:</td><td><input type='text' name='nivel' size='5' maxlength='5' value='{{nivel}}' /></td></tr>
<tr><td width='20%'>Oro:</td><td><input type='text' name='gold' size='10' maxlength='8' value='{{gold}}' /></td></tr>
<tr><td width='20%'>Banco:</td><td><input type='text' name='banco' size='10' maxlength='8' value='{{banco}}' /></td></tr>
<tr><td width='20%'>Experiencia:</td><td><input type='text' name='experience' size='10' maxlength='8' value='{{experience}}' /></td></tr>
<tr><td width='20%'>Bonus Oro:</td><td><input type='text' name='goldbonus' size='5' maxlength='5' value='{{goldbonus}}' /></td></tr>
<tr><td width='20%'>Bonus EXP:</td><td><input type='text' name='expbonus' size='5' maxlength='5' value='{{expbonus}}' /></td></tr>
<tr><td width='20%'>Fuerza:</td><td><input type='text' name='strength' size='5' maxlength='5' value='{{strength}}' /></td></tr>
<tr><td width='20%'>Destreza:</td><td><input type='text' name='dexterity' size='5' maxlength='5' value='{{dexterity}}' /></td></tr>
<tr><td width='20%'>Poder de Ataque:</td><td><input type='text' name='attackpower' size='5' maxlength='5' value='{{attackpower}}' /></td></tr>
<tr><td width='20%'>Poder de Defensa:</td><td><input type='text' name='defensepower' size='5' maxlength='5' value='{{defensepower}}' /></td></tr>

<tr><td colspan='2' style='background-color:#cccccc;' align='center'>Inventario</td></tr>

<tr><td width='20%'>ID Arma:</td><td><input type='text' name='weaponid' size='5' maxlength='5' value='{{weaponid}}' /></td></tr>
<tr><td width='20%'>ID Armadura:</td><td><input type='text' name='armorid' size='5' maxlength='5' value='{{armorid}}' /></td></tr>
<tr><td width='20%'>Escudo ID:</td><td><input type='text' name='shieldid' size='5' maxlength='5' value='{{shieldid}}' /></td></tr>
<tr><td width='20%'>ID Espacio 1:</td><td><input type='text' name='slot1id' size='5' maxlength='5' value='{{slot1id}}' /></td></tr>
<tr><td width='20%'>ID Espacio 2:</td><td><input type='text' name='slot2id' size='5' maxlength='5' value='{{slot2id}}' /></td></tr>
<tr><td width='20%'>ID Espacio 3:</td><td><input type='text' name='slot3id' size='5' maxlength='5' value='{{slot3id}}' /></td></tr>
<tr><td width='20%'>Nombre Arma:</td><td><input type='text' name='weaponname' size='30' maxlength='30' value='{{weaponname}}' /></td></tr>
<tr><td width='20%'>Nombre Armadura:</td><td><input type='text' name='armorname' size='30' maxlength='30' value='{{armorname}}' /></td></tr>
<tr><td width='20%'>Nombre Escudo:</td><td><input type='text' name='shieldname' size='30' maxlength='30' value='{{shieldname}}' /></td></tr>
<tr><td width='20%'>Nombre Espacio 1:</td><td><input type='text' name='slot1name' size='30' maxlength='30' value='{{slot1name}}' /></td></tr>
<tr><td width='20%'>Nombre Espacio 2:</td><td><input type='text' name='slot2name' size='30' maxlength='30' value='{{slot2name}}' /></td></tr>
<tr><td width='20%'>Nombre Espacio 3:</td><td><input type='text' name='slot3name' size='30' maxlength='30' value='{{slot3name}}' /></td></tr>

<tr><td colspan='2' style='background-color:#cccccc;' align='center'>Habilidades y Úbicación</td></tr>

<tr><td width='20%'>Codigo de Drop:</td><td><input type='text' name='dropcode' size='5' maxlength='8' value='{{dropcode}}' /></td></tr>
<tr><td width='20%'>Habilidades:</td><td><input type='text' name='spells' size='50' maxlength='50' value='{{spells}}' /></td></tr>
<tr><td width='20%'>Ciudades:</td><td><input type='text' name='towns' size='50' maxlength='50' value='{{towns}}' /></td></tr>

</table>
<input type='submit' name='submit' value='Guardar' /> <input type='reset' name='reset' value='Cancelar' />
</form>";
?>