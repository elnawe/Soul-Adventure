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
   if (isset($_POST["submit"])) {
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($gamename == "") { $errors++; $errorlist .= "Se requiere un nombre para el Juego.<br />"; }
        if (($gamesize % 5) != 0) { $errors++; $errorlist .= "El tamaño del mapa debe ser divisor de 5.<br />"; }
        if (!is_numeric($gamesize)) { $errors++; $errorlist .= "El tamaño del mapa se debe indicar en números.<br />"; }
        if ($forumtype == 2 && $forumaddress == "") { $errors++; $errorlist .= "Tienes que especificar la dirección del foro externo.<br />"; }
        if ($class1name == "") { $errors++; $errorlist .= "Se requiere un nombre para las Clases.<br />"; }
        if ($class2name == "") { $errors++; $errorlist .= "Se requiere un nombre para las Clases.<br />"; }
        if ($class3name == "") { $errors++; $errorlist .= "Se requiere un nombre para las Clases.<br />"; }
		if ($race1name == "") { $errors++; $errorlist .= "Se requiere un nombre para las Razas.<br />"; }
		if ($race2name == "") { $errors++; $errorlist .= "Se requiere un nombre para las Razas.<br />"; }
		if ($race3name == "") { $errors++; $errorlist .= "Se requiere un nombre para las Razas.<br />"; }
		if ($race4name == "") { $errors++; $errorlist .= "Se requiere un nombre para las Razas.<br />"; }
		if ($race5name == "") { $errors++; $errorlist .= "Se requiere un nombre para las Razas.<br />"; }
        if ($diff1name == "") { $errors++; $errorlist .= "Se requiere un nombre para las dificultades.<br />"; }
        if ($diff2name == "") { $errors++; $errorlist .= "Se requiere un nombre para las dificultades.<br />"; }
        if ($diff3name == "") { $errors++; $errorlist .= "Se requiere un nombre para las dificultades.<br />"; }
        if ($diff2mod == "") { $errors++; $errorlist .= "Se requiere un valor para las dificultades.<br />"; }
        if ($diff3mod == "") { $errors++; $errorlist .= "Se requiere un valor para las dificultades.<br />"; }
        
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET gamename='$gamename',gamesize='$gamesize',forumtype='$forumtype',forumaddress='$forumaddress',compression='$compression',class1name='$class1name',class2name='$class2name',class3name='$class3name',race1name='$race1name',race2name='$race2name',race3name='$race3name',race4name='$race4name',race5name='$race5name',diff1name='$diff1name',diff2name='$diff2name',diff3name='$diff3name',diff2mod='$diff2mod',diff3mod='$diff3mod',gameopen='$gameopen',verifyemail='$verifyemail',gameurl='$gameurl',adminemail='$adminemail',shownews='$shownews',showonline='$showonline',showbabble='$showbabble' WHERE id='1' LIMIT 1", "control");
            admindisplay("Cambios realizados.","Cambios Principales");
        } else {
            admindisplay("<b>Errores</b><br /><div style=\"color:red;\">$errorlist</div><br />.", "Cambios Principales");
        }
    }
    

    if ($controlrow["forumtype"] == 0) { $controlrow["selecttype0"] = "selected=\"selected\" "; } else { $controlrow["selecttype0"] = ""; }
    if ($controlrow["forumtype"] == 1) { $controlrow["selecttype1"] = "selected=\"selected\" "; } else { $controlrow["selecttype1"] = ""; }
    if ($controlrow["forumtype"] == 2) { $controlrow["selecttype2"] = "selected=\"selected\" "; } else { $controlrow["selecttype2"] = ""; }
    if ($controlrow["compression"] == 0) { $controlrow["selectcomp0"] = "selected=\"selected\" "; } else { $controlrow["selectcomp0"] = ""; }
    if ($controlrow["compression"] == 1) { $controlrow["selectcomp1"] = "selected=\"selected\" "; } else { $controlrow["selectcomp1"] = ""; }
    if ($controlrow["verifyemail"] == 0) { $controlrow["selectverify0"] = "selected=\"selected\" "; } else { $controlrow["selectverify0"] = ""; }
    if ($controlrow["verifyemail"] == 1) { $controlrow["selectverify1"] = "selected=\"selected\" "; } else { $controlrow["selectverify1"] = ""; }
    if ($controlrow["shownews"] == 0) { $controlrow["selectnews0"] = "selected=\"selected\" "; } else { $controlrow["selectnews0"] = ""; }
    if ($controlrow["shownews"] == 1) { $controlrow["selectnews1"] = "selected=\"selected\" "; } else { $controlrow["selectnews1"] = ""; }
    if ($controlrow["showonline"] == 0) { $controlrow["selectonline0"] = "selected=\"selected\" "; } else { $controlrow["selectonline0"] = ""; }
    if ($controlrow["showonline"] == 1) { $controlrow["selectonline1"] = "selected=\"selected\" "; } else { $controlrow["selectonline1"] = ""; }
    if ($controlrow["showbabble"] == 0) { $controlrow["selectbabble0"] = "selected=\"selected\" "; } else { $controlrow["selectbabble0"] = ""; }
    if ($controlrow["showbabble"] == 1) { $controlrow["selectbabble1"] = "selected=\"selected\" "; } else { $controlrow["selectbabble1"] = ""; }
    if ($controlrow["gameopen"] == 1) { $controlrow["open1select"] = "selected=\"selected\" "; } else { $controlrow["open1select"] = ""; }
    if ($controlrow["gameopen"] == 0) { $controlrow["open0select"] = "selected=\"selected\" "; } else { $controlrow["open0select"] = ""; }

	$template = gettemplate("admin/paginas/principal");
$page = parsetemplate($template, $controlrow);
    $page = $xml . $page;
admindisplay($page, "Administración-Cambios Principales");
    

	
?>