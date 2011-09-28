<?

// devuelve ESTILO css del form object segun tipo
function input_style($type){
    
    $vec_estilos = array(
                   'text' => 'type-text',    
                   'select' => 'type-select',
                   'checkbox'=> 'type-check',
                   'radio'=>'type-check',
                   'textarea'=>'type-text'
                    );
    if(array_key_exists($type, $vec_estilos))
    {
        return $vec_estilos[$type];    
    }
}

//imprime los campos del form segun parametros
//argument array   TEXT (0$label,1$input_n,2$input_id,3$input_t,4$value,5$js,6$mode);
//argument array SELECT (0$label,1$input_n,2$input_id,3$input_t,4$value,5$options,6$js,7$mode);
function display_form_field($r)
{
    // switch tipo de form field (text, select, checkbox, radio, textarea)
    switch ($r[3])
    { 
            case 'text': $arguments = array('name'=>$r[1],'id'=> $r[2],'value'=>$r[4]);
                         if(!empty($r[6])){ $arguments[$r[6]] = $r[6]; }
                         echo form_input($arguments);
                         break;     
                     
            case 'select':  $js = 'id="'.$r[2].'" '.$r[6];
                            $js.= (!empty($r[7])) ? $r[7] : '';
                            echo form_dropdown($r[1], $r[5], $r[4], $js);
                            break;             

    }         
}


//devuelve 'active' si URL actual coincide con menu
function is_menu_active($segment,$current)
{
    if($segment == $current){
        echo " active";
    }
    
}

/**
 * Hace ECHO el mensaje del sistema
 * @param array $vec Array con form items
 */
function sysmsg()
{
    $CI =& get_instance();
    if($CI->session->flashdata('sysmsg'))
    {
        $reg = $CI->session->flashdata('sysmsg');
        switch($reg['class']){
            case 1 :    $class = 'sysnote';
                        break;
            case 2 :    $class = 'sysimportant';
                        break;
            case 3 :    $class = 'syswarning';
                        break;                    
        }
        echo '<div class="'.$class.'" id="sysmsg" align="center"><kbd>'.$reg['msg'].'</kbd></div>';
    }
}


/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
