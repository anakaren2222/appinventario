<?php

//Retornar la url del proyecto
function base_url()
{
   return Base_URL;
}
//Retorna la url de Assets
function media()
{
   return Base_URL . "/Assets";
}
//Muestra informacion formateada
function dep($data)
{
   $format = print_r('<pre>');
   $format .= print_r($data);
   $format .= print_r('</pre>');
   return $format;
}
//Diccionario de validaciones que nos permite utilizar para proteger de inyecciones SQL
function strClean($strCadena)
{
   $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
   $string = trim($string);
   $string = stripslashes($string);
   $string = str_ireplace("<script>", "", $string);
   $string = str_ireplace("</script>", "", $string);
   $string = str_ireplace("<script src>", "", $string);
   $string = str_ireplace("SELECT * FROM", "", $string);
   $string = str_ireplace("DELETE FROM", "", $string);
   $string = str_ireplace("INSERT INTO", "", $string);
   $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
   $string = str_ireplace("DROP TABLE", "", $string);
   $string = str_ireplace("OR '1'='1'", "", $string);
   $string = str_ireplace('OR "1"="1"', "", $string);
   $string = str_ireplace('OR `1`=`1`', "", $string);
   $string = str_ireplace("is NULL; --", "", $string);
   $string = str_ireplace("LIKE '", "", $string);
   $string = str_ireplace('LIKE "', "", $string);
   $string = str_ireplace("LIKE `", "", $string);
   $string = str_ireplace("[", "", $string);
   $string = str_ireplace("]", "", $string);
   $string = str_ireplace("==", "", $string);
   return $string;
}
//Generar un token
function token()
{
   $r1 = bin2hex(random_bytes(10));
   $r2 = bin2hex(random_bytes(10));
   $r3 = bin2hex(random_bytes(10));
   $r4 = bin2hex(random_bytes(10));
   $r5 = bin2hex(random_bytes(10));
   $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4 . '-' . $r5;
   return $token;
}
//Formatear para valores monetarios
function formatMoney($cantidad)
{
   $cantidad = number_format($cantidad, 2, SPD, SPM);
   return $cantidad;
}

//Contenido del hader
function headerContent($data = "")
{
   $view_header = "Views/Templates/header.php";
   require_once($view_header);
}
//Contenido del footer
function footerContent($data ="")
{
   $view_header = "Views/Templates/footer.php";
   require_once($view_header);
}
//MOdales
function getModal(string $nameModal, $data)
{
   $view_modal = "Views/Templates/Modals/{$nameModal}.php";
   require_once $view_modal;
}