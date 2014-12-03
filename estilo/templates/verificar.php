<?php
$template = <<<THEVERYENDOFYOU
<form action="usuarios.php?do=verificar" method="post">
<table width="80%">
<tr><td colspan="2">Debe seguir estos pasos para verificar el registro de su personaje.<br>Primero ingrese su usuario y su e-mail. El código de verificación le llegará en un e-mail, después ingreseló y estará listo para jugar.</td></tr>
<tr><td width="20%">Usuario:</td><td><input type="text" name="usuario" size="30" maxlength="30" /></td></tr>
<tr><td>E-mail:</td><td><input type="text" name="email" size="30" maxlength="100" /></td></tr>
<tr><td>Código de Verificación:</td><td><input type="text" name="verify" size="10" maxlength="8" /><br /><br /><br /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="¡Verificar y Jugar!" /> <input type="reset" name="reset" value="Cancelar" /></td></tr>
</table>
</form>
THEVERYENDOFYOU;
?>