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
function checkcookies() {

    include('configuracion.php');
    
    $row = false;
    
    if (isset($_COOKIE["dkgame"])) {
        
        // FORMATO DE COOKIE:
        // {ID} {USERNAME} {PASSWORDHASH} {REMEMBERME}
        $theuser = explode(" ",$_COOKIE["dkgame"]);
        $query = doquery("SELECT * FROM {{table}} WHERE usuario='$theuser[1]'", "usuarios");
        if (mysql_num_rows($query) != 1) { die("Información invalida (Error 1). Por favor, borre las cookies y reintente."); }
        $row = mysql_fetch_array($query);
        if ($row["id"] != $theuser[0]) { die("Información invalida (Error 2). Por favor borre las cookies y reintente."); }
        if (md5($row["password"] . "--" . $dbsettings["secretword"]) !== $theuser[2]) { die("Información invalida (Error 3). Por favor borre las cookies y reintente."); }
        
        // Validación de Cookies.
        $newcookie = implode(" ",$theuser);
        if ($theuser[3] == 1) { $expiretime = time()+31536000; } else { $expiretime = 0; }
        setcookie ("dkgame", $newcookie, $expiretime, "/", "", 0);
		$ip = $_SERVER['REMOTE_ADDR'];
        $onlinequery = doquery("UPDATE {{table}} SET ip='$ip', onlinetime=NOW() WHERE id='$theuser[0]' LIMIT 1", "usuarios");
		
        
    }
        
    return $row;
    
}

?>