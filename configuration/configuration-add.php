<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$elp_errors = array();
$elp_success = '';
$elp_error_found = FALSE;

// Preset the form fields
$form = array(
	'elp_set_name' => '',
	'elp_set_templid' => '',
	'elp_set_totalsent' => '',
	'elp_set_unsubscribelink' => '',
	'elp_set_viewstatus' => '',
	'elp_set_postcount' => '',
	'elp_set_postcategory' => '',
	'elp_set_postorderby' => '',
	'elp_set_postorder' => ''
);

// Form submitted, check the data
if (isset($_POST['elp_form_submit']) && $_POST['elp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('elp_form_add');
	
	$form['elp_set_name'] = isset($_POST['elp_set_name']) ? $_POST['elp_set_name'] : '';
	if ($form['elp_set_name'] == '')
	{
		$elp_errors[] = __('Please enter mail subject.', ELP_TDOMAIN);
		$elp_error_found = TRUE;
	}
	$form['elp_set_templid'] = isset($_POST['elp_set_templid']) ? $_POST['elp_set_templid'] : '';
	$form['elp_set_totalsent'] = isset($_POST['elp_set_totalsent']) ? $_POST['elp_set_totalsent'] : '';
	$form['elp_set_unsubscribelink'] = isset($_POST['elp_set_unsubscribelink']) ? $_POST['elp_set_unsubscribelink'] : '';
	$form['elp_set_viewstatus'] = isset($_POST['elp_set_viewstatus']) ? $_POST['elp_set_viewstatus'] : '';
	
	$form['elp_set_postcount'] = isset($_POST['elp_set_postcount']) ? $_POST['elp_set_postcount'] : '';
	$form['elp_set_postcategory'] = isset($_POST['elp_set_postcategory']) ? $_POST['elp_set_postcategory'] : '';
	$form['elp_set_postorderby'] = isset($_POST['elp_set_viewstatus']) ? $_POST['elp_set_postorderby'] : '';
	$form['elp_set_postorder'] = isset($_POST['elp_set_postorder']) ? $_POST['elp_set_postorder'] : '';
	
	//	No errors found, we can add this Group to the table
	if ($elp_error_found == FALSE)
	{
		$inputdata = array($form['elp_set_name'], $form['elp_set_templid'], $form['elp_set_totalsent'], $form['elp_set_unsubscribelink'], 
						 	$form['elp_set_viewstatus'],$form['elp_set_postcount'], $form['elp_set_postcategory'],$form['elp_set_postorderby'], $form['elp_set_postorder']);
		$action = elp_cls_dbquery::elp_configuration_ins("insert", $inputdata);
		if($action)
		{
			$elp_success = __('Mail configuration was successfully created.', ELP_TDOMAIN);
		}
			
		// Reset the form fields
		$form = array(
			'elp_set_name' => '',
			'elp_set_templid' => '',
			'elp_set_totalsent' => '',
			'elp_set_unsubscribelink' => '',
			'elp_set_viewstatus' => '',
			'elp_set_postcount' => '',
			'elp_set_postcategory' => '',
			'elp_set_postorderby' => '',
			'elp_set_postorder' => ''
		);
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
if ($elp_error_found == FALSE && isset($elp_success[0]) == TRUE)
{
	?>
	  <div class="updated fade">
		<p>
		<strong>
		<?php echo $elp_success; ?>
		<a href="<?php echo ELP_ADMINURL; ?>?page=elp-configuration">
		<?php _e('Click here', ELP_TDOMAIN); ?></a> <?php _e(' to view the details', ELP_TDOMAIN); ?>
		</strong>
		</p>
	  </div>
	  <?php
	}
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>configuration/configuration.js"></script>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
	<form name="elp_form" method="post" action="#" onsubmit="return _elp_submit()"  >
      <h3><?php _e('Add configuration', ELP_TDOMAIN); ?></h3>
      
	  <label for="tag-image"><?php _e('Mail subject', ELP_TDOMAIN); ?></label>
      <input name="elp_set_name" type="text" id="elp_set_name" value="" maxlength="225" size="30"  />
      <p><?php _e('Please enter mail subject.', ELP_TDOMAIN); ?></p>
	   
	  <label for="tag-display-status"><?php _e('Template', ELP_TDOMAIN); ?></label>
      <select name="elp_set_templid" id="elp_set_templid">
		<option value='' selected="selected">Select</option>
		<?php
		$Templates = array();
		$Templates = elp_cls_dbquery::elp_template_select(0);
		if(count($Templates) > 0)
		{
			foreach ($Templates as $Template)
			{
				?><option value='<?php echo $Template['elp_templ_id']; ?>'><?php echo $Template['elp_templ_heading']; ?></option><?php
			}
		}
		?>
	  </select>
      <p><?php _e('Please select template for this configuration.', ELP_TDOMAIN); ?></p>
	  
	  <h3><?php _e('Post Details', ELP_TDOMAIN); ?></h3>
	  <label for="tag-image"><?php _e('Post count.', ELP_TDOMAIN); ?></label>
      <select name="elp_set_postcount" id="elp_set_postcount">
	 	<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='5' selected="selected">5</option>
		<option value='7'>7</option>
		<option value='10'>10</option>
		<option value='12'>12</option>
		<option value='15'>15</option>
	  </select>
      <p><?php _e('Number of post to add in the email.', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-image"><?php _e('Post categories', ELP_TDOMAIN); ?></label>
      <input name="elp_set_postcategory" type="text" id="elp_set_postcategory" value="" maxlength="225" size="30"  />
      <p><?php _e('Please enter category IDs, separated by commas.', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-image"><?php _e('Post orderbys', ELP_TDOMAIN); ?></label>
      <select name="elp_set_postorderby" id="elp_set_postorderby">
		<option value='ID' selected="selected">ID</option>
		<option value='author'>author</option>
		<option value='title'>title</option>
		<option value='rand'>rand</option>
		<option value='date'>date</option>
		<option value='modified'>modified</option>
	  </select>
      <p><?php _e('Select your post orderbys', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-image"><?php _e('Post order', ELP_TDOMAIN); ?></label>
      <select name="elp_set_postorder" id="elp_set_postorder">
		<option value='DESC' selected="selected">DESC</option>
		<option value='ASC'>ASC</option>
	  </select>
      <p><?php _e('Select your post order', ELP_TDOMAIN); ?></p>
	  
	  
	  <h3><?php _e('Mail Setting', ELP_TDOMAIN); ?></h3>
	  
	  <label for="tag-image"><?php _e('Mail count for one shot.', ELP_TDOMAIN); ?></label>
      <select name="elp_set_totalsent" id="elp_set_totalsent">
		<option value='2'>2</option>
		<option value='25'>25</option>
		<option value='50'>50</option>
		<option value='100'>100</option>
		<option value='200' selected="selected">200</option>
		<option value='500'>500</option>
		<option value='700'>700</option>
		<option value='1000'>1000</option>
		<option value='1500'>1500</option>
		<option value='2000'>2000</option>
	  </select>
      <p><?php _e('How many emails you want to send at one shot', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-image"><?php _e('Add unsubscribe link', ELP_TDOMAIN); ?></label>
      <select name="elp_set_unsubscribelink" id="elp_set_unsubscribelink">
		<option value='YES'>YES</option>
	  </select>
      <p><?php _e('Do you want to add unsubscribe link with this mail configuration.', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-image"><?php _e('View status (BETA)', ELP_TDOMAIN); ?></label>
	  <select name="elp_set_viewstatus" id="elp_set_viewstatus">
		<option value='YES'>YES</option>
	  </select>
      <p><?php _e('Like to track whether that email is viewed or not?', ELP_TDOMAIN); ?></p>
	    
      <input type="hidden" name="elp_form_submit" value="yes"/>
	  <div style="padding-top:5px;"></div>
      <p>
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Insert Details', ELP_TDOMAIN); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_elp_redirect()" value="<?php _e('Cancel', ELP_TDOMAIN); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_elp_help()" value="<?php _e('Help', ELP_TDOMAIN); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('elp_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo ELP_OFFICIAL; ?></p>
</div>