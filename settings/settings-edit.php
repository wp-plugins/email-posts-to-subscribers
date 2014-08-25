<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$elp_errors = array();
$elp_success = '';
$elp_error_found = FALSE;
	
$result = elp_cls_dbquery2::elp_setting_count(1);
if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', ELP_TDOMAIN); ?></strong></p></div><?php
	$form = array(
		'elp_c_id' => '',
		'elp_c_fromname' => '',
		'elp_c_fromemail' => '',
		'elp_c_mailtype' => '',
		'elp_c_adminmailoption' => '',
		'elp_c_adminemail' => '',
		'elp_c_adminmailsubject' => '',
		'elp_c_adminmailcontant' => '',
		'elp_c_usermailoption' => '',
		'elp_c_usermailsubject' => '',
		'elp_c_usermailcontant' => '',
		'elp_c_optinoption' => '',
		'elp_c_optinsubject' => '',
		'elp_c_optincontent' => '',
		'elp_c_optinlink' => '',
		'elp_c_unsublink' => '',
		'elp_c_unsubtext' => '',
		'elp_c_unsubhtml' => '',
		'elp_c_subhtml' => '',
		'elp_c_message1' => '',
		'elp_c_message2' => ''
	);
}
else
{
	$elp_errors = array();
	$elp_success = '';
	$elp_error_found = FALSE;
	
	$data = array();
	$data = elp_cls_dbquery2::elp_setting_select(1);
	
	
	$elp_c_sentreport_subject = '';
	$elp_c_sentreport = '';	
	$elp_c_sentreport_subject = get_option('elp_c_sentreport_subject', 'nosubjectexists');
	$elp_c_sentreport = get_option('elp_c_sentreport', 'nooptionexists');
	if($elp_c_sentreport_subject == "nosubjectexists")
	{	
		$elp_sentreport_subject = elp_cls_common::elp_sent_report_subject();
		add_option('elp_c_sentreport_subject', $elp_sentreport_subject);
		$elp_c_sentreport_subject = $elp_sentreport_subject;
	}
	
	if($elp_c_sentreport == "nooptionexists")
	{		
		$elp_sent_report_plain = elp_cls_common::elp_sent_report_plain();
		add_option('elp_c_sentreport', $elp_sent_report_plain);
		$elp_c_sentreport = $elp_sent_report_plain;
	}	
	
	// Preset the form fields
	$form = array(
		'elp_c_id' => $data['elp_c_id'],
		'elp_c_fromname' => $data['elp_c_fromname'],
		'elp_c_fromemail' => $data['elp_c_fromemail'],
		'elp_c_mailtype' => $data['elp_c_mailtype'],
		'elp_c_adminmailoption' => $data['elp_c_adminmailoption'],
		'elp_c_adminemail' => $data['elp_c_adminemail'],
		'elp_c_adminmailsubject' => $data['elp_c_adminmailsubject'],
		'elp_c_adminmailcontant' => $data['elp_c_adminmailcontant'],
		'elp_c_usermailoption' => $data['elp_c_usermailoption'],
		'elp_c_usermailsubject' => $data['elp_c_usermailsubject'],
		'elp_c_usermailcontant' => $data['elp_c_usermailcontant'],
		'elp_c_optinoption' => $data['elp_c_optinoption'],
		'elp_c_optinsubject' => $data['elp_c_optinsubject'],
		'elp_c_optincontent' => $data['elp_c_optincontent'],
		'elp_c_optinlink' => $data['elp_c_optinlink'],
		'elp_c_unsublink' => $data['elp_c_unsublink'],
		'elp_c_unsubtext' => $data['elp_c_unsubtext'],
		'elp_c_unsubhtml' => $data['elp_c_unsubhtml'],
		'elp_c_subhtml' => $data['elp_c_subhtml'],
		'elp_c_message1' => $data['elp_c_message1'],
		'elp_c_message2' => $data['elp_c_message2'],
		'elp_c_sentreport' => $elp_c_sentreport,
		'elp_c_sentreport_subject' => $elp_c_sentreport_subject
	);
}

	
// Form submitted, check the data
if (isset($_POST['elp_form_submit']) && $_POST['elp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('elp_form_edit');
	
	$form['elp_c_fromname'] = isset($_POST['elp_c_fromname']) ? $_POST['elp_c_fromname'] : '';
	if ($form['elp_c_fromname'] == '')
	{
		$elp_errors[] = __('Please enter sender of notifications from name.', ELP_TDOMAIN);
		$elp_error_found = TRUE;
	}
	$form['elp_c_fromemail'] = isset($_POST['elp_c_fromemail']) ? $_POST['elp_c_fromemail'] : '';
	if ($form['elp_c_fromemail'] == '')
	{
		$elp_errors[] = __('Please enter sender of notifications from email.', ELP_TDOMAIN);
		$elp_error_found = TRUE;
	}
	
	$home_url = home_url('/');
	$optinlink = $home_url . "?elp=optin&db=###DBID###&email=###EMAIL###&guid=###GUID###";
	$unsublink = $home_url . "?elp=unsubscribe&db=###DBID###&email=###EMAIL###&guid=###GUID###"; 
			
	$form['elp_c_mailtype'] = isset($_POST['elp_c_mailtype']) ? $_POST['elp_c_mailtype'] : '';
	$form['elp_c_adminmailoption'] = isset($_POST['elp_c_adminmailoption']) ? $_POST['elp_c_adminmailoption'] : '';
	$form['elp_c_adminemail'] = isset($_POST['elp_c_adminemail']) ? $_POST['elp_c_adminemail'] : '';
	$form['elp_c_adminmailsubject'] = isset($_POST['elp_c_adminmailsubject']) ? $_POST['elp_c_adminmailsubject'] : '';
	$form['elp_c_adminmailcontant'] = isset($_POST['elp_c_adminmailcontant']) ? $_POST['elp_c_adminmailcontant'] : '';
	$form['elp_c_usermailoption'] = isset($_POST['elp_c_usermailoption']) ? $_POST['elp_c_usermailoption'] : '';
	$form['elp_c_usermailsubject'] = isset($_POST['elp_c_usermailsubject']) ? $_POST['elp_c_usermailsubject'] : '';
	$form['elp_c_usermailcontant'] = isset($_POST['elp_c_usermailcontant']) ? $_POST['elp_c_usermailcontant'] : '';
	$form['elp_c_optinoption'] = isset($_POST['elp_c_optinoption']) ? $_POST['elp_c_optinoption'] : '';
	$form['elp_c_optinsubject'] = isset($_POST['elp_c_optinsubject']) ? $_POST['elp_c_optinsubject'] : '';
	$form['elp_c_optincontent'] = isset($_POST['elp_c_optincontent']) ? $_POST['elp_c_optincontent'] : '';
	$form['elp_c_optinlink'] = $optinlink; //isset($_POST['elp_c_optinlink']) ? $_POST['elp_c_optinlink'] : '';
	$form['elp_c_unsublink'] = $unsublink; //isset($_POST['elp_c_unsublink']) ? $_POST['elp_c_unsublink'] : '';
	$form['elp_c_unsubtext'] = isset($_POST['elp_c_unsubtext']) ? $_POST['elp_c_unsubtext'] : '';
	$form['elp_c_unsubhtml'] = isset($_POST['elp_c_unsubhtml']) ? $_POST['elp_c_unsubhtml'] : '';
	$form['elp_c_subhtml'] = isset($_POST['elp_c_subhtml']) ? $_POST['elp_c_subhtml'] : '';
	$form['elp_c_message1'] = isset($_POST['elp_c_message1']) ? $_POST['elp_c_message1'] : '';
	$form['elp_c_message2'] = isset($_POST['elp_c_message2']) ? $_POST['elp_c_message2'] : '';

	//	No errors found, we can add this Group to the table
	if ($elp_error_found == FALSE)
	{	
		$inputdata = array(1, $form['elp_c_fromname'], $form['elp_c_fromemail'], $form['elp_c_mailtype'], 
								$form['elp_c_adminmailoption'], $form['elp_c_adminemail'], $form['elp_c_adminmailsubject'], 
								$form['elp_c_adminmailcontant'], $form['elp_c_usermailoption'], $form['elp_c_usermailsubject'], 
								$form['elp_c_usermailcontant'], $form['elp_c_optinoption'], $form['elp_c_optinsubject'], $form['elp_c_optincontent'], 
								$form['elp_c_optinlink'], $form['elp_c_unsublink'], $form['elp_c_unsubtext'], $form['elp_c_unsubhtml'], 
								$form['elp_c_subhtml'], $form['elp_c_message1'], $form['elp_c_message2']);
		$action = "";
		$action = elp_cls_dbquery2::elp_setting_update($inputdata);
		if($action == "sus")
		{
			$elp_success = __('Details was successfully updated.', ELP_TDOMAIN);
		}
		else
		{
			$elp_error_found == TRUE;
			$elp_errors[] = __('Oops, details not update.', ELP_TDOMAIN);
		}
	}
	
	$form['elp_c_sentreport'] = isset($_POST['elp_c_sentreport']) ? $_POST['elp_c_sentreport'] : '';
	update_option('elp_c_sentreport', $form['elp_c_sentreport'] );
	$form['elp_c_sentreport_subject'] = isset($_POST['elp_c_sentreport_subject']) ? $_POST['elp_c_sentreport_subject'] : '';
	update_option('elp_c_sentreport_subject', $form['elp_c_sentreport_subject'] );
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
				<a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=elp-settings"><?php _e('Click here', ELP_TDOMAIN); ?></a>
				<?php _e(' to view the details', ELP_TDOMAIN); ?>
			</strong>
		</p>
	</div>
	<?php
}
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>settings/settings.js"></script>
<style>
.form-table th {
    width: 350px;
}
</style>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
	<h3><?php _e('Settings', ELP_TDOMAIN); ?></h3>
	<form name="elp_form" method="post" action="#" onsubmit="return _elp_submit()"  >
	<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">
				<label for="elp"><?php _e('Sender of notifications', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Choose a FROM name and FROM email address for all notifications emails from this plugin.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td>
				<input name="elp_c_fromname" type="text" id="elp_c_fromname" value="<?php echo $form['elp_c_fromname']; ?>" maxlength="225" />
				<input name="elp_c_fromemail" type="text" id="elp_c_fromemail" value="<?php echo $form['elp_c_fromemail']; ?>" size="35" maxlength="225" />
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Mail type', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Option 1 & 2 is to send mails with default Wordpress method wp_mail(). Option 3 & 4 is to send mails with PHP method mail()', ELP_TDOMAIN); ?></p></label>
			</th>
			<td>
				<select name="elp_c_mailtype" id="elp_c_mailtype">
					<option value='WP HTML MAIL' <?php if($form['elp_c_mailtype'] == 'WP HTML MAIL') { echo 'selected' ; } ?>>1. WP HTML MAIL</option>
					<option value='WP PLAINTEXT MAIL' <?php if($form['elp_c_mailtype'] == 'WP PLAINTEXT MAIL') { echo 'selected' ; } ?>>2. WP PLAINTEXT MAIL</option>
					<option value='PHP HTML MAIL' <?php if($form['elp_c_mailtype'] == 'PHP HTML MAIL') { echo 'selected' ; } ?>>3. PHP HTML MAIL</option>
					<option value='PHP PLAINTEXT MAIL' <?php if($form['elp_c_mailtype'] == 'PHP PLAINTEXT MAIL') { echo 'selected' ; } ?>>4. PHP PLAINTEXT MAIL</option>
				</select>
			</td>
		</tr>
		<!-------------------------------------------------------------------------------->
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Opt-in option', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Double Opt In, means subscribers need to confirm their email address by an activation link sent them on a activation email message. Single Opt In, means subscribers do not need to confirm their email address.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td>			
				<select name="elp_c_optinoption" id="elp_c_optinoption">
					<option value='Double Opt In' <?php if($form['elp_c_optinoption'] == 'Double Opt In') { echo 'selected' ; } ?>>Double Opt In</option>
					<option value='Single Opt In' <?php if($form['elp_c_optinoption'] == 'Single Opt In') { echo 'selected' ; } ?>>Single Opt In</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Opt-in mail subject (Confirmation mail)', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Enter the subject for Double Opt In mail. This will send whenever subscriber added email into our database.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><input name="elp_c_optinsubject" type="text" id="elp_c_optinsubject" value="<?php echo esc_html(stripslashes($form['elp_c_optinsubject'])); ?>" size="60" maxlength="225" /></td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Opt-in mail content (Confirmation mail)', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Enter the content for Double Opt In mail. This will send whenever subscriber added email into our database.', ELP_TDOMAIN); ?> (Keyword: ##NAME##)</p></label>
			</th>
			<td><textarea size="100" id="elp_c_optincontent" rows="10" cols="58" name="elp_c_optincontent"><?php echo esc_html(stripslashes($form['elp_c_optincontent'])); ?></textarea></td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Opt-in link (Confirmation link)', ELP_TDOMAIN); ?><p class="description">
				<?php _e('Double Opt In confirmation link. You no need to change this value.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><input name="elp_c_optinlink" type="text" id="elp_c_optinlink" value="<?php echo esc_html(stripslashes($form['elp_c_optinlink'])); ?>" size="60" maxlength="225" /></td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Text to display after email subscribed successfully', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('This text will display once user clicked email confirmation link from opt-in (confirmation) email content.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><textarea size="100" id="elp_c_subhtml" rows="4" cols="58" name="elp_c_subhtml"><?php echo esc_html(stripslashes($form['elp_c_subhtml'])); ?></textarea></td>
		</tr>
		<!-------------------------------------------------------------------------------->
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Subscriber welcome email', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('To send welcome mail to subscriber, This option must be set to YES.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td>			
			<select name="elp_c_usermailoption" id="elp_c_usermailoption">
				<option value='YES' <?php if($form['elp_c_usermailoption'] == 'YES') { echo 'selected' ; } ?>>YES</option>
				<option value='NO' <?php if($form['elp_c_usermailoption'] == 'NO') { echo 'selected' ; } ?>>NO</option>
			</select>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Welcome mail subject', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Enter the subject for subscriber welcome mail. This will send whenever email subscribed (confirmed) successfully.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><input name="elp_c_usermailsubject" type="text" id="elp_c_usermailsubject" value="<?php echo esc_html(stripslashes($form['elp_c_usermailsubject'])); ?>" size="60" maxlength="225" /></td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Subscriber welcome mail content', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Enter the content for subscriber welcome mail. This will send whenever email subscribed (confirmed) successfully.', ELP_TDOMAIN); ?> (Keyword: ###NAME###)</p>
			</label>
			</th>
			<td><textarea size="100" id="elp_c_usermailcontant" rows="10" cols="58" name="elp_c_usermailcontant"><?php echo esc_html(stripslashes($form['elp_c_usermailcontant'])); ?></textarea></td>
		</tr>
		<!-------------------------------------------------------------------------------->
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Mail to admin', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('To send admin notifications for new subscriber, This option must be set to YES.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td>			
			<select name="elp_c_adminmailoption" id="elp_c_adminmailoption">
				<option value='YES' <?php if($form['elp_c_adminmailoption'] == 'YES') { echo 'selected' ; } ?>>YES</option>
				<option value='NO' <?php if($form['elp_c_adminmailoption'] == 'NO') { echo 'selected' ; } ?>>NO</option>
			</select>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Admin email addresses', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Enter the admin email addresses that should receive notifications (separate by comma).', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><input name="elp_c_adminemail" type="text" id="elp_c_adminemail" value="<?php echo esc_html(stripslashes($form['elp_c_adminemail'])); ?>" size="60" maxlength="225" /></td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Admin mail subject', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Enter the subject for admin mail. This will send whenever new email added and confirmed into our database.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><input name="elp_c_adminmailsubject" type="text" id="elp_c_adminmailsubject" value="<?php echo esc_html(stripslashes($form['elp_c_adminmailsubject'])); ?>" size="60" maxlength="225" /></td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Admin mail content', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Enter the mail content for admin. This will send whenever new email added and confirmed into our database.', ELP_TDOMAIN); ?> (Keyword: ##NAME##, ##EMAIL##)</p></label>
			</th>
			<td><textarea size="100" id="elp_c_adminmailcontant" rows="10" cols="58" name="elp_c_adminmailcontant"><?php echo esc_html(stripslashes($form['elp_c_adminmailcontant'])); ?></textarea></td>
		</tr>
		<!-------------------------------------------------------------------------------->
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Unsubscribe link', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Unsubscribe link. You no need to change this value.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><input name="elp_c_unsublink" type="text" id="elp_c_unsublink" value="<?php echo esc_html(stripslashes($form['elp_c_unsublink'])); ?>" size="60" maxlength="225" /></td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Unsubscribe text in mail', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Enter the text for unsubscribe link. This text is to add unsubscribe link with newsletter.', ELP_TDOMAIN); ?> (Keyword: ###LINK###)</p></label>
			</th>
			<td><textarea size="100" id="elp_c_unsubtext" rows="4" cols="58" name="elp_c_unsubtext"><?php echo esc_html(stripslashes($form['elp_c_unsubtext'])); ?></textarea></td>
		</tr>	
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Text to display after email unsubscribed', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('This text will display once user clicked unsubscribed link from our newsletter.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><textarea size="100" id="elp_c_unsubhtml" rows="4" cols="58" name="elp_c_unsubhtml"><?php echo esc_html(stripslashes($form['elp_c_unsubhtml'])); ?></textarea></td>
		</tr>
		<!-------------------------------------------------------------------------------->
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Message 1', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Default message to display if any issue on confirmation link.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><textarea size="100" id="elp_c_message1" rows="4" cols="58" name="elp_c_message1"><?php echo esc_html(stripslashes($form['elp_c_message1'])); ?></textarea></td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Message 2', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Default message to display if any issue on unsubscribe link.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><textarea size="100" id="elp_c_message2" rows="4" cols="58" name="elp_c_message2"><?php echo esc_html(stripslashes($form['elp_c_message2'])); ?></textarea></td>
		</tr>
		<!-------------------------------------------------------------------------------->
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Sent report subject', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Mail subject for sent mail report.', ELP_TDOMAIN); ?></p></label>
			</th>
			<td><input name="elp_c_sentreport_subject" type="text" id="elp_c_sentreport_subject" value="<?php echo esc_html(stripslashes($form['elp_c_sentreport_subject'])); ?>" size="60" maxlength="225" /></td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="elp"><?php _e('Sent report content', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Mail content for sent mail report.', ELP_TDOMAIN); ?> (Keyword: ###COUNT###, ###UNIQUE###, ###STARTTIME###, ###ENDTIME###)</p></label>
			</th>
			<td><textarea size="100" id="elp_c_sentreport" rows="8" cols="58" name="elp_c_sentreport"><?php echo esc_html(stripslashes($form['elp_c_sentreport'])); ?></textarea></td>
		</tr>
		<!-------------------------------------------------------------------------------->
	</tbody>
	</table>
	<div style="padding-top:10px;"></div>
	<input type="hidden" name="elp_form_submit" value="yes"/>
	<p class="submit">
		<input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Save Settings', ELP_TDOMAIN); ?>" type="submit" />
		<input name="publish" lang="publish" class="button add-new-h2" onclick="_elp_redirect()" value="<?php _e('Cancel', ELP_TDOMAIN); ?>" type="button" />
		<input name="Help" lang="publish" class="button add-new-h2" onclick="_elp_help()" value="<?php _e('Help', ELP_TDOMAIN); ?>" type="button" />
	</p>
	<?php wp_nonce_field('elp_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo ELP_OFFICIAL; ?></p>
</div>