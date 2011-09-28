<?=doctype($this->config->item('tpl_doctype')); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?= $z_head ?> 
</head>
<body <? if(!empty($body_class)){ echo 'class="'.$body_class.'"';}?>> 
<!-- START MAIN 1.0 -->
<div class="page_margins">
  <div class="page">
   <?= $z_header ?>
   <?= $z_menu ?>       
   <?= $z_content ?>
   <?= $z_footer ?>      
   </div>
</div>
<!-- END MAIN 1.0 -->
<!-- full skiplink functionality in webkit browsers -->
<script src="<?=$path ?>yaml/core/js/yaml-focusfix.js" type="text/javascript"></script>
</body>
</html>



<?php

/* End of file template.php */
/* Location: ./application/views/template.php */