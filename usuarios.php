<?php 
#############################################################################
# *                                                          				#
# * SOUL ADVENTURE	                                         				#
# *                                                        					#
# * Este proyecto esta bajo una licencia Creative Commons   				#
# * Reconocimiento - NoComercial - CompartirIgual (by-nc-sa):				#
# * No se permite un uso comercial de la obra original ni de las posibles	#
# * obras derivadas, la distribución de las cuales se debe hacer con una	#
# * licencia igual a la que regula la obra original.   						#
# * 																		#
# * Este proyecto toma como base los scripts de:							#
# *  -Jamin Seven (Dragon Knight)											#
# *  -Adam Dear (Dragon Kingdom)											#
# *  -Nawe(Soul Adventure)-abandono por falta de tiempo				        #
# * Actualmente siguen su desarrollo Ethernity y Skinet						#
# * Para más información: www.soul-adventure.net							#
# *                                                          				#
#############################################################################
include('lib.php');
$link = opendb();

if (isset($_GET["do"])) {
    
    $do = $_GET["do"];
    if ($do == "registrar") { register(); }
    elseif ($do == "verificar") { verify(); }
    elseif ($do == "recuperar") { lostpassword(); }
    
}

function register() { // Registrar.
    
    $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
    $controlrow = mysql_fetch_array($controlquery);
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        
        $errors = 0; $errorlist = "";
        
        // Procesar nombre de usuario.
        if ($usuario== "") { $errors++; $errorlist .= "Usuario es requerido.<br />"; }
        if (preg_match("/[^A-z0-9_\-]/", $username)==1) { $errors++; $errorlist .= "Usuario debe ser Alfanumérico.<br />"; }
        $usernamequery = doquery("SELECT usuario FROM {{table}} WHERE usuario='$usuario' LIMIT 1","usuarios");
        if (mysql_num_rows($usernamequery) > 0) { $errors++; $errorlist .= "Usuario ya utilizado.<br />"; }
        
        // Procesar nombre de personaje.
        if ($charname == "") { $errors++; $errorlist .= "Nombre de Personaje requerido.<br />"; }
        if (preg_match("/[^A-z0-9_\-]/", $charname)==1) { $errors++; $errorlist .= "El nombre del Personaje debe ser Alfanumérico.<br />"; }
        $characternamequery = doquery("SELECT charname FROM {{table}} WHERE charname='$charname' LIMIT 1","usuarios");
        if (mysql_num_rows($characternamequery) > 0) { $errors++; $errorlist .= "El nombre del Personaje ya está siendo usado.<br />"; }
    
        // Procesar email.
        if ($email1 == "" || $email2 == "") { $errors++; $errorlist .= "El e-mail es requerido.<br />"; }
        if ($email1 != $email2) { $errors++; $errorlist .= "Los e-mails no concuerdan.<br />"; }
        if (! is_email($email1)) { $errors++; $errorlist .= "E-mail no válido.<br />"; }
        $emailquery = doquery("SELECT email FROM {{table}} WHERE email='$email1' LIMIT 1","usuarios");
        if (mysql_num_rows($emailquery) > 0) { $errors++; $errorlist .= "E-mail ya utilizado.<br />"; }
        
        // Procesar Contraseña.
        if (trim($password1) == "") { $errors++; $errorlist .= "La contraseña es requerida.<br />"; }
        if (preg_match("/[^A-z0-9_\-]/", $password1)==1) { $errors++; $errorlist .= "La contraseña debe ser Alfanumérica.<br />"; }
        if ($password1 != $password2) { $errors++; $errorlist .= "Las contraseñas no concuerdan.<br />"; }
        $password = md5($password1);
        
        if ($errors == 0) {
            
            if ($controlrow["verifyemail"] == 1) {
                $verifycode = "";
                for ($i=0; $i<8; $i++) {
                    $verifycode .= chr(rand(65,90));
                }
            } else {
                $verifycode='1';
            }
            
            $query = doquery("INSERT INTO {{table}} SET id='',regdate=NOW(),verify='$verifycode',usuario='$usuario',password='$password',email='$email1',charname='$charname',charclass='$charclass',charrace='$charrace',difficulty='$difficulty'", "usuarios") or die(mysql_error());
            
            if ($controlrow["verifyemail"] == 1) {
                if (sendregmail($email1, $verifycode) == true) {
                    $page = "<div class='titulo'>Cuenta creada con exito</div><div class='contenido2'>Tu cuenta se ha creado satisfactoriamente.<br /><br />Tu deberias recibir un e-mail de verificación. Una vez que recibas el e-mail debes visitar <a href=\"usuarios.php?do=verificar\">esta página</a> para verificar y comenzar a jugar.</div>";
                } else {
                    $page = "<div class='titulo'>Cuenta creada con exito</div><div class='contenido2'>Tu cuenta ha sido creada satisfactoriamente.<br /><br />Igualmente hay un problema con el envio del e-mail. Contacta con el administrador del juego para arreglarlo.</div>";
                }
            } else {
                $page = "<div class='titulo'>Cuenta creada con exito</div><div class='contenido2'>Tu cuenta ha sido creada satisfactoriamente. Ya puedes empezar a <a href=index.php>jugar</a>.</div>";
            }
            
        } else {
            
            $page = "<div class='titulo'>Error</div><div class='contenido2'>Ocurrieron los siguientes errores:<br /><span style=\"color:red;\">$errorlist</span><br /><a href='usuarios.php?do=registrar'> Volver </a></div>";
            
        }
        
    } else {
        
        $page = gettemplate("registrar");
        if ($controlrow["verifyemail"] == 1) { 
            $controlrow["verifytext"] = "Email real<br><span class=\"small\">Se enviará un código a su e-mail, por favor tenga en cuenta utilizar un e-mail real.</span>";
        } else {
            $controlrow["verifytext"] = "";
        }
        $page = parsetemplate($page, $controlrow);
        
    }
    
    $topnav = "<a href=\"entrar.php?do=entrar\"><img src=\"imagenes/botones/boton_entrar.gif\" alt=\"Entrar\" border=\"0\" /></a><a href=\"ususuarios.php?do=registrar\"><img src=\"iimagenes/botones/boton_registrar.gif\" alt=\"Registrarse\" border=\"0\" /></a><a href=\"ayuda.php\"><img src=\"imagenes/botones/boton_ayuda.gif\" alt=\"Ayuda\" border=\"0\" /></a>";
    display($page, "Registro", false, false, false);
    
}

function verify() {
    
    if (isset($_POST["submit"])) {
        extract($_POST);
        $userquery = doquery("SELECT usuario,email,verify FROM {{table}} WHERE usuario='$usuario' LIMIT 1","usuarios");
        if (mysql_num_rows($userquery) != 1) { die("No existen cuentas con ese nombre de Usuario."); }
        $userrow = mysql_fetch_array($userquery);
        if ($userrow["verify"] == 1) { die("Tu cuenta está verificada."); }
        if ($userrow["email"] != $email) { die("E-mail incorrecto."); }
        if ($userrow["verify"] != $verify) { die("Código de verificación incorrecto."); }
        // Actualzar cuenta.
        $updatequery = doquery("UPDATE {{table}} SET verify='1' WHERE usuario='$usuario' LIMIT 1","usuarios");
        display("<div class='titulo'>Cuenta verificada</div><div class='contenido2'>Tu cuenta ha sido verificada.<br /><br />Ahora puedes empezar a <a href=\"entrar.php?do=entrar\">jugar</a> .<br /><br />Gracias por jugar!</div>","Verificar E-mail",false,false,false);
    }
    $page = gettemplate("verificar");
    $topnav = "<a href=\"entrar.php?do=entrar\"><img src=\"imagenes/botones/boton_entrar.gif\" alt=\"Entrar\" border=\"0\" /></a><a href=\"usuarios.php?do=registrar\"><img src=\"iimagenes/botones/boton_registrar.gif\" alt=\"Registrar\" border=\"0\" /></a><a href=\"ayuda.php\"><img src=\"imagenes/botones/boton_ayuda.gif\" alt=\"Ayuda\" border=\"0\" /></a>";
    display($page, "Verificar E-mail", false, false, false);
    
}

function lostpassword() {
    
    if (isset($_POST["submit"])) {
        extract($_POST);
        $userquery = doquery("SELECT email FROM {{table}} WHERE email='$email' LIMIT 1","usuarios");
        if (mysql_num_rows($userquery) != 1) { die("No hay cuentas con ese e-mail."); }
        $newpass = "";
        for ($i=0; $i<8; $i++) {
            $newpass .= chr(rand(65,90));
        }
        $md5newpass = md5($newpass);
        $updatequery = doquery("UPDATE {{table}} SET password='$md5newpass' WHERE email='$email' LIMIT 1","usuarios");
        if (sendpassemail($email,$newpass) == true) {
            display("Tu nueva contraseña ha sido enviada a tu e-mail.<br /><br />Una vez que lo recibas, podrás continuar <a href=\"entrar.php?do=entrar\">jugando</a>.<br /><br />Gracias por Jugar.","Contraseña Perdida",false,false,false);
        } else {
            display("<div class='titulo'>Error</div><div class='contenido2'>Hay un error con el envio de su contraseña. Por favor comunicate con la administración.<br />Le pedimos perdón por este error. Gracias por avisarnos.</div>","Contraseña Perdida",false,false,false);
        }
        die();
    }
    $page = gettemplate("recuperar");
    $topnav = "<a href=\"entrar.php?do=entrar\"><img src=\"imagenes/botones/boton_entrar.gif\" alt=\"Entrar\" border=\"0\" /></a><a href=\"usuarios.php?do=registrar\"><img src=\"iimagenes/botones/boton_registrar.gif\" alt=\"Registrar\" border=\"0\" /></a><a href=\"ayuda.php\"><img src=\"imagenes/botones/boton_ayuda.gif\" alt=\"Ayuda\" border=\"0\" /></a>";
    display($page, "Contraseña Perdida", false, false, false);
    
}


function sendpassemail($emailaddress, $password) {
    
    $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
    $controlrow = mysql_fetch_array($controlquery);
    extract($controlrow);
    
$email = <<<END
Tu o alguien uso este e-mail para recuperar la contraseña en: $gamename, URL: $gameurl. 
Nosotros le enviamos una nueva contraseña para su cuenta.
Su nueva contraseña es: $password
Gracias por jugar.
<b>Administración de $gamename</b>
END;

    $status = mymail($emailaddress, "Contraseña Perdida en $gamename", $email);
    return $status;
    
}

function sendregmail($emailaddress, $vercode) {
    
    $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
    $controlrow = mysql_fetch_array($controlquery);
    extract($controlrow);
    $verurl = $gameurl . "?do=verificar";
    
$email = <<<END
Tu o alguien uso este e-mail para registrarse en $gamename, URL: $gameurl.

Este e-mail fue enviado para verificar el registro de esta cuenta, lo cual es un paso obligatorio para empezar a jugar $gamename
Por favor, visite la página de verificación ($verurl) e ingrese el código que se encuentra más abajo.
Código de Verificación: $vercode

Si no eres la persona que registro una cuenta, por favor no tome en cuenta este mensaje y no se le enviará más.
Saludos.
<b>Administración de $gamename</b>
END;

    $status = mymail($emailaddress, "Verificacion de Cuenta para $gamename", $email);
    return $status;
    
}

function mymail($to, $title, $body, $from = '') { 

    $controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
    $controlrow = mysql_fetch_array($controlquery);
    extract($controlrow);
    

  $from = trim($from);

  if (!$from) {
   $from = '<'.$controlrow["adminemail"].'>';
  }

  $rp    = $controlrow["adminemail"];
  $org    = '$gameurl';
  $mailer = 'PHP';

  $head  = '';
  $head  .= "Content-Type: text/plain \r\n";
  $head  .= "Date: ". date('r'). " \r\n";
  $head  .= "Return-Path: $rp \r\n";
  $head  .= "From: $from \r\n";
  $head  .= "Sender: $from \r\n";
  $head  .= "Reply-To: $from \r\n";
  $head  .= "Organization: $org \r\n";
  $head  .= "X-Sender: $from \r\n";
  $head  .= "X-Priority: 3 \r\n";
  $head  .= "X-Mailer: $mailer \r\n";

  $body  = str_replace("\r\n", "\n", $body);
  $body  = str_replace("\n", "\r\n", $body);

  return mail($to, $title, $body, $head);
  
}


?>