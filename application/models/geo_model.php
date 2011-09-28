<?php

class Geo_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
        $this->tpaises = 'geo_country';
        $this->tciudades = 'geo_city';
        $this->tregion = 'geo_region';
    }
    
    //Consulta listado paises
    function getPaises()
    {
        $q = $this->db->query('SELECT CountryID, Country FROM '.$this->tpaises.' ORDER BY Country ASC');
        if($q->num_rows()>0)
        {
            foreach ($q->result_array() as $row)
            {
                $data[$row['CountryID']] = $row['Country'];
            }
            return $data;
        }        
    }
    
    //Consulta listado ciudades por Pais
    function getCiudadesXpais($id)
    {
        if(is_numeric($id))
        {
            $q = $this->db->query('SELECT CityId, City FROM '.$this->tciudades.' WHERE CountryId = '.$id.' ORDER BY City ASC');
                if($q->num_rows()>0)
                {
                    foreach ($q->result_array() as $row)
                    {
                        //array [id][texto]
                        $data[$row['CityId']] = $row['City'];
                    }
                    return $data;
                }
        }else
            {
                $data[]='';
                return $data;
            }
    }

    //Consulta nombre ciudad (id, nombre)
    function getCiudadID($id)
    {
        if(is_numeric($id))
        {        
            $q = $this->db->get_where($this->tciudades,array('CityId'=>$id));
            if($q->num_rows()>0)
            {
                foreach ($q->result_array() as $row)
                {
                    $data[$row['CityId']] = $row['City'];
                }
                return $data;
            }
        }else
            {
                $data[]='';
                return $data;
            }
    }     
    
    //Consulta region x ciudad
    function getRegionID($id)
    {
        if(is_numeric($id))
        {        
            $q = $this->db->get_where($this->tregion,array('RegionID'=>$id));
            if($q->num_rows()>0)
            {
                foreach ($q->result_array() as $row)
                {
                    $data[$row['RegionID']] = $row['Region'];
                }
                return $data;
            }else{
                    return 'none';
                 }        
        }else
            {
                $data[]='';
                return $data;
            }         
    }  

    //Consulta datos completos de ciudad
    function getCiudad($id)
    {
        $q = $this->db->get_where($this->tciudades,array('CityId'=>$id));
        if($q->num_rows()>0)
        {
            foreach ($q->result_array() as $row)
            {
                $data = $row;
            }
            return $data;
        }        
    }    
    
    //Consulta datos completos de pais
    function getPais($id)
    {
        $q = $this->db->get_where($this->tpaises,array('CountryId'=>$id));
        if($q->num_rows()>0)
        {
            foreach ($q->result_array() as $row)
            {
                $data = $row;
            }
            return $data;
        }        
    }     

// METODOS PARA RESPUESTAS AJAX -----------------------------------------------      
    
    function getCiudadesAjax($id)
    {
            if($id)
            {
                $q = $this->db->query('SELECT CityId, City FROM '.$this->tciudades.' WHERE CountryId = '.$id.' ORDER BY City ASC');
                if ($q->num_rows() > 0)
                {
                    return $q->result();
                }else
                    {
                        return 'No match';
                    }
            } else return 'none';
    }

    //Consulta region x ciudad
    function getRegionAjax($id)
    {
            if($id)
            {
                $q = $this->db->query('SELECT * FROM '.$this->tregion.' WHERE RegionId = '.$id);
                if ($q->num_rows() > 0)
                {
                    return $q->result();
                }else
                    {
                        return 'No match';
                    }
            } else return 'none';
    }     
    
}
/* End of file precontacto_model.php */
/* Location: ./application/models/precontacto_model.php */
