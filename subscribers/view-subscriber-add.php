<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$elp_errors = array();
$elp_success = '';
$elp_error_found = FALSE;

// Preset the form fields
$form = array(
	'elp_email_name' => '',
	'elp_email_mail' => ''
);

// Form submitted, check the data
if (isset($_POST['elp_form_submit']) && $_POST['elp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('elp_form_add');
	
	$form['elp_email_status'] = isset($_POST['elp_email_status']) ? $_POST['elp_email_status'] : '';
	$form['elp_email_name'] = isset($_POST['elp_email_name']) ? $_POST['elp_email_name'] : '';
	$form['elp_email_mail'] = isset($_POST['elp_email_mail']) ? $_POST['elp_email_mail'] : '';
	if ($form['elp_email_mail'] == '')
	{
		$elp_errors[] = __('Please enter valid email.', ELP_TDOMAIN);
		$elp_error_found = TRUE;
	}
	
	//	No errors found, we can add this Group to the table
	if ($elp_error_found == FALSE)
	{
		$inputdata = array($form['elp_email_name'], $form['elp_email_mail'], $form['elp_email_status']);
		$action = "";
		$action = elp_cls_dbquery::elp_view_subscriber_ins($inputdata);
		if($action == "sus")
		{
			$elp_success = __('Email was successfully inserted.', ELP_TDOMAIN);
		}
		elseif($action == "ext")
		{
			$elp_errors[] = __('Email already exist in our list.', ELP_TDOMAIN);
			$elp_error_found = TRUE;
		}
		elseif($action == "invalid")
		{
			$elp_errors[] = __('Email is invalid.', ELP_TDOMAIN);
			$elp_error_found = TRUE;
		}
			
		// Reset the form fields
		$form = array(
			'elp_email_name' => '',
			'elp_email_mail' => ''
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
		<a href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers">
		<?php _e('Click here', ELP_TDOMAIN); ?></a> <?php _e(' to view the details', ELP_TDOMAIN); ?>
		</strong>
		</p>
	  </div>
	  <?php
	}
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>subscribers/view-subscriber.js"></script>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
	<form name="form_addemail" method="post" action="#" onsubmit="return _elp_addemail()"  >
      <h3 class="title"><?php _e('Add email', ELP_TDOMAIN); ?></h3>
      
	  <label for="tag-image"><?php _e('Enter full name', ELP_TDOMAIN); ?></label>
      <input name="elp_email_name" type="text" id="elp_email_name" value="" maxlength="225" size="30"  />
      <p><?php _e('Enter the name for email.', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-image"><?php _e('Enter email address.', ELP_TDOMAIN); ?></label>
      <input name="elp_email_mail" type="text" id="elp_email_mail" value="" maxlength="225" size="50" />
      <p><?php _e('Enter the email address to add in the subscribers list.', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-display-status"><?php _e('Status', ELP_TDOMAIN); ?></label>
      <select name="elp_email_status" id="elp_email_status">
        <option value='Confirmed' selected="selected">Confirmed</option>
		<option value='Unconfirmed'>Unconfirmed</option>
		<option value='Unsubscribed'>Unsubscribed</option>
		<option value='Single Opt In'>Single Opt In</option>
      </select>
      <p><?php _e('Unsubscribed, Unconfirmed emails not display in send mail page.', ELP_TDOMAIN); ?></p>
	  
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