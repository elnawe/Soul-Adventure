<?php
$template = <<<THEVERYENDOFYOU
<div class='titulo'>Recuperar contrase&ntilde;a</div>
<div class='contenido2'>
<form action="usuarios.php?do=recuperar" method="post">
<table width="80%">
<tr><td colspan="2">Bienvenido al sistema de Recuperación de Contraseña. Usted debe ingresar su dirección de e-mail (con la cual registró su personaje) para que se le envie una nueva.</td></tr>
<tr><td width="20%">E-mail:</td><td><input type="text" name="email" size="30" maxlength="100" /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Recuperar Contraseña" /> <input type="reset" name="reset" value="Cancelar" /></td></tr>
</table>
</form>
</div>
THEVERYENDOFYOU;
?>