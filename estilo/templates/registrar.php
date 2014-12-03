<?php
$template = <<<THEVERYENDOFYOU
<div class='titulo'>Registro</div>
<div class='contenido2'>
<form action="usuarios.php?do=registrar" method="post">
<table width="80%">
<tr><td width="20%">Usuario:</td><td><input type="text" name="usuario" size="30" maxlength="30" /><br />Los nombres de usuarios deben tener como máximo 30 caracteres.<br />Atención: El nombre de usuario le va a servir para entrar al juego, pero no será tomado como nombre del personaje.<br /><br /></td></tr>
<tr><td>Contraseña:</td><td><input type="password" name="password1" size="30" maxlength="10" /></td></tr>
<tr><td>Verificar Contraseña:</td><td><input type="password" name="password2" size="30" maxlength="10" /><br />Las contraseñas deben tener un máximo de 10 caracteres.<br />Atención: Las dos contraseñas deben ser iguales.<br /><br /></td></tr>
<tr><td>E-mail:</td><td><input type="text" name="email1" size="30" maxlength="100" /></td></tr>
<tr><td>Verificar E-mail:</td><td><input type="text" name="email2" size="30" maxlength="100" />{{verifytext}}<br /><br /><br /></td></tr>
<tr><td>Nombre del Personaje:</td><td><input type="text" name="charname" size="30" maxlength="30" /><br />Atención: El nombre no debe tener caracteres raros, no debe ser ofensivo hacia nadie y puede tener un máximo de 30 caracteres.</td></tr>
<tr><td>Raza:</td><td><select name="charrace"><option value="1">Humano</option><option value="2">Elfo</option><option value="3">Enano</option><option value="4">Mediano</option><option value="5">Orco</option></select></td></tr>
<tr><td>Clase:</td><td><select name="charclass"><option value="1">{{class1name}}</option><option value="2">{{class2name}}</option><option value="3">{{class3name}}</option></select><br />La clase de su personaje definirá sus habilidades.</td></tr>
<tr><td>Dificultad:</td><td><select name="difficulty"><option value="1">{{diff1name}}</option><option value="2">{{diff2name}}</option><option value="3">{{diff3name}}</option></select><br />Según la dificultad que elija, recibirá más oro y experiencia al matar un bicho, pero al mismo tiempo, este va a ser más dificil de matar.</td></tr>
<tr><td colspan="2">Consulta nuestra <a href="ayuda.php">Ayuda</a> para más información.<br /><br /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="¡Registrarme y Jugar!" /> <input type="reset" name="reset" value="Cancelar" /></td></tr>
</table>
</form>
</div>
THEVERYENDOFYOU;
?>