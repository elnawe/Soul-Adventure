<?php
$template = <<<THEVERYENDOFYOU
<form action="usuarios.php?do=verificar" method="post">
<table width="80%">
<tr><td colspan="2">Debe seguir estos pasos para verificar el registro de su personaje.<br>Primero ingrese su usuario y su e-mail. El c�digo de verificaci�n le llegar� en un e-mail, despu�s ingresel� y estar� listo para jugar.</td></tr>
<tr><td width="20%">Usuario:</td><td><input type="text" name="usuario" size="30" maxlength="30" /></td></tr>
<tr><td>E-mail:</td><td><input type="text" name="email" size="30" maxlength="100" /></td></tr>
<tr><td>C�digo de Verificaci�n:</td><td><input type="text" name="verify" size="10" maxlength="8" /><br /><br /><br /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="�Verificar y Jugar!" /> <input type="reset" name="reset" value="Cancelar" /></td></tr>
</table>
</form>
THEVERYENDOFYOU;
?>