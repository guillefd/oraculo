<?php

class Precontacto extends CI_Controller 
{        
   public function __construct()
   {
        parent::__construct();
	$this->load->model('precontacto_model');
        $this->load->helper('template');
        $this->page_name = 'precontacto';

   }
    
    // REMAPEO DE URLS
    public function _remap($method,$params = array())
    {
        switch ($method)
        {   
            case 'index': 
            case 'listado': $this->listado();
                            break;
            case 'search': $this->search();
                            break;                        
            case 'add':     $this->add();
                            break;
            case 'insert':     $this->insert();
                            break;                        
            case 'verid':   return call_user_func_array(array($this, $method), $params);
                            break;
            case 'editid':  return call_user_func_array(array($this, $method), $params);
                            break;                       
            case 'updateId':    $this->updateId();
                                break;                
            case 'getCiudadesAjax': $this->getCiudadesAjax();
                                    break;                                                           
            case 'getRegionAjax': $this->getRegionAjax();
                                    break; 
                                
            default:  $this->sysmsg->echo_msg('Error: La pagina solicitada no existe',3,'precontacto/index'); 
        }     
    }
 
    // INICIALIZA PARAMETROS META TEMPLATE
    public function _init_meta(){
        //genera variables META para pagina actual
        $val['descripcion'] = "";
        $val['keywords'] = "";
        $meta = init_meta($val);
        return $meta;        
    }
    
    // GENERA LOS VALORES <OPTION> DE LOS SELECT
    public function _form_items_options($values,$view){

        $this->load->helper('dropdown');
        // condicion comercial options
        $form_opt['condicion_comercial'] = dd_condicion_comercial();
        // Origen del contacto options
        $form_opt['origen'] = dd_origen();
        // contacto options
        $form_opt['contacto'] = dd_contacto();        
        // lista de paises
        $form_opt['pais'] = dd_paises();
        
        switch($view)
        {
           case 'verid':    $form_opt['ciudad'] = dd_ciudad($values->ciudad);             
                            $form_opt['provincia'] = dd_provincia($values->provincia);
                            break;
                          
           case 'editid':   
                            if($this->input->post('pais') && $this->input->post('ciudad'))
                            {                            
                                $form_opt['ciudad'] = dd_ciudades($this->input->post('pais'));
                                $form_opt['provincia'] = dd_provincia($this->input->post('provincia'));  
                            }
                            else if($this->input->post('pais'))
                                    {      
                                        $form_opt['ciudad'] = dd_ciudades($values->pais);
                                        $form_opt['provincia'] = (isset($values->ciudad)) ? dd_provincia($values->ciudad) : array();
                                    }
                                    else if($values->pais && $values->ciudad)
                                        {
                                            $form_opt['ciudad'] = dd_ciudades($values->pais);
                                            $form_opt['provincia'] = dd_provincia($values->provincia);
                                        }
                                        else
                                            {
                                                $form_opt['ciudad'] = (isset($values->pais)) ? dd_ciudades($values->pais) : array();
                                                $form_opt['provincia'] = (isset($values->ciudad)) ? dd_provincia($values->provincia) : array();
                                            }
                            break;

           case 'add':     if($this->input->post('pais'))
                            { 
                                $form_opt['ciudad'] = dd_ciudades($this->input->post('pais'));                              
                                $form_opt['provincia'] = ($this->input->post('provincia')) ? dd_provincia($this->input->post('provincia')) : array();  
                            }else
                                {
                                    $form_opt['ciudad'] = array();
                                    $form_opt['provincia'] = array();
                                }  
                            break;
        }
        return $form_opt;
    }    
    
    
    /** Definición de los items del form
     * @return array array de array(index_name,label,input_name,input_id,input_type,js,mode)
     */
    public function _form_items(){
        
        //func params  array(index_name,label,input_name,input_id,input_type,js,mode)
        $form_item[] = array('nombre','Nombre','nombre','nombre','text','','');
        $form_item[] = array('apellido','Apellido','apellido','apellido','text','','');
        $form_item[] = array('telefono','Teléfono','telefono','telefono','text','','');
        $form_item[] = array('movil','Movil','movil','movil','text','','');
        $form_item[] = array('email','Email','email','email','text','','');
        $form_item[] = array('empresa','Empresa','empresa','empresa','text','','');
        $form_item[] = array('direccion','Dirección','direccion','direccion','text','','');
        $form_item[] = array('pais','Pais','pais','paisDrop','select','','');
        $form_item[] = array('ciudad','Ciudad','ciudad','ciudadDrop','select','','');
        $form_item[] = array('provincia','Provincia/Estado/Región','provincia','provinciaDrop','select','','readonly');
        $form_item[] = array('condicion_comercial', 'Condicion comercial', 'condicion_comercial', 'condicion_comercial', 'select','','');
        $form_item[] = array('origen','Contactó por','origen','origen','select','','');
        $form_item[] = array('contacto','Encontró por','contacto','contacto','select','','');
        $form_item[] = array('id_user','Registrado por','id_user','id_user','text','','disabled');
        $form_item[] = array('fecha_alta','Fecha Alta','fecha_alta','fecha_alta','text','','disabled');
              
        return $form_item;
        
    }

    // REGLAS VALIDACION DE LOS FORM ITEMS
    public function _init_form_validation()
    {
        $this->form_validation->set_rules('nombre','Nombre','trim|required|alpha_s|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('apellido','Apellido','trim|alpha_s|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('telefono','Telefono','trim|tel|min_lenght[4]');
        $this->form_validation->set_rules('movil','Movil','trim|tel|min_lenght[4]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');   
        $this->form_validation->set_rules('direccion','Dirección','trim|alpha_numeric_s');
    } 
       
      /** Genera elementos del FORM
     * @param array $values Array con valores de la base de datos
     * @param <string> $reg_user_data var con el nombre usuario que registro
     * @param <string> $mode modo del form (verid, editid, add)
     * @return array 
     */   
    public function _init_form_items($values,$values_alt,$view)
    {
        $items = array();
        $this->load->library('form_validation');
        //opciones de los items form "select"
        $form_options = $this->_form_items_options($values,$view);       
        // FORM ITEMS
        $form_items = $this->_form_items();       
        foreach ($form_items as $item) {
            //                $item(index_name,label,input_name,input_id,input_type,js,mode)
            //_gen_form_items_array($vec,$index,$label,$input_n,$input_id,$input_t,$value,$js,$mode,$options )
            $index = $item[0];
            $options = (isset($form_options[$index])) ? $form_options[$index] : ''; 
            switch($view){
                
                case 'verid':
                              $mode = 'disabled';
                              $val = (isset($values_alt[$index])) ? $values_alt[$index] : $values->$index;
                              break;
                case 'editid':
                              $mode = $item[6];
                              // Copia valor en campo (primero si hubo post, luego valor guardado en bd)                    
                              $val = ($this->input->post($index)) ? $this->input->post($index) : $values->$index;                       
                              // Copia valor alternativo para campo ($alt_values[])
                              $val = (isset($values_alt[$index])) ? $values_alt[$index] : $val;                              
                              break;
                case 'add':   
                              $mode = $item[6];
                              // Copia valor post en campo                     
                              $val = ($this->input->post($index)) ? $this->input->post($index) : '';                       
                              // Copia valor alternativo para campo ($alt_values[])
                              $val = (isset($values_alt[$index])) ? $values_alt[$index] : $val;     
                              break;  
               }
               $items = gen_form_items_array($items,$item[0],$item[1],$item[2],$item[3],$item[4],$val,$item[5],$mode,$options);  
        }
        return $items;
    }
    
    public function _gen_alt_values($id,$values)
    {
        // consulta valor nombre(texto) del usuario
        $id_user = $this->usuario_model->getId($values->id_user);
        $vec['id_user'] = $id_user->nombre.' '.$id_user->apellido;
        
        return $vec;
        
    }

    public function _valida_search()
    {
        if($this->input->post('keysearch') || $this->session->userdata('keysearch'))
        {
            if($this->input->post('keysearch'))
            {
                $post = trim($this->input->post('keysearch'));            
                $pre_count = count_chars($post);
                $chars = array_sum($pre_count);            
                if($chars>1)
                {                
                    $keysearch = array('keysearch'=>$post);
                    $this->session->set_userdata($keysearch);  
                }else
                    {
                        return FALSE;
                    }
            }
            return TRUE;
        }
        else
            {
                return FALSE;
            }
    }

// -------------------------------------------------------------------------------------------------------------------------    
// METODOS PAGE MASTERS Y AJAX RESPONSE    
    
    //pagina listado de precontactos - tabla
    public function listado()
    { 
//        // Benchmark
//        if(ENVIRONMENT == 'dev'){
//            $this->output->enable_profiler(TRUE);
//        }
//        // en benchmark
        $this->session->unset_userdata('keysearch');
        $this->load->helper(array('form','pagination'));         
        $tpl = init_tmpl($this->page_name);
        $meta = $this->_init_meta();
        //definicion layout (opciones: hideboth / hidecol1 / hidecol2)
        $tpl['body_class'] = "hideboth";
        $tpl = array_merge($tpl,$meta);               
        $result = $this->precontacto_model->getFrom($this->config->item('per_page'),$this->uri->segment(3));
        if(count($result['data'])>0)
        {
            $data['rows'] = $result['data'];
            //pagination         
            $end_url = 'precontacto/listado';
            $data['total_rows'] = $result['total'];
            $config = init_pagination($end_url,$data['total_rows']);     
            $this->pagination->initialize($config);        
            $data['links']=$this->pagination->create_links(); 
        }else
            {
                $data['total_rows']=0;
                $data['links']='';
            }             
        //llama func carga template completo
        $view = 'precontacto/listado';
        load_view($tpl,$data,$view);
    }

    //pagina listado de precontactos - tabla
    public function search()
    { 
        if(!$this->_valida_search())
        {
            $this->sysmsg->echo_msg('Búsqueda inválida, mínimo 2 caracteres. Vuelva a intentarlo. ',2,'precontacto/listado');
        }   
        $this->load->helper(array('form','pagination'));         
        $tpl = init_tmpl($this->page_name);
        $meta = $this->_init_meta();
        //definicion layout (opciones: hideboth / hidecol1 / hidecol2)
        $tpl['body_class'] = "hideboth";
        $tpl = array_merge($tpl,$meta);
        $result = $this->precontacto_model->getSearchFrom($this->config->item('per_page'),$this->uri->segment(3),$this->session->userdata('keysearch'));               
        if(count($result['data'])>0){
            $data['rows'] = $result['data'];               
            //pagination
            $end_url = 'precontacto/search';
            $data['total_rows'] = $result['total'];     
            $config = init_pagination($end_url,$data['total_rows']);
            $this->pagination->initialize($config);
            $data['links']=$this->pagination->create_links();                   
             //llama func carga template completo
        }else
            {
                $data['total_rows']=0;
                $data['links']='';
            }    
        $view = 'precontacto/listado';
        load_view($tpl,$data,$view);
    }    
    
    //pagina de vista del precontacto
    public function verid($id)
    {
        //inits loads
        $this->load->helper('form'); 
        $this->load->model('usuario_model');        
        //inicia template
        $tpl = init_tmpl($this->page_name);
        $meta = $this->_init_meta();
        //definicion layout (opciones: hideboth / hidecol1 / hidecol2)
        $tpl['body_class'] = "hideboth";        
        $tpl = array_merge($tpl,$meta); 
        // valores base de datos 
        $values = $this->precontacto_model->getId($id);
        if(count($values)>0)
        { 
            $data['existe']=1;
            // valores alternos a reemplazar en campos form
            $values_alt = $this->_gen_alt_values($id, $values);
            //genera form items
            $data['items'] = $this->_init_form_items($values,$values_alt,'verid');
            //grupos de fieldset // array('titulo_fieldset',indice_final)
            $data['fieldsets'] = array(array('Datos de contacto',9),
                                       array('Origen',2), 
                                       array('Log',1) );
        }else
            {
                $data[]='';
            }
        //llama view
        $view = 'precontacto/verid';
        load_view($tpl, $data, $view);        
    }
    
    //pagina de edicion del precontacto
    public function editid($id)
    {
        //inits loads
        $this->load->helper('form');
        $this->load->model('usuario_model');         
        //inicia template
        $tpl = init_tmpl($this->page_name);
        $meta = $this->_init_meta();
        //definicion layout (opciones: hideboth / hidecol1 / hidecol2)
        $tpl['body_class'] = "hideboth";        
        $tpl = array_merge($tpl,$meta);
        // datos precontacto
        $values= $this->precontacto_model->getId($id);
        if(count($values)>0)
        { 
            $data['existe']=1;
            // valores alternos a reemplazar en campos form
            $values_alt = $this->_gen_alt_values($id, $values);    
            //genera form items
            $data['items'] = $this->_init_form_items($values,$values_alt,'editid');
            // form items hidden
            $data['h_items'] = array('id'=>$values->id);
            //grupos de fieldset // array('titulo_fieldset',indice_final)
            $data['fieldsets'] = array(array('Editar | Datos de contacto',9),
                                       array('Origen',2), 
                                       array('Log',1) );        
        }else
            {
                $data[]='';
            }
        //llama view
        $view = 'precontacto/editid';
        load_view($tpl, $data, $view);
        
    }

    //pagina de nuevo precontacto
    public function add()
    {
        //inits loads
        $this->load->helper('form');  
        //inicia template
        $tpl = init_tmpl($this->page_name);
        $meta = $this->_init_meta();
        //definicion layout (opciones: hideboth / hidecol1 / hidecol2)
        $tpl['body_class'] = "hidecol1";        
        $tpl = array_merge($tpl,$meta);
        //genera form items
        $data['items'] = $this->_init_form_items('','','add');
        //grupos de fieldset del form // array('titulo_fieldset',indice_final)
        $data['fieldsets'] = array(array('Nuevo | Datos de contacto',9),
                                   array('Origen',2)
                                    );        
        //llama view
        $view = 'precontacto/add';
        load_view($tpl, $data, $view);
        
    }    
        
    public function updateId()
    {
        //validacion
        $this->load->library('form_validation');
        $this->load->library('MY_form_validation');
        $this->_init_form_validation();
        if($this->input->post('id'))
        {
            	if ($this->form_validation->run() == FALSE)
		{
			$this->editid($this->input->post('id'));
		}
		else
		{
                        $this->precontacto_model->updateId();
                        $this->sysmsg->echo_msg('Se actualizaron los datos del precontacto',1,'precontacto/listado');                        
		}              
        }else
            {
                $this->listado();
            }
    }

    public function insert()
    {
        //validacion
        $this->load->library('form_validation');
        $this->load->library('MY_form_validation');
        $this->_init_form_validation();
        if ($this->form_validation->run() == FALSE)
        {
                $this->add();                 
        }
        else
            {
                    $this->precontacto_model->insert();
                    $this->sysmsg->echo_msg('Se agregó un nuevo precontacto',1,'precontacto/listado');
            }              
    }    
    
    function getCiudadesAjax()
    {
        $this->load->model('geo_model');
        $ciudades = $this->geo_model->getCiudadesAjax($this->input->post('paisid'));
        echo(json_encode($ciudades));
    } 

    function getRegionAjax()
    {
        $this->load->model('geo_model');       
        $ciudad = $this->geo_model->getCiudad($this->input->post('cityid'));
        $regionid = $ciudad[0]['RegionID'];
        $region = $this->geo_model->getRegionAjax($regionid);
        echo(json_encode($region));
    }     

}

/* End of file precontacto.php */
/* Location: ./application/controllers/precontacto.php */