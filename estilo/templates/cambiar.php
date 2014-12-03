<?php
$template = <<<THEVERYENDOFYOU
<div class='titulo'>Cambiar contrase&ntilde;a</div>
<div class='contenido2'>
<form action="index.php?do=cambiar" method="post">
<table width="100%">
<tr><td colspan="2">Si quiere cambiar su contraseña deberá seleccionar una nueva contraseña de 10 caracteres o menos.</td></tr>
<tr><td width="20%">Usuario:</td><td><input type="text" name="usuario" size="30" maxlength="30" /></td></tr>
<tr><td>Contraseña Vieja:</td><td><input type="password" name="oldpass" size="20" /></td></tr>
<tr><td>Contraseña Nueva:</td><td><input type="password" name="newpass1" size="20" maxlength="10" /></td></tr>
<tr><td>Verificar Contraseña Nueva:</td><td><input type="password" name="newpass2" size="20" maxlength="10" /><br /><br /><br /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Cambiar Contraseña" /> <input type="reset" name="reset" value="Cancelar" /></td></tr>
<tr><td>
<a href='index.php'>Volver</a>
</td></tr>
</table>
</form>
</div>
THEVERYENDOFYOU;
?>