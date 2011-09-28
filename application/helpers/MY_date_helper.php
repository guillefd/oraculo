<?php

function convierte_a_fecha_unix($fecha)
{
    $a = substr($fecha,0,4);
    $m = substr($fecha,5,2);
    $d = substr($fecha,8,2);
    $h = substr($fecha,11,2);
    $min = substr($fecha,14,2);
    $unix = mktime($h, $min, 0, $m, $d, $a);
    return $unix;    
}

// Convierte segundos a dias, horas, minutos, segundos
function convierte_sec_a_dias($sec)
{
    if($sec>=86400)
    {
        $dias = round($sec/86400);
        $sec = $sec % 86400;
    }
    if($sec>=3600)
    {            
        $hs = round($sec/3600);
        $sec = $sec%3600;
    }        
    if($sec>=60)
    {
       $min = round($sec/60);
       $sec = $sec%60;
    }
    $dias = (isset($dias))? $dias : 0;
    $hs   = (isset($hs))? $hs : 0;
    $min  = (isset($min))? $min : 0;
    $time = array($dias,$hs,$min,$sec);      
      
    return $time;    
}


/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
