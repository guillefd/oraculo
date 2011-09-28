<?php

// INICIALIZA PARAMETROS TEMPLATE
function init_tmpl($page)
{
    $CI =& get_instance();
    //template url    
    $tpl['base_url_page'] = base_url().$page;
    $tpl['path'] = base_url().$CI->config->item('tpl_path');
    $tpl['img_path'] = base_url().$CI->config->item('tpl_path').'images/tables/';        
    $tpl['css'] = $CI->config->item('tpl_css');
    $tpl['js'] = $CI->config->item('tpl_js');  
    $tpl['menu_path'] = base_url().$CI->config->item('tpl_menu_path');
    $tpl['menu_theme'] = $CI->config->item('tpl_menu_theme');          
    $tpl['menu_css'] = $CI->config->item('tpl_menu_css');
    $tpl['menu_theme_css'] = $CI->config->item('tpl_menu_theme_css');                 
    $tpl['head1']=$CI->config->item('tpl_head1');
    $tpl['copyright_txt']=$CI->config->item('tpl_sitename');
    $tpl['version']=$CI->config->item('appversion');        
    $tpl['power_txt']=$CI->config->item('tpl_powerby');
    $tpl['power_link']=$CI->config->item('tpl_powerlink');
    $tpl['tpl_by_link']=$CI->config->item('tpl_by_link');
    $tpl['tpl_by_txt']=$CI->config->item('tpl_by_txt');
    $tpl['btn_volver_js']="goToURL('parent','".$tpl['base_url_page']."');return document.MM_returnValue";
    $tpl['btn_volver_search_js']="goToURL('parent','".$tpl['base_url_page']."/search');return document.MM_returnValue";
    $tpl['icono_ver'] = $CI->config->item('icono_ver');
    $tpl['icono_edit'] = $CI->config->item('icono_edit');
    return $tpl;      
}

// INICIALIZA PARAMETROS META TEMPLATE
function init_meta($vec){
    
    $CI =& get_instance();
    //genera variables META para pagina actual
    $meta['pg_title'] = $CI->config->item('tpl_sitename');
    $meta['pg_description'] = $vec['descripcion'];
    $meta['pg_keywords'] = $vec['keywords'];
    /*Opciones: ALL, INDEX, NOFOLLOW, NOINDEX.*/
    $meta['pg_robots'] = "ALL";
    return $meta;

}

function load_view($tpl,$data,$view)
{
    $CI =& get_instance();
    //EMBEDED VIEWS        
    $zonas['z_head'] = $CI->load->view('zonas/z_head',$tpl,true);  
    $zonas['z_menu'] = $CI->load->view('zonas/z_menu',$tpl,true);          
    $zonas['z_header'] = $CI->load->view('zonas/z_header',$tpl,true); 
    $content = array_merge($tpl,$data);
    $zonas['z_content'] = $CI->load->view($view,$content,true);     
    $zonas['z_footer']=$CI->load->view('zonas/z_footer',$tpl,true);  

    // CARGA VISTA TEMPLATE COMPLETO
    $CI->load->view('template', $zonas);    
}


/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
