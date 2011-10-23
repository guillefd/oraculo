<?php

class Presupuesto extends CI_Controller 
{        
   public function __construct()
   {
        parent::__construct();
	$this->load->model('presupuesto_model');
        $this->load->model('servicio_model');
        $this->lang->load('presupuestos');
        $this->load->helper('template');
        $this->page_name = 'presupuesto';        
   }
   
    public function _remap($method,$params = array())
    {
        switch($method)
        {
            case 'index':
            case 'pendiente':   $this->pendiente();
                                break; 
            case 'verid':       return call_user_func_array(array($this, $method), $params);
                                break;
            
            default:  $this->sysmsg->echo_msg('Error, la pagina solicitada no existe',3,'presupuesto/index');     
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
    
    public function _string_time_recibido($r)
    {
        $fechaunix = convierte_a_fecha_unix($r->freg);
        $diff = time() - $fechaunix;
        $time = convierte_sec_a_dias($diff);
        if($time[0]>0)
        {          
            $str = $time[0].'+'.($time[0]>1?' dias' : ' dia');
        }else if($time[1]>0)
                {
                    $str = $time[1].'+'.($time[1]>1?' horas':' hora'); 
                }else
                    {
                        $str = $time[2].'+'.($time[2]>1?' mins':' min'); 
                    }
        $r->esperaT.= $str;
        $r->esperaN = $diff;
        return $r;
    }
   
    public function _icono_time_recibido($r)
    {
        $limite1 = $this->config->item('resp_pres_limit_1');
        $limite2 = $this->config->item('resp_pres_limit_2');
        if($r->esperaN<$limite1)
        {
            $r->esperaIcono = ($r->prioridad==1)? $this->config->item('icono_t1_hot') : $this->config->item('icono_t1') ;
            $r->esperaIconotxt = $this->lang->line('presus_pendiente_limite1');
        }
        else if($r->esperaN<$limite2)
            {
                $r->esperaIcono = ($r->prioridad==1)? $this->config->item('icono_t2_hot') : $this->config->item('icono_t2') ;
                $r->esperaIconotxt = $this->lang->line('presus_pendiente_limite2');           
            }
            else
                {
                    $r->esperaIcono = ($r->prioridad==1)? $this->config->item('icono_t3_hot') : $this->config->item('icono_t3') ;
                    $r->esperaIconotxt = $this->lang->line('presus_pendiente_limite3');                      
                }
        return $r;

    }
    
    public function _string_servicio($r)
    {
        $r->interestxt = '';
        $vec_interes = explode(' ',trim($r->interes));
        foreach($vec_interes as $value)
        {
            $reg_interes = $this->servicio_model->getId($value);
            $r->interestxt.= $reg_interes['nombre_corto'].'<br>';
        }
        return $r;
    }
    
    public function _string_fecha_estimada($r)
    {
        $r->fecha_txt = $this->lang->line('presus_sin_fecha_estimada');
        if($r->fecha_estimada=='estimado' || $r->fecha_estimada=='exacto')
        {
            if(!empty($r->fecha_uso))
            {
                $r->fecha_txt = substr($r->fecha_uso, 0, 10);
            }
        }        
        return $r;   
    }

    public function _string_horario_estimado($r)
    {
        if( ($r->horario_estimado=='estimado' || $r->horario_estimado=='exacto') && (!empty($r->hora_in) && !empty($r->hora_out)) )
        {
           $r->horario_txt = substr($r->hora_in, 0, 5);
           $r->horario_txt.= '-'.substr($r->hora_out,0 ,5);
        }
        else if(!empty($r->duracion))
            {
                $r->horario_txt = $r->duracion;
            }
            else
                {
                    $r->horario_txt = $this->lang->line('presus_sin_hora_estimada');         
                }
        return $r;   
    }  
    
    public function _string_detalle($r)
    {
        $temp = !empty($r->periodo_cant) ? $r->periodo_cant.' '.$r->periodo_tipo.'/s ~ ' : '';
        $temp.= !empty($r->pax) ? 'pax: '.$r->pax : '';
        $r->detalle = $temp;
        
       return $r;
    }
    
    
    public function _listview_alt_values($result)
    {   
        $temp = array();
        foreach($result['data'] as $r)
        {            
            // formato a string de columna recibido
            $r = $this->_string_time_recibido($r);
            // asigna icono a col recibido
            $r = $this->_icono_time_recibido($r);
            // lista servicios txt
            $r = $this->_string_servicio($r);
            //fecha estimada
            $r = $this->_string_fecha_estimada($r);
            //horario estimado
            $r = $this->_string_horario_estimado($r);
            // genera string detalle del pedido
            $r = $this->_string_detalle($r);
            // guarda registro actualizado en nuevo vector $temp            
            array_push($temp,$r);
        }        
        $result['data'] = $temp;
        return $result['data'];
    }
    
    public function _gen_alt_values($values)
    {
        // consulta valor nombre(texto) del usuario
        $id_user = $this->usuario_model->getId($values->id_user);
        $vec['id_user'] = $id_user->nombre.' '.$id_user->apellido;
        $vec['pre_nomapel'] = $values->nombre.' '.$values->apellido;
        $vec['pre_tel'] = $values->telefono.' / '.$values->movil;
        //ubicación
        $pais = $this->geo_model->getPais($values->pais);
        $ciudad = $this->geo_model->getCiudad($values->ciudad);
        $vec['pre_ubicacion'] = $ciudad['City'].' - '.$pais['Country'];
        
        
        return $vec;
        
    }    
    
    // GENERA LOS VALORES <OPTION> DE LOS SELECT
    public function _form_items_options($values,$view){
        // fecha estimada
        $form_opt['fecha_estimada'] = array(''=>'Seleccione...','exacto'=>'Fecha exacta','estimado'=>'Fecha estimada','mes'=>'Mes estimado','lista'=>'Lista de fechas');    
        
        
        switch($view)
        {
           case 'verid':    
                            break;
                          
           case 'editid':     
                            break;

           case 'add':      
                            break;
        }
        return $form_opt;
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
        //opciones de los dropdown
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

    /** Definición de los items del form
     * @return array array de array(index_name,label,input_name,input_id,input_type,js,mode)
     */
    public function _form_items(){
        
        //func params  array(index_name,label,input_name,input_id,input_type,js,mode)
        //$form_item[] = array('','','','','','','');
        //contacto
        $form_item[] = array('pre_nomapel','Nombre','nombre','nombre','text','','');
        $form_item[] = array('pre_tel','Teléfono','telefono','telefono','text','','');
        $form_item[] = array('email','Email','email','email','text','','');
        $form_item[] = array('empresa','Empresa','empresa','empresa','text','','');
        $form_item[] = array('pre_ubicacion','Ciudad/Pais','pais','paisDrop','text','','');
        $form_item[] = array('cond_com', 'Condicion comercial', 'condicion_comercial', 'condicion_comercial', 'text','','');
        $form_item[] = array('origen','Contactó por','origen','origen','text','','');
        $form_item[] = array('contacto','Encontró por','contacto','contacto','text','','');
        
        //solicitud
        $form_item[] = array('cod','Codigo','codigo','codigo','text','','');
        $form_item[] = array('interes','Interes','interes','interes','text','','');
        $form_item[] = array('fecha_estimada','Fecha Estimada','fecha_estimada','fecha_estimada','text','','');
        $form_item[] = array('fecha_uso','Fecha desde','fecha_uso','fecha_uso','text','','');
        $form_item[] = array('fecha_hasta','Fecha hasta','fecha_hasta','fecha_hasta','text','','');
        $form_item[] = array('horario_estimado','Horario estimado','horario_estimado','horario_estimado','text','','');
        $form_item[] = array('hora_in','Hora desde','hora_in','hora_in','text','','');
        $form_item[] = array('hora_out','Hora hasta','hora_out','hora_out','text','','');
        $form_item[] = array('duracion','Duracion','duracion','duracion','text','','');
        $form_item[] = array('periodo_tipo','Periodo','periodo','periodo','text','','');
        $form_item[] = array('periodo_cant','Periodo (cantidad)','periodo_cant','periodo_cant','text','','');
        $form_item[] = array('dia_semana','dia/s (semana)','dia_semana','dia_semana','text','','');
        $form_item[] = array('pax','Pax','pax','pax','text','','');
        $form_item[] = array('equipamiento','equipamiento','equipamiento','equipamiento','text','','');
        $form_item[] = array('fecha_registro','Fecha registro','fecha_registro','fecha_registro','text','','readonly');
        $form_item[] = array('id_user','Registrado por','id_user','id_user','text','','readonly');
              
        return $form_item;
        
    }    
    
//    // MASTER METHODS - PAGES ------------------------------------------------------------------------------------
    
    //pagina listado de pendientes
    public function pendiente()
    { 
//        // Benchmark
//        if(ENVIRONMENT == 'dev'){
//            $this->output->enable_profiler(TRUE);
//        }
        // end benchmark
        $this->session->unset_userdata('keysearch');
        $this->load->helper(array('form','date','pagination'));
        $tpl = init_tmpl($this->page_name);
        $meta = $this->_init_meta();
        //definicion layout (opciones: hideboth / hidecol1 / hidecol2)
        $tpl['body_class'] = "hideboth";
        $tpl = array_merge($tpl,$meta);               
        $result = $this->presupuesto_model->getFrom($this->config->item('per_page'),$this->uri->segment(3));
        if(count($result['data'])>0)
        {
            //$data['rows'] = $result['data'];
            $data['rows'] = $this->_listview_alt_values($result);
            //pagination         
            $end_url = 'presupuesto/pendiente';
            $data['total_rows'] = $result['total'];
            $config = init_pagination($end_url,$data['total_rows']);     
            $this->pagination->initialize($config);        
            $data['links']=$this->pagination->create_links();
        }else
            {
                $data['rows'] = '';
                $data['total_rows'] = 0;
            }
        //llama func carga template completo
        $view = 'presupuesto/pendiente';
        load_view($tpl,$data,$view);
    }
   
    public function verid($id)
    {
        //Loads
        $this->session->unset_userdata('keysearch');
        $this->load->helper(array('form','date'));         
        $this->load->model('usuario_model');
        $this->load->model('geo_model');        
        $this->load->library('form_validation');        
        //template
        $tpl = init_tmpl($this->page_name);
        $meta = $this->_init_meta();
        //definicion layout (opciones: hideboth / hidecol1 / hidecol2 / '')
        $tpl['body_class'] = "hidecol1";
        $tpl = array_merge($tpl,$meta);
        //query
        $result = $this->presupuesto_model->getIDandPRE($id);
        //check query
        if(count($result)>0)
        { 
            $data['existe']=1;
            // valores alternos a reemplazar en campos form
            $values_alt = $this->_gen_alt_values($result);
            //genera form items
            $data['items'] = $this->_init_form_items($result,$values_alt,'verid');
            //grupos de fieldset // array('titulo_fieldset',indice_final)
            $data['fieldset'] = array('pre'=>array('Datos Precontacto',7),
                                      'solic'=>array('Datos Solicitud',13), 
                                      'log'=>array('Registro',1) );
        }else
            {
                $data[]='';
            }
        //llama func carga template completo
        $view = 'presupuesto/verid';
        load_view($tpl,$data,$view);
        
    }
   
}


/* End of file presupuesto.php */
/* Location: ./application/controllers/presupuesto.php */
