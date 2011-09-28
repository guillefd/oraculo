<?
//init form
$form_js = array('class'=>'yform columnar', 'role'=>'application');
$btn_irEdit = 
//inputs style
$input_style = array(
               'text' => 'type-text',
               'disabled' =>'type-text',
               'select' => 'type-select',
               'checkbox'=> 'type-check'
         );

$btnVolverSearch = array(
    'type'        => 'reset',    
    'name'        => 'volver',
    'id'          => 'volver',
    'value'       => 'Volver resultados busqueda',
    'onclick'     =>  $btn_volver_search_js    
    );

$btnVolver = array(
    'type'        => 'button',
    'name'        => 'volver',
    'id'          => 'volver',
    'value'       => 'Volver',
    'onclick'     =>  $btn_volver_js    
    );

$btnEdit = array(
    'type'        => 'submit',    
    'name'        => 'editar',
    'id'          => 'editar',
    'value'       => 'Editar',
    'onclick'     => "goToURL('parent','".$base_url_page."/editid/".$this->uri->segment(3)."');return document.MM_returnValue"
    );

?>

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
                <?if(isset($existe)): ?>
                <?= form_open('',$form_js); ?>
                <div class="type-button">
                  <?if($this->session->userdata('keysearch')){echo form_submit($btnVolverSearch);}?>                             
                  <?=form_submit($btnVolver) ?>
                  <?=form_submit($btnEdit) ?>                 
                </div>                
                    <? foreach ($fieldsets as $fs): ?>
                        <fieldset>
                        <legend><?=$fs[0] ?></legend> 
                        <? for($i=0;$i<=$fs[1];$i++):?>
                             <? $r = array_shift($items); ?>
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
                          <?=form_submit($btnEdit) ?>                 
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