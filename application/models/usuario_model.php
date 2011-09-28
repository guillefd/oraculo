<?php

class Usuario_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'usuarios';
    }
    // Consulta todos
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
    
    //Consulta para paginacion DESDE / CUANTOS
    function getFrom($num, $offset) {
        $q = $this->db->get($this->table, $num, $offset);	
        if($q->num_rows()>0)
        {
            foreach ($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    // CONSULTA datos x ID 
    function getId($id) {
        $q = $this->db->get_where($this->table,array('id_user'=>$id));
        if($q->num_rows()>0)
        {
            $data = $q->row();
            return $data;
        }
    }
    
    // actualiza datos de precontacto por ID
     function updateID(){
        $data = array(
                      'nombre'=>$this->input->post('nombre'),
                      'apellido'=>$this->input->post('apellido'),
                      'telefono'=>$this->input->post('telefono'),
                      'movil'=>$this->input->post('movil'),
                      'email'=>$this->input->post('email'),
                      'condicion_comercial'=>$this->input->post('condicion_comercial'),
                      'empresa'=>$this->input->post('empresa'),
                      'direccion'=>$this->input->post('direccion'),
                      'ciudad'=>$this->input->post('ciudad'),
                      'provincia'=>$this->input->post('provincia'),
                      'pais'=>$this->input->post('pais'),
                      'origen'=>$this->input->post('origen'),
                      'contacto'=>$this->input->post('contacto'),
            );
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('precontactos',$data);  
     }
     
}



/* End of file precontacto_model.php */
/* Location: ./application/models/precontacto_model.php */
