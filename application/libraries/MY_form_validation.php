<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

class MY_Form_validation extends CI_Form_validation 
{


    // --------------------------------------------------------------------

    /**
     * Alpha Numeric con espacio
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function alpha_numeric_s($str)
    {
            return ( ! preg_match("/^([a-z0-9 ])+$/i", $str)) ? FALSE : TRUE;
    }
    // --------------------------------------------------------------------

    /**
     * Alpha
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function alpha_s($str)
    {
            return ( ! preg_match("/^([a-z ])+$/i", $str)) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------
  

        /**
     * Tel
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function tel($str)
    {
            return ( ! preg_match("/^([0-9-.() ])+$/i", $str)) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------
    
    
}

/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
