<?
//init form
$form_js = array('class'=>'yform columnar','id'=>'yform','role'=>'application');

$btnVolverSearch = array(
    'type'        => 'reset',    
    'name'        => 'volver',
    'id'          => 'volver',
    'value'       => 'Volver resultados busqueda',
    'onclick'     =>  $btn_volver_search_js    
    );

$btnVolver = array(
    'name'        => 'volver',
    'type'        => 'button',
    'id'          => 'volver',
    'value'       => 'Cancelar',
    'onclick'     => $btn_volver_js    
    );

$btnGuardar = array(
    'type'        => 'submit',    
    'name'        => 'guardar',
    'id'          => 'guardar',
    'value'       => 'Guardar',
    );

?>
<script type="text/javascript">

//carga lista de ciudades en select ciudadDrop
$(document).ready(function(){       
        $('#paisDrop').change(function() {         
                var form_data = {
                    paisid : $('#paisDrop').val(),                       
                    ci_csrf_token : $.cookie('ci_csrf_token')
                };
                if($('#paisDrop').val()>0){
                    // oculta el SELECT ciudad
                    $('#ciudadDrop').hide();
                    //añade antes del SELECT el gif    
                    $('#ciudadDrop').before('<img src="<?=$path ?>images/loader.gif" style="float:left; margin-top:7px;" id="loader" alt="" /></div>');                     
                    $.ajax({
                            type: "POST",
                            url: "<?=$base_url_page ?>/getCiudadesAjax/",
                            data: form_data, 
                            dataType: 'json',
                            success: function(ciudades){
                                    // quita el GIF
                                    $('#loader').remove();
                                    // quita el atributo STYLE del SELECT
                                    $('#ciudadDrop').show();                       
                                    $('#ciudadDrop').empty();
                                    $('#provinciaDrop').empty();
                                    var options = '<option value="">' + 'Seleccione Ciudad' + '</option>';
                                    for (var i = 0; i < ciudades.length; i++) {
                                                    options += '<option value="' + ciudades[i].CityId + '">' + ciudades[i].City + '</option>';
                                            }
                                    $("select#ciudadDrop").html(options);
                                    }
                            });
                 }else
                    {
                        $('#ciudadDrop').empty();
                        $('#provinciaDrop').empty(); 
                    }               
          });
});

//carga REGION en regiondrop
$(document).ready(function(){   
        $('#ciudadDrop').change(function() {
            var form_data = {
                cityid : $('#ciudadDrop').val(),                       
                ci_csrf_token : $.cookie('ci_csrf_token')
            };
            if($('#ciudadDrop').val()>0){
                $.ajax({
                        type: "POST",
                        url: "<?=$base_url_page ?>/getRegionAjax/",
                        data: form_data,
                        dataType: 'json',
                        success: function(region){
                                $('#provinciaDrop').empty();
                                var options = '';
                                for (var i = 0; i < region.length; i++) 
                                {
                                        options += '<option value="' + region[i].RegionID + '" selected="selected">' + region[i].Region + '</option>';
                                }
                                options+= '<option value="err"><--- Region, estado o provincia incorrecto, click para BORRAR ---></option>';
                                $("#provinciaDrop").html(options);
                                }
                        });
             }
         });

});

// carga valores err, para permitir borrar si no corresponde region->ciudad
$(document).ready(function(){   
        $('#provinciaDrop').change(function() {
            if($('#provinciaDrop option:selected').val()=='err')
            {
                $('#provinciaDrop').empty();
                var options = '<options value=""></options>';
                $('#provinciaDrop').html(options);
            }
     	});
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
                <?=validation_errors('<div class="warning">','</div>') ?>
                <?if(isset($existe)): ?>
                <?= form_open('precontacto/updateId',$form_js); ?>                
                    <div class="type-button">
                      <?if($this->session->userdata('keysearch')){echo form_submit($btnVolverSearch);}?>                        
                      <?=form_submit($btnVolver) ?>
                      <?=form_submit($btnGuardar) ?>                        
                    </div>
                <?=form_hidden('id',$h_items['id']);?>                        
                    <? foreach ($fieldsets as $fs): ?>
                        <fieldset>
                        <legend><code><?=$fs[0] ?></code></legend> 
                        <? for($i=0;$i<=$fs[1];$i++):?>
                                <? $r = array_shift($items) ?>
                                <div class="<?=input_style($r[3]) ?>">
                                    <?=form_label($r[0], $r[1]) ?>
                                    <?=display_form_field($r); ?>                               
                                </div>
                        <? endfor ?>
                        </fieldset>
                    <? endforeach ?> 
                    <fieldset>                        
                    <div class="type-button">
                      <?if($this->session->userdata('keysearch')){echo form_submit($btnVolverSearch);}?>                        
                      <?=form_submit($btnVolver) ?>
                      <?=form_submit($btnGuardar) ?>                        
                    </div>
                    </fieldset>      
                    <?= form_close(); ?>
                <?else: ?>
                <div align="center" class="warning">El registro ya no existe.</div>
                <?endif; ?>          
            </div>
        <!-- IE Column Clearing -->
        <div id="ie_clearing">&nbsp;</div>
    </div>
    <!-- end: #col3 -->      
</div>
<!-- end: #main -->
        
<?php

/* End of file verid.php */
/* Location: ./application/views/precontacto/verid.php */