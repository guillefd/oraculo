<? 
$meta = array(
                array('name' => 'description', 'content' => $pg_description),
                array('name' => 'keywords', 'content' => $pg_keywords),
                array('name' => 'robots', 'content' => $pg_robots),
                array('name' => 'Content-type', 'content' => $this->config->item('tpl_charset'), 'type' => 'equiv')
);

/*END init template*/
?>
<!-- START z_head -->
<title><?=$pg_title; ?></title>
<!-- META -->
<?=meta($meta); ?>
<!-- CSS TPL-->
<? foreach ($css as $value): ?>
    <?=link_tag(tpl_url()."css/".$value); ?>
<? endforeach; ?>
<!-- CSS MENU-->
<? foreach ($menu_css as $value): ?>
    <link href="<?=$menu_path ?>css/dropdown/<?=$value ?>" media="screen" rel="stylesheet" type="text/css" />
<? endforeach; ?>
<!-- CSS MENU THEME -->
<? foreach ($menu_theme_css as $value): ?>
     <link href="<?=$menu_path ?>css/dropdown/themes/<?=$menu_theme.$value ?>" media="screen" rel="stylesheet" type="text/css" />
<? endforeach; ?>  
<!-- JS TPL-->
<? foreach ($js as $value): ?>
<script type="text/javascript" src="<?=tpl_url() ?>js/<?=$value ?>"></script>
<? endforeach; ?>     
<!-- END z_head -->
<?
/* End of file head.php */
/* Location: ./application/views/z_head.php */

