<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

class Sysmsg 
{

    /** Mensaje de sistema
    * @param <string> $msg Mensaje a mostrar
    * @param <string> $class Clase del div que contiene el mensaje
    * @param <string> $redirect pagina a donde direcciona 'controler/method'
    * @return array 
    */   
    public function echo_msg($msg,$class,$redirect)
    {
        $CI =& get_instance(); 
        $sysreg = array('class'=>$class,'msg'=>$msg);
        $CI->session->set_flashdata('sysmsg', $sysreg);            
        redirect($redirect);        
    }
    
}

/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
