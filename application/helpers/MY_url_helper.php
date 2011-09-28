<?php

	function tpl_url($uri = '')
	{
		$CI =& get_instance();
		return $CI->config->site_url($uri).$CI->config->item('tpl_path');
	}

	function tpl_url_ico()
	{
		$CI =& get_instance();
		return $CI->config->site_url().$CI->config->item('tpl_path').$CI->config->item('tpl_ico_path');
	}
        
/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
