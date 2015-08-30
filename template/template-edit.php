<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$result = elp_cls_dbquery::elp_template_count($did);
if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', ELP_TDOMAIN); ?></strong></p></div><?php
}
else
{
	$elp_errors = array();
	$elp_success = '';
	$elp_error_found = FALSE;
	
	$data = array();
	$data = elp_cls_dbquery::elp_template_select($did);
	
	// Preset the form fields
	$form = array(
		'elp_templ_heading' => $data['elp_templ_heading'],
		'elp_templ_header' => $data['elp_templ_header'],
		'elp_templ_body' => $data['elp_templ_body'],
		'elp_templ_footer' => $data['elp_templ_footer'],
		'elp_templ_status' => $data['elp_templ_status']
	);
}
// Form submitted, check the data
if (isset($_POST['elp_form_submit']) && $_POST['elp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('elp_form_edit');
	
	$form['elp_templ_heading'] = isset($_POST['elp_templ_heading']) ? $_POST['elp_templ_heading'] : '';
	if ($form['elp_templ_heading'] == '')
	{
		$elp_errors[] = __('Please enter template heading.', ELP_TDOMAIN);
		$elp_error_found = TRUE;
	}

	$form['elp_templ_header'] = isset($_POST['elp_templ_header']) ? $_POST['elp_templ_header'] : '';
	$form['elp_templ_body'] = isset($_POST['elp_templ_body']) ? $_POST['elp_templ_body'] : '';
	$form['elp_templ_footer'] = isset($_POST['elp_templ_footer']) ? $_POST['elp_templ_footer'] : '';

	//	No errors found, we can add this Group to the table
	if ($elp_error_found == FALSE)
	{	
		$inputdata = array($did, $form['elp_templ_heading'], $form['elp_templ_header'], $form['elp_templ_body'], $form['elp_templ_footer']);
		$action = "";
		$action = elp_cls_dbquery::elp_template_upd($inputdata);
		if($action == "sus")
		{
			$elp_success = __('Template was successfully updated.', ELP_TDOMAIN);
		}
	}
}

if ($elp_error_found == TRUE && isset($elp_errors[0]) == TRUE)
{
	?>
		<div class="error fade">
			<p><strong><?php echo $elp_errors[0]; ?></strong></p>
		</div>
	<?php
}
if ($elp_error_found == FALSE && strlen($elp_success) > 0)
{
	?>
	<div class="updated fade">
		<p>
			<strong>
				<?php echo $elp_success; ?> 
				<a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=elp-email-template"><?php _e('Click here', ELP_TDOMAIN); ?></a>
				<?php _e(' to view the details', ELP_TDOMAIN); ?>
			</strong>
		</p>
	</div>
	<?php
}
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>template/template.js"></script>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
	<h3><?php _e('Edit Template', ELP_TDOMAIN); ?></h3>
	<form name="elp_form" method="post" action="#" onsubmit="return _elp_submit()"  >
      
	  <label for="tag-link"><?php _e('Enter template heading.', ELP_TDOMAIN); ?></label>
      <input name="elp_templ_heading" type="text" id="elp_templ_heading" value="<?php echo stripslashes($form['elp_templ_heading']); ?>" size="50" maxlength="225" />
      <p><?php _e('Please enter your email subject.', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-link"><?php _e('Template header', ELP_TDOMAIN); ?></label>
	  <?php $settings_header = array( 'textarea_rows' => 5 ); ?>
      <?php wp_editor(stripslashes($form['elp_templ_header']), "elp_templ_header", $settings_header);?>
      <p><?php _e('Please create header portion for your template.', ELP_TDOMAIN); ?> Keywords: ###NAME###, ###EMAIL###</p>
	  
	  <label for="tag-link"><?php _e('Template body', ELP_TDOMAIN); ?></label>
	  <?php $settings_body = array( 'textarea_rows' => 10 ); ?>
      <?php wp_editor(stripslashes($form['elp_templ_body']), "elp_templ_body", $settings_body);?>
      <p><?php _e('Please create body portion for your template.', ELP_TDOMAIN); ?>
	  Keywords: ###POSTTITLE###, ###POSTIMAGE###, ###POSTDESC###, ###EMAIL###, ###DATE###, ###AUTHOR###, ###POSTFULL###</p>
	  
	  <label for="tag-link"><?php _e('Template footer', ELP_TDOMAIN); ?></label>
	  <?php $settings_footer = array( 'textarea_rows' => 4 ); ?>
      <?php wp_editor(stripslashes($form['elp_templ_footer']), "elp_templ_footer", $settings_footer);?>
      <p><?php _e('Please create footer portion for your template.', ELP_TDOMAIN); ?> Keywords: ###NAME###, ###EMAIL###</p>

      <input type="hidden" name="elp_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Update Details', ELP_TDOMAIN); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_elp_redirect()" value="<?php _e('Cancel', ELP_TDOMAIN); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_elp_help()" value="<?php _e('Help', ELP_TDOMAIN); ?>" type="button" />
      </p>
	  
	  <?php wp_nonce_field('elp_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo ELP_OFFICIAL; ?></p>
</div>