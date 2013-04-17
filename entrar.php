<?php // entrar.php :: Login.
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
if (isset($_GET["do"])) {
    if ($_GET["do"] == "entrar") { login(); }
    elseif ($_GET["do"] == "salir") { logout(); }
}

function login() {
    
    include('configuracion.php');
    $link = opendb();
	
    
    if (isset($_POST["submit"])) {
        
        $query = doquery("SELECT * FROM {{table}} WHERE usuario='".$_POST["usuario"]."' AND password='".md5($_POST["password"])."' LIMIT 1", "usuarios");
        if (mysql_num_rows($query) != 1) { die("Nombre de usuario y/o contrase&ntilde;a Invalida."); }
        $row = mysql_fetch_array($query);
        if (isset($_POST["rememberme"])) { $expiretime = time()+31536000; $rememberme = 1; } else { $expiretime = 0; $rememberme = 0; }
        $cookie = $row["id"] . " " . $row["usuario"] . " " . md5($row["password"] . "--" . $dbsettings["secretword"]) . " " . $rememberme;
        setcookie("dkgame", $cookie, $expiretime, "/", "", 0);
        header("Location: index.php");
        die();
        
    }
    
	
     $page = gettemplate("entrar");
    $title = "Entrar al Juego ";
    logindisplay($page, $title);
    
}
    

function logout() {
    
    setcookie("dkgame", "", time()-100000, "/", "", 0);
    header("Location: entrar.php?do=entrar");
    die();
    
}

?>