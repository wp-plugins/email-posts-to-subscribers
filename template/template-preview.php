<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$result = elp_cls_dbquery::elp_template_count($did);
if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', ELP_TDOMAIN); ?></strong></p></div><?php
}
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>template/template.js"></script>
<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
	<h3><?php _e('Preview Template', ELP_TDOMAIN); ?></h3>
    <div class="tool-box">
	<div style="padding:15px;background-color:#FFFFFF;">
	<?php
		$preview = elp_cls_newsletter::elp_template_compose($did, 6, "", "ID", "DESC", "preview");
		echo $preview;
	?>
	</div>
	<div class="tablenav">
	  <h2>
		<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-email-template"><?php _e('Back', ELP_TDOMAIN); ?></a>
		<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-email-template&ac=edit&did=<?php echo $did; ?>"><?php _e('Edit', ELP_TDOMAIN); ?></a>
		<a class="button add-new-h2" target="_blank" href="<?php echo ELP_FAV; ?>"><?php _e('Help', ELP_TDOMAIN); ?></a>
	  </h2>
	</div>
	<div style="height:10px;"></div>
	<p class="description"><?php echo ELP_OFFICIAL; ?></p>
	</div>
</div>