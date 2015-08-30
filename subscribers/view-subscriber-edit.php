<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';
$search = isset($_GET['search']) ? $_GET['search'] : 'A,B,C';
$sts = isset($_GET['sts']) ? $_GET['sts'] : '';
$cnt = isset($_GET['cnt']) ? $_GET['cnt'] : '1';

if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
if(!is_numeric($cnt)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$result = elp_cls_dbquery::elp_view_subscriber_count($did);
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
	$data = elp_cls_dbquery::elp_view_subscriber_search("", $did);
	
	// Preset the form fields
	$form = array(
		'elp_email_name' => $data[0]['elp_email_name'],
		'elp_email_mail' => $data[0]['elp_email_mail'],
		'elp_email_status' => $data[0]['elp_email_status']
	);
}
// Form submitted, check the data
if (isset($_POST['elp_form_submit']) && $_POST['elp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('elp_form_edit');
	
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
		$inputdata = array($did, $form['elp_email_name'], $form['elp_email_mail'], $form['elp_email_status']);
		$action = "";
		$action = elp_cls_dbquery::elp_view_subscriber_upd($inputdata);
		if($action == "sus")
		{
			$elp_success = __('Email was successfully updated.', ELP_TDOMAIN);
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
		<p><strong><?php echo $elp_success; ?> 
		<a href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers&search=<?php echo $search; ?>&sts=<?php echo $sts; ?>&cnt=<?php echo $cnt; ?>">
		<?php _e('Click here', ELP_TDOMAIN); ?></a> <?php _e(' to view the details', ELP_TDOMAIN); ?></strong></p>
	</div>
	<?php
}
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>subscribers/view-subscriber.js"></script>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
	<form name="form_addemail" method="post" action="#" onsubmit="return _elp_addemail()"  >
      <h3 class="title"><?php _e('Edit email', ELP_TDOMAIN); ?></h3>
      
	  <label for="tag-image"><?php _e('Enter full name', ELP_TDOMAIN); ?></label>
      <input name="elp_email_name" type="text" id="elp_email_name" value="<?php echo $form['elp_email_name']; ?>" maxlength="225" size="30"  />
      <p><?php _e('Enter the name for email.', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-image"><?php _e('Enter email address.', ELP_TDOMAIN); ?></label>
      <input name="elp_email_mail" type="text" id="elp_email_mail" value="<?php echo $form['elp_email_mail']; ?>" maxlength="225" size="50" />
      <p><?php _e('Enter the email address to add in the subscribers list.', ELP_TDOMAIN); ?></p>
	  
	  <label for="tag-display-status"><?php _e('Status', ELP_TDOMAIN); ?></label>
      <select name="elp_email_status" id="elp_email_status">
        <option value='Confirmed' <?php if($form['elp_email_status']=='Confirmed') { echo 'selected="selected"' ; } ?>>Confirmed</option>
		<option value='Unconfirmed' <?php if($form['elp_email_status']=='Unconfirmed') { echo 'selected="selected"' ; } ?>>Unconfirmed</option>
		<option value='Unsubscribed' <?php if($form['elp_email_status']=='Unsubscribed') { echo 'selected="selected"' ; } ?>>Unsubscribed</option>
		<option value='Single Opt In' <?php if($form['elp_email_status']=='Single Opt In') { echo 'selected="selected"' ; } ?>>Single Opt In</option>
      </select>
      <p><?php _e('Unsubscribed, Unconfirmed emails not display in send mail page.', ELP_TDOMAIN); ?></p>
	  
      <input type="hidden" name="elp_form_submit" value="yes"/>
	  <div style="padding-top:5px;"></div>
      <p>
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Update Details', ELP_TDOMAIN); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_elp_redirect()" value="<?php _e('Cancel', ELP_TDOMAIN); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_elp_help()" value="<?php _e('Help', ELP_TDOMAIN); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('elp_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo ELP_OFFICIAL; ?></p>
</div>