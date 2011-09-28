<?
//boton reset
$searchVal = ($this->session->userdata('keysearch')) ? $this->session->userdata('keysearch') : '';

//init form
$form_js = array('class'=>'yformsearch','id'=>'yform','role'=>'application');

$input = array(
    'name'        => 'keysearch',
    'id'          => 'keysearch',
    'value'       => $searchVal,
    'class'       => 'type-text',
    );

$btnBuscar = array(
    'name'        => 'buscar',
    'id'          => 'buscar',
    'value'       => 'Buscar',
    'class'       => 'type-button',
    );

$btnReset = array(
    'name'        => 'reset',
    'id'          => 'reset',
    'value'       => 'Reset',
    'class'       => 'type-button-red',
    'onclick'     =>  $btn_volver_js
    
    );
?>

<script>
//zebra style in rows    
$(document).ready(function(){
   $(".zebra tr:even").addClass("alt");
   $(".zebra th.sub:even").addClass("alt");
 });

//Redirecciona a pagina VERID
function verId(url)
{
    window.location.assign(url)
}

//background color on hover
$(function()
{
    $("#tabla1 tr").click(function() {$(this).toggleClass("trover");}); 
});

//oculta mensaje del sistema
$(document).ready(function(){   
        if($('#sysmsg')){
            var t= setTimeout("$('#sysmsg').fadeOut(2000)",5000);   
        }
});

//Cambia color bg form search si tiene texto
$(document).ready(function(){   
        if($('#keysearch').val()){
            $('#yform').css('background','#feebec');
        }
});

</script>

<!-- begin: main content area #main -->
    <div id="main">
    <!-- begin: #col1 - first float column -->
        <div id="col1" role="complementary">
            <div id="col1_content" class="clearfix">
            <!-- contenido COL1 aqui -->
            </div>
        </div>
    <!-- end: #col1 -->
    <!-- begin: #col2 second float column -->
        <div id="col2" role="complementary">
            <div id="col2_content" class="clearfix">
            <!-- contenido COL2 aqui -->
            </div>
        </div>
    <!-- end: #col2 -->        
    <!-- begin: #col3 static column -->
        <div id="col3" role="main">
            <div id="col3_content" class="clearfix">
                  <?=form_open('presupuesto/search',$form_js); ?>
                  <?=form_input($input) ?>
                  <?=form_submit($btnBuscar) ?>
                  <?if($this->session->userdata('keysearch')){echo form_submit($btnReset);}?>
                  <?= form_close(); ?>
                  <?=sysmsg() ?>
                  <?if($total_rows>0) : ?> 
                          <table border="0" cellpadding="0" cellspacing="0" class="full zebra" id="tabla1">
                          <caption>PRESUPUESTOS</caption>
                          <thead>
                            <tr><th scope="col" colspan="9">PENDIENTES DE ENVIO</th></tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="col">&nbsp;</th>  
                              <th scope="col">Recibido</th>
                              <th scope="col">Precontacto</th>
                              <th scope="col">Codigo</th>
                              <th scope="col">Interes</th>
                              <th scope="col">Fecha uso</th>
                              <th scope="col">Horario</th>
                              <th scope="col">Detalle</th>
                              <th scope="col">Accion</th>
                            </tr>
                            <? foreach ($rows as $r) : ?>  
                            <tr onclick="verId('<?=$base_url_page ?>/verid/<?=$r->id_solic ?>')">
                              <td><img src="<?=tpl_url_ico() ?><?=$r->esperaIcono ?>" title="<?=$r->esperaIconotxt ?>" /></td>  
                              <td><?=$r->esperaT ?></td>
                              <td><?=$r->nombre.' '.$r->apellido ?><?if(!empty($r->empresa)){ echo ' ('.$r->empresa.')'; } ?></td>
                              <td># <?=$r->cod ?></td>
                              <td><?=$r->interestxt ?></td>
                              <td><?=$r->fecha_txt ?></td>
                              <td><?=$r->horario_txt ?></td>
                              <td><?=$r->detalle ?></td>
                              <td>
                                <a href="<?=$base_url_page ?>/verid/<?=$r->id_solic ?>"><img src="<?=tpl_url_ico() ?><?=$icono_ver ?>" title="Ver solicitud" />
                                <a href="<?=$base_url_page ?>/editid/<?=$r->id_solic ?>"><img src="<?=tpl_url_ico() ?><?=$icono_edit ?>" title="Editar solicitud" />        
                              </td>
                            </tr>
                            <? endforeach; ?>
                          </tbody>
                        </table>
                <? else: ?>
                <div align="center" class="syswarning"><?=$this->lang->line('presus_pendiente_vacio') ?></div>                
                <?endif; ?>
                <?= $links; ?>
            </div>
        <!-- IE Column Clearing -->
        <div id="ie_clearing">&nbsp;</div>
    </div>
    <!-- end: #col3 -->                
    </div>
    <!-- end: #main -->
<?php

/* End of file listado.php */
/* Location: ./application/views/presupuesto/pendiente.php */
