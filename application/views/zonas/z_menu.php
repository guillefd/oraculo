<?
//URL segment
$current = $this->uri->rsegment(1);

?>
<ul id="nav" class="dropdown dropdown-horizontal">
    <li><a href="<?= base_url() ?>precontacto" class="dir<?=is_menu_active('precontacto',$current) ?>">Precontactos</a>
		<ul>
                    <li><a href="<?= base_url() ?>precontacto/add">Nuevo</a></li>
                    <li><a href="<?= base_url() ?>precontacto/listado">Listado</a></li>
		    <li class="divider last"><a href="./">Nuevo + Pedido</a></li>                    
		</ul>
	</li>
	<li><a href="<?= base_url() ?>presupuesto" class="dir<?=is_menu_active('presupuesto',$current) ?>">Presupuestos</a>
		<ul>
			<li><a href="<?= base_url() ?>presupuesto/add">Nuevo pedido</a></li>                        
                        <li><a href="<?= base_url() ?>presupuesto/pendiente">Pendientes de envio</a></li>
			<li><a href="<?= base_url() ?>presupuesto/seguimiento">Seguimiento</a></li>                                                
			<li class="divider last"><a href="./">More...</a></li>
		</ul>
	</li>
	<li><span class="dir">Seguimientos</span>
		<ul>
			<li><a href="./">Listado</a></li>
                        <li class="divider last"><a href="./">More...</a></li>
		</ul>
	</li>
        <li><span class="dir">Item demo</span>
                        <ul>
                                <li><a href="./" class="dir">New</a>
                                        <ul>
                                                <li><a href="./">Corporate Use</a></li>
                                                <li><a href="./">Private Use</a></li>
                                        </ul>
                                </li>
                                <li><a href="./" class="dir">Used</a>
                                        <ul>
                                                <li><a href="./">Corporate Use</a></li>
                                                <li><a href="./">Private Use</a></li>
                                        </ul>
                                </li>
                                <li><a href="./">Featured</a></li>
                                <li><a href="./">Top Rated</a></li>
                                <li><a href="./">Prices</a></li>
                                <li class="divider"><a href="./">More...</a></li>
                        </ul>
         </li>
</ul>    
    
    
<?php

/* End of file XXX.php */
/* Location: ./application/controllers/XXX.php */
