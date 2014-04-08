<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$elp_errors = array();
$elp_success = '';
$elp_error_found = FALSE;

$guid = isset($_POST['guid']) ? $_POST['guid'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : '1';
$sendmailsubmit = isset($_POST['sendmailsubmit']) ? $_POST['sendmailsubmit'] : 'no';
$perpage = 100;

if ($sendmailsubmit == 'yes')
{
	check_admin_referer('elp_form_submit');
	
	$form['guid'] = isset($_POST['guid']) ? $_POST['guid'] : '';
	if ($form['guid'] == '')
	{
		$elp_errors[] = __('Please select mail configuration.', ELP_TDOMAIN);
		$elp_error_found = TRUE;
	}
	//$recipients = $_POST['eemail_checked'];
	$recipients = isset($_POST['eemail_checked']) ? $_POST['eemail_checked'] : '';
	if ($recipients == '')
	{
		$elp_errors[] = __('No email address selected.', ELP_TDOMAIN);
		$elp_error_found = TRUE;
	}
	
	if ($elp_error_found == FALSE)
	{
		$data = array();
		$data = elp_cls_dbquery::elp_configuration_cron($form['guid']);
		
		if(count($data) > 0)
		{
			$subject = $data[0]['elp_set_name'];
			$content = elp_cls_newsletter::elp_template_compose($data[0]['elp_set_templid'], $data[0]['elp_set_postcount'], 
								$data[0]['elp_set_postcategory'], $data[0]['elp_set_postorderby'], $data[0]['elp_set_postorder'], "send");
			elp_cls_sendmail::elp_prepare_newsletter_manual($subject, $content, $recipients);
			
			$elp_success_msg = TRUE;
			$elp_success = __('Mail sent successfully', ELP_TDOMAIN);
		}
		
		if ($elp_success_msg == TRUE)
		{
			?>
			<div class="updated fade">
			  <p>
				<strong><?php echo $elp_success; ?> <a href="<?php echo ELP_ADMINURL; ?>?page=elp-sentmail"><?php _e('Click here for details', ELP_TDOMAIN); ?></a></strong>
			  </p>
			</div>
			<?php
		}
	}
}

if ($guid <> "")
{
	$data = elp_cls_dbquery::elp_configuration_cron($guid);
	if(count($data) > 0)
	{
		$perpage = $data[0]['elp_set_totalsent'];
	}
}

if ($elp_error_found == TRUE && isset($elp_errors[0]) == TRUE)
{
	?><div class="error fade"><p><strong><?php echo $elp_errors[0]; ?></strong></p></div><?php
}
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>sendmail/sendmail.js"></script>
<style>
.form-table th {
    width: 250px;
}
</style>
<div class="wrap">
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
	<h3><?php _e('Send Mail Manually', ELP_TDOMAIN); ?></h3>
	<form name="elp_form" method="post" action="#" onsubmit="return _elp_submit()"  >
	<table class="form-table">
	<tbody>
		<tr>
		<th scope="row">
			<label for="elp">
				<?php _e('Select your mail configuration', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Select a mail configuration from available list. To create please check mail configuration menu.', ELP_TDOMAIN); ?></p>
			</label>
		</th>
		<td>
			<select name="elp_set_guid" id="elp_set_guid" onChange="_elp_mailsubject(this.options[this.selectedIndex].value)">
			<option value=''><?php _e('Select', ELP_TDOMAIN); ?></option>
			<?php
			$configs = array();
			$configs = elp_cls_dbquery::elp_configuration_select(0, 0, 100);
			$thisselected = "";
			if(count($configs) > 0)
			{
				$i = 1;
				foreach ($configs as $config)
				{
					if($config["elp_set_guid"] == $guid) 
					{ 
						$thisselected = "selected='selected'" ; 
					}
					?><option value='<?php echo $config["elp_set_guid"]; ?>' <?php echo $thisselected; ?>><?php echo $config["elp_set_name"]; ?></option><?php
					$thisselected = "";
				}
			}
			?>
			</select>
			<?php _e('Mail count for one shot :', ELP_TDOMAIN); ?> <?php echo $perpage; ?>
		</td>
		</tr>
		<?php
		$total1 = elp_cls_dbquery::elp_view_subscriber_count_status("Confirmed");
		$total2 = elp_cls_dbquery::elp_view_subscriber_count_status("Single Opt In");
		$total = $total1 + $total2;
		$pagecount = ceil( $total / $perpage );
		?>
		<tr>
		<th scope="row">
			<label for="elp">
				<?php _e('Select email address page', ELP_TDOMAIN); ?>
				<p class="description"><?php _e('Select email address page', ELP_TDOMAIN); ?></p>
			</label>
		</th>
		<td>
			<select name="elp_set_page" id="elp_set_page" onChange="_elp_mailpage(this.options[this.selectedIndex].value)">
			<?php 
			if($pagecount > 0)
			{
				for ($p = 1; $p <= $pagecount; $p++) 
				{ 
					if($p == $page) 
					{ 
						$thisselected = "selected='selected'" ; 
					}
					?><option value='<?php echo $p; ?>' <?php echo $thisselected; ?>>Page <?php echo $p; ?> of <?php echo $pagecount; ?></option><?php
					$thisselected = "";
				}
			}
			else
			{
				?><option value='0'><?php _e('No Subscribers', ELP_TDOMAIN); ?></option><?php
			}
			?>
			</select>
			<input type="button" name="CheckAll" value="<?php _e('Check All', ELP_TDOMAIN); ?>" onClick="_elp_checkall('elp_form', 'eemail_checked[]', true);">
			<input type="button" name="UnCheckAll" value="<?php _e('Uncheck All', ELP_TDOMAIN); ?>" onClick="_elp_checkall('elp_form', 'eemail_checked[]', false);">
		</td>
		</tr>
		<tr>
		<td colspan="2">
			<?php
			$subscribers = array();
			$offset = ($page - 1) * $perpage;
			$subscribers = elp_cls_dbquery::elp_view_subscriber_cron($offset, $perpage);	
			$i = 1;
			$count = 0;
			if(count($subscribers) > 0)
			{
				echo "<table border='0' cellspacing='0'><tr>";
				$col=3;
				foreach ($subscribers as $subscriber)
				{
					$to = $subscriber['elp_email_mail'];
					$id = $subscriber['elp_email_id'];
					//$ToAddress = trim($to) . '<||>' . trim($id);
					if($to <> "")
					{
						echo "<td style='padding-top:4px;padding-bottom:4px;padding-right:10px;'>";
						?>
						<input class="radio" type="checkbox" checked="checked" value='<?php echo $id; ?>' id="eemail_checked[]" name="eemail_checked[]">
						<?php echo $to; ?> (<?php echo $id; ?>)
						<?php
						if($col > 1) 
						{
							$col=$col-1;
							echo "</td><td>"; 
						}
						elseif($col = 1)
						{
							$col=$col-1;
							echo "</td></tr><tr>";;
							$col=3;
						}
						$count = $count + 1;
					}
				}
				echo "</tr></table>";
			}
			?>
		</td>
		</tr>
	</tbody>
	</table>
	<div>
	<?php if( $pagecount <> 0 ) { ?>
	<input type="submit" name="Submit" class="button add-new-h2" value="<?php _e('Send Email', ELP_TDOMAIN); ?>" style="width:160px;" />&nbsp;&nbsp;
	<?php } else { ?>
	<input type="submit" name="Submit" disabled="disabled" class="button add-new-h2" value="<?php _e('Send Email', ELP_TDOMAIN); ?>" style="width:160px;" />&nbsp;&nbsp;
	<?php } ?>
	<input name="publish" lang="publish" class="button add-new-h2" onclick="_elp_redirect()" value="<?php _e('Cancel', ELP_TDOMAIN); ?>" type="button" />&nbsp;&nbsp;
    <input name="Help" lang="publish" class="button add-new-h2" onclick="_elp_help()" value="<?php _e('Help', ELP_TDOMAIN); ?>" type="button" />
	</div>
	<?php wp_nonce_field('elp_form_submit'); ?>
	<input type="hidden" name="guid" id="guid" value="<?php echo $guid; ?>"/>
	<input type="hidden" name="page" id="page" value="<?php echo $page; ?>"/>
	<input type="hidden" name="sendmailsubmit" id="sendmailsubmit" value=""/>
	</form>
</div>
<p class="description"><?php echo ELP_OFFICIAL; ?></p>
</div>