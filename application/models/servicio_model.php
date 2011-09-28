<?php

class Servicio_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'lista_servicios';
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
        $q = $this->db->get_where($this->table,array('id'=>$id));
        if($q->num_rows()>0)
        {
            $data = $q->row_array();
            return $data;
        }
    }
    
     
}



/* End of file precontacto_model.php */
/* Location: ./application/models/precontacto_model.php */
