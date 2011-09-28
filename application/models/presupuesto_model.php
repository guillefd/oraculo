<?php

class Presupuesto_model extends CI_model
{
    function __construct()
    {
        parent::__construct();
        $this->tableS = 'solicitudes';
        $this->tableP = 'presupuestos';
        $this->tableA = 'presupuestos_avance';
        $this->tablePre = 'precontactos';
    }

    // funcion complemento de 'getFrom'
    function _query_getFrom($num,$offset,$flag)
    {
        $this->db->select('solicitudes.id_solicitud as id_solic,
                          solicitudes.codigo as cod,
                          solicitudes.interes as interes,
                          solicitudes.fecha_estimada as fecha_estimada,
                          solicitudes.fecha_uso as fecha_uso,
                          solicitudes.fecha_hasta as fecha_hasta,
                          solicitudes.horario_estimado as horario_estimado,
                          solicitudes.horario_in as hora_in,
                          solicitudes.horario_out as hora_out,
                          solicitudes.duracion as duracion,
                          solicitudes.periodo_tipo as periodo_tipo,
                          solicitudes.periodo_cantidad as periodo_cant,
                          solicitudes.dia_semana as dia_semana,
                          solicitudes.pax as pax,
                          solicitudes.equipamiento as equipamiento,
                          solicitudes.fecha_registro as freg,
                          solicitudes.prioridad as prioridad,
                          solicitudes.id_precontacto as id_precontacto,
                          solicitudes.id_user as id_user,
                          solicitudes.fecha_registro as fecha_registro,
                          precontactos.nombre as nombre,
                          precontactos.apellido as apellido,
                          precontactos.email as email,
                          precontactos.empresa as empresa,
                          precontactos.telefono as telefono,
                          precontactos.movil as movil
                          '
                          );
        $this->db->from($this->tableS);
        $this->db->join($this->tableP,'solicitudes.id_solicitud= presupuestos.id_solicitud','left');
        $this->db->join($this->tablePre,'precontactos.id = solicitudes.id_precontacto','left');
        $this->db->where('presupuestos.id_solicitud', null);
        $this->db->order_by("solicitudes.id_solicitud", "DESC"); 
        if($flag)
        {
            $this->db->limit($num, $offset);  
        }
    }
    
    // CONSULTA SOLICITUDES
    function getFrom($num, $offset) 
    {
        $this->_query_getFrom('', '', 0);
        //total para paginacion
        $total = $this->db->count_all_results();
        // consulta con paginacion
        $this->_query_getFrom($num, $offset, 1);
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
   
    // CONSULTA datos x ID
    function getId($id) 
    {
        $q = $this->db->get_where($this->tableS,array('id_solicitud'=>$id));
        if($q->num_rows()>0)
        {
            $data = $q->row();
            return $data;
        }
    }    

    // Consulta solicitud por ID
        // CONSULTA SOLICITUDES
    function getIDandPRE($id_solicitud) 
    {
        $this->db->select('solicitudes.id_solicitud as id_solic,
                          solicitudes.codigo as cod,
                          solicitudes.interes as interes,
                          solicitudes.fecha_estimada as fecha_estimada,
                          solicitudes.fecha_uso as fecha_uso,
                          solicitudes.fecha_hasta as fecha_hasta,
                          solicitudes.horario_estimado as horario_estimado,
                          solicitudes.horario_in as hora_in,
                          solicitudes.horario_out as hora_out,
                          solicitudes.duracion as duracion,
                          solicitudes.periodo_tipo as periodo_tipo,
                          solicitudes.periodo_cantidad as periodo_cant,
                          solicitudes.dia_semana as dia_semana,
                          solicitudes.pax as pax,
                          solicitudes.equipamiento as equipamiento,
                          solicitudes.prioridad as prioridad,
                          solicitudes.id_precontacto as id_precontacto,
                          solicitudes.id_user as id_user,
                          solicitudes.fecha_registro as fecha_registro,
                          precontactos.nombre as nombre,
                          precontactos.apellido as apellido,
                          precontactos.email as email,
                          precontactos.empresa as empresa,
                          precontactos.telefono as telefono,
                          precontactos.movil as movil,
                          precontactos.pais as pais,
                          precontactos.ciudad as ciudad,
                          precontactos.origen as origen,
                          precontactos.contacto as contacto,
                          precontactos.condicion_comercial as cond_com
                          '
                          );
        $this->db->from($this->tableS);
        $this->db->join($this->tablePre,'precontactos.id = solicitudes.id_precontacto','left');
        $this->db->where('solicitudes.id_solicitud', $id_solicitud);  
        $q = $this->db->get();
        if($q->num_rows()>0)
        {
            $data = $q->row();
            return $data;
        }
    }  
    
}

/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
