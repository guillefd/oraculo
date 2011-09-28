<?php

function dd_condicion_comercial()
{
    return array(''=>'Seleccione...','empresa'=>'Empresa','independiente'=>'Independiente','particular'=>'particular');                  
}

function dd_origen()
{
    return array(''=>'Seleccione...','telefono'=>'Telefono','visita'=>'Visitó Sala','email'=>'Email');
}

function dd_contacto()
{
    return array(''=>'Seleccione...','google'=>'Google','internet'=>'Internet','newsletter'=>'Newsletter','recomendacion'=>'Recomendación');
}

function dd_paises()
{
    $CI = & get_instance();
    $CI->load->model('geo_model');
    $paises = $CI->geo_model->getPaises(); 
    return array(''=>'Seleccione pais...')+$paises;
}

function dd_ciudad($id_ciudad)
{
    $CI = & get_instance();
    $CI->load->model('geo_model');    
    return $CI->geo_model->getCiudadID($id_ciudad);
}

function dd_ciudades($id_pais)
{
    $CI = & get_instance();
    $CI->load->model('geo_model');      
    $ciudades = $CI->geo_model->getCiudadesXpais($id_pais);
    return array(''=>'Seleccione ciudad...')+$ciudades;       
}

function dd_provincia($id_region)
{
    $CI = & get_instance();
    $CI->load->model('geo_model');    
    return $CI->geo_model->getRegionID($id_region);
}

/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
