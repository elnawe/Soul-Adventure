<?php
global $controlrow;
    $class1name = $controlrow["class1name"];
    $class2name = $controlrow["class2name"];
    $class3name = $controlrow["class3name"];
$template = "<b><u>Editar Niveles</u></b><br /><br />
El valor de la experiencia es lo que va a permitir a los usuarios definir cual es la experiencia para pasar de nivel por cada raza. Los otros datos es lo que aumentarán por cada nivel.<br /><br />
<form action='update.php?opcion=editarnivel' method='post'>
<input type='hidden' name='level' value='$id' />
<table width='90%'>
<tr><td width='20%'>Nivel que estas editando:</td><td><input type='text' name='id' value={{id}}></td></tr>

<tr><td colspan='2' style='background-color:#cccccc;' align='center'><b>$class1name</b></td></tr>

<tr><td width='20%'>$class1name Experiencia:</td><td><input type='text' name='one_exp' size='10' maxlength='8' value='{{1_exp}}' /></td></tr>
<tr><td width='20%'>$class1name PV:</td><td><input type='text' name='one_hp' size='5' maxlength='5' value='{{1_hp}}' /></td></tr>
<tr><td width='20%'>$class1name PM:</td><td><input type='text' name='one_mp' size='5' maxlength='5' value='{{1_mp}}' /></td></tr>
<tr><td width='20%'>$class1name PR:</td><td><input type='text' name='one_tp' size='5' maxlength='5' value='{{1_tp}}' /></td></tr>
<tr><td width='20%'>$class1name Fuerza:</td><td><input type='text' name='one_strength' size='5' maxlength='5' value='{{1_strength}}' /></td></tr>
<tr><td width='20%'>$class1name Destreza:</td><td><input type='text' name='one_dexterity' size='5' maxlength='5' value='{{1_dexterity}}' /></td></tr>
<tr><td width='20%'>$class1name Habilidades:</td><td><input type='text' name='one_spells' size='5' maxlength='3' value='{{1_spells}}' /></td></tr>

<tr><td colspan='2' style='background-color:#cccccc;' align='center'><b>$class2name</b></td></tr>

<tr><td width='20%'>$class2name Experiencia:</td><td><input type='text' name='two_exp' size='10' maxlength='8' value='{{2_exp}}' /></td></tr>
<tr><td width='20%'>$class2name PV:</td><td><input type='text' name='two_hp' size='5' maxlength='5' value='{{2_hp}}' /></td></tr>
<tr><td width='20%'>$class2name PM:</td><td><input type='text' name='two_mp' size='5' maxlength='5' value='{{2_mp}}' /></td></tr>
<tr><td width='20%'>$class2name PR:</td><td><input type='text' name='two_tp' size='5' maxlength='5' value='{{2_tp}}' /></td></tr>
<tr><td width='20%'>$class2name Fuerza:</td><td><input type='text' name='two_strength' size='5' maxlength='5' value='{{2_strength}}' /></td></tr>
<tr><td width='20%'>$class2name Destreza:</td><td><input type='text' name='two_dexterity' size='5' maxlength='5' value='{{2_dexterity}}' /></td></tr>
<tr><td width='20%'>$class2name Habilidades:</td><td><input type='text' name='two_spells' size='5' maxlength='3' value='{{2_spells}}' /></td></tr>

<tr><td colspan='2' style='background-color:#cccccc;' align='center'><b>$class3name</b></td></tr>

<tr><td width='20%'>$class3name Experiencia:</td><td><input type='text' name='three_exp' size='10' maxlength='8' value='{{3_exp}}' /></td></tr>
<tr><td width='20%'>$class3name PV:</td><td><input type='text' name='three_hp' size='5' maxlength='5' value='{{3_hp}}' /></td></tr>
<tr><td width='20%'>$class3name PM:</td><td><input type='text' name='three_mp' size='5' maxlength='5' value='{{3_mp}}' /></td></tr>
<tr><td width='20%'>$class3name PR:</td><td><input type='text' name='three_tp' size='5' maxlength='5' value='{{3_tp}}' /></td></tr>
<tr><td width='20%'>$class3name Fuerza:</td><td><input type='text' name='three_strength' size='5' maxlength='5' value='{{3_strength}}' /></td></tr>
<tr><td width='20%'>$class3name Destreza:</td><td><input type='text' name='three_dexterity' size='5' maxlength='5' value='{{3_dexterity}}' /></td></tr>
<tr><td width='20%'>$class3name Habilidades:</td><td><input type='text' name='three_spells' size='5' maxlength='3' value='{{3_spells}}' /></td></tr>
</table>
<input type='submit' name='submit' value='Guardar' /> <input type='reset' name='reset' value='Cancelar' />
</form>";

?>