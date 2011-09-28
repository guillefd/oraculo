<?php

// INICIALIZA PARAMETROS PAGINACION  
function init_pagination($end_url,$total)
{
    $CI =& get_instance();
    $CI->load->library('pagination');
    $config['base_url'] = base_url().$end_url;
    $config['total_rows'] = $total;        
    $CI->lang->load('pagination');
    $config['first_link'] = $CI->lang->line('pag_first');
    $config['full_tag_open'] = $CI->config->item('full_tag_open');
    $config['last_link'] = $CI->lang->line('pag_last');
    $config['full_tag_close'] = $CI->config->item('full_tag_close');
    $config['cur_tag_open'] = $CI->config->item('cur_tag_open');
    $config['cur_tag_close'] = $CI->config->item('cur_tag_close');
    return $config;
} 

/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
