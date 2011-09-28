<?php

class Precontacto_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'precontactos';
    }
    
    function preformat_text($string)
    {
        $pre = strtolower($string);
        $pre = ucwords($pre);
        return $pre;
    }
    
    // Consulta todos los precontactos
    function getAll()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $q = $this->db->get();          
        if($q->num_rows()>0)
        {
            foreach ($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    function query_getFrom($num,$offset,$flag)
    {
        $this->db->from($this->table);
        $this->db->order_by("id", "desc"); 
        if($flag)
        {
            $this->db->limit($num, $offset);  
        }
        
    }
    
    
    //Consulta precontactos para paginacion DESDE / CUANTOS
    function getFrom($num, $offset) {
        $this->query_getFrom('', '', 0);
        //total para paginacion
        $total = $this->db->count_all_results();
        // consulta con paginacion
        $this->query_getFrom($num, $offset, 1);
        $q = $this->db->get();
        if($q->num_rows()>0)
        {
            foreach ($q->result() as $row)
            {
                $data[] = $row;
            }
            $vec['data'] = $data;
            $vec['total'] = $total;
            return $vec;
        }
    }
    
    // CONSULTA datos x ID de precontacto 
    function getId($id) {
        $q = $this->db->get_where($this->table,array('id'=>$id));
        if($q->num_rows()>0)
        {
            $data = $q->row();
            return $data;
        }
    }
    
    // actualiza datos de precontacto por ID
     function updateID(){
        
        $pais = ($this->input->post('pais')>0) ? $this->input->post('pais') : NULL;      
        $ciudad = ($this->input->post('ciudad')>0) ? $this->input->post('ciudad') : NULL;      
        $provincia = ($this->input->post('provincia')>0) ? $this->input->post('provincia') : NULL;    
        
        $data = array(
                      'nombre'=>$this->preformat_text($this->input->post('nombre')),
                      'apellido'=>$this->preformat_text($this->input->post('apellido')),
                      'telefono'=>$this->input->post('telefono'),
                      'movil'=>$this->input->post('movil'),
                      'email'=>$this->input->post('email'),
                      'condicion_comercial'=>$this->input->post('condicion_comercial'),
                      'empresa'=>$this->preformat_text($this->input->post('empresa')),
                      'direccion'=>$this->input->post('direccion'),
                      'ciudad'=>$ciudad,
                      'provincia'=>$provincia,
                      'pais'=>$pais,
                      'origen'=>$this->input->post('origen'),
                      'contacto'=>$this->input->post('contacto'),
            );
        $this->db->where('id',$this->input->post('id'));
        $this->db->update($this->table,$data);  
     }
     
     //Inserta nuevo precontacto
     
     function insert(){
         
     $pais = ($this->input->post('pais')>0) ? $this->input->post('pais') : NULL;      
     $ciudad = ($this->input->post('ciudad')>0) ? $this->input->post('ciudad') : NULL;      
     $provincia = ($this->input->post('provincia')>0) ? $this->input->post('provincia') : NULL;      
     
     $data = array(
                      'nombre'=>$this->preformat_text($this->input->post('nombre')),
                      'apellido'=>$this->preformat_text($this->input->post('apellido')),
                      'telefono'=>$this->input->post('telefono'),
                      'movil'=>$this->input->post('movil'),
                      'email'=>$this->input->post('email'),
                      'condicion_comercial'=>$this->input->post('condicion_comercial'),
                      'empresa'=>$this->preformat_text($this->input->post('empresa')),
                      'direccion'=>$this->input->post('direccion'),
                      'ciudad'=>$ciudad,
                      'provincia'=>$provincia,
                      'pais'=>$pais,
                      'origen'=>$this->input->post('origen'),
                      'contacto'=>$this->input->post('contacto'),
                      'activo'=>1,
                      'id_user'=>2
     );
     

    $this->db->insert($this->table, $data); 
    }
    
    function query_getSearchFrom($num,$offset,$key,$flag)
    {
        $this->db->from($this->table);
        $this->db->like('nombre', $key);
        $this->db->or_like('apellido', $key); 
        $this->db->or_like('email', $key);         
        $this->db->order_by("id", "desc"); 
        if($flag)
        {
            $this->db->limit($num, $offset);        
        }
    }
    
    function getSearchFrom($num,$offset,$key)
    {
        //para total paginacion
        $this->query_getSearchFrom('','',$key, 0);
        $total = $this->db->count_all_results();
        //consulta real
        $this->query_getSearchFrom($num, $offset, $key, 1);
        $q = $this->db->get();        
        if($q->num_rows()>0)
        {
            foreach ($q->result() as $row)
            {
                $data[] = $row;
            }
            $vec['data'] = $data;
            $vec['total'] = $total;
            return $vec;
        }
        
    }
     
}
/* End of file precontacto_model.php */
/* Location: ./application/models/precontacto_model.php */
