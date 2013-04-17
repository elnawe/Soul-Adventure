<?php

global $controlrow;

    $registrados  = doquery("SELECT * FROM {{table}}", "usuarios");
    $reciboregistrados   = mysql_num_rows($registrados);
	$clanes  = doquery("SELECT * FROM {{table}}", "clan");
    $reciboclanes   = mysql_num_rows($clanes);
	$online= doquery("SELECT * FROM {{table}} WHERE UNIX_TIMESTAMP(onlinetime) >= '".(time()-600)."' ORDER BY charname", "usuarios");
	$reciboonline = mysql_num_rows($online);
	$ultimo=doquery("SELECT * FROM {{table}} ORDER BY id DESC LIMIT 1", "usuarios");
	$reciboultimo= mysql_fetch_array($ultimo);
	$titulo= $controlrow['gamename'];

	
$template = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>$titulo</title>

<link href='estilo/css/login.css' rel='stylesheet' type='text/css' />
<body>
<center>
           
            <b><table width='433'>
                  <tr>
                    <td width='425' height='567'><div align='center' class='logo'><img src='estilo/imagenes/default/logo.png' class='logo'></div>
                   </td>
                  </tr>
                </table>
  </b>
            
            <table class='completo';'>
                  <tr>
                    <th>
                      <div align='center'>
                        <table class='estadisticas'>
                          <tr class='entrar2'>
                            <td><div align='center' class='Estilo6'>Estadisticas</div></td>
                          </tr>
                          <tr class='entrar2'>
                            <td><table height='157' class='entrar2'>
                                <tr>
                                  <td width='1' class='entrar'>&nbsp;</td>
                                  <td width='381'><div>
                                    <div>&nbsp;</div>
                                    <table width='385' height='79' style='width: 280px; height: 65px;'>
                                      <tr>
                                        <th style='text-align:left;'>Registrados</th>
                                        <td>$reciboregistrados</td>
                                        <th style='text-align:left;'>Online</th>
                                        <td><span class='Estilo4'>$reciboonline</span></td>
                                      </tr>
                                      <tr>
                                          <th style='text-align:left;'>Ultimo Registrado</th>
                                        <td><span class='Estilo5'>".$reciboultimo[charname]."</span></td>
                                        <th style='text-align:left;'>Clanes</th>
                                        <td>$reciboclanes</td>
                                      </tr>
                                    </table>
                                    <div>&nbsp;</div>
                                  </div></td>
                                  <td width='10'>&nbsp;</td>
                                  <td width='6'>&nbsp;</td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr class='entrar2'></tr>
                        </table>
                    </div></th>
                    <th>
                      <div align='center'>
                        <table class='estadisticas'>
                          <tr>
                            <td><div align='center' class='Estilo6'>Entrar</div></td>
                          </tr>
                          <tr>
                            <td><table height='157' class='entrar2'>
                              <tr>
                                
                                <td class='estadisticas'>
                                  <table width='444' height='153' style='width: 425px; height: 65px;'>
                                    <td width='238'>
                                    <tr>
                                      <td>
                                          
                                        <form action='entrar.php?do=entrar' method='post'>
                                        <tbody>
                                        <tr align='center'>
                                            <td>Usuario</td>
                                          <td width='70'><input type='text' size='12' name='usuario' /></td>
                                        </tr>
                                          <tr align='center'>
                                            <td>Password</td>
                                          <td><input type='password' size='12' name='password' /></td>
                                        </tr>
                                            <tr>
                                                <th colspan='2'><input name='submit' value='Entrar' type='submit' />                                          &nbsp;</th>
                                        </tr>
                                              </tbody>
                                  </table>
                                  
                                <div align='center'>
                                  <div align='center'><a href='usuarios.php?do=registrar'>Registrate</a></div>
                                  <a href='usuarios.php?do=recuperar'>Recuperar contrase&ntilde;a </a></div>
                              </div>
                                </div></td>
                                <td>&nbsp;</td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                    </div></th>
                  </tr>
  </table>
</center>  
            </div>
    </div></td>
  </tr>
</table></center>
</body>
</html>";
?>
