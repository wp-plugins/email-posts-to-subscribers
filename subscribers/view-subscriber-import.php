<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$elp_errors = array();
$elp_success = '';
$elp_error_found = FALSE;
$csv = array();

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
	
	$extension = strtolower(end(explode('.', $_FILES['elp_csv_name']['name'])));
	$tmpname = $_FILES['elp_csv_name']['tmp_name'];
	
	if($extension === 'csv')
	{
		$csv = elp_cls_common::elp_readcsv($tmpname);
	}
	
	if(count($csv) > 0)
	{
		$inserted = 0;
		$duplicate = 0;
		$invalid = 0;
		$status = "Unconfirmed";
		for ($i = 0; $i < count($csv); $i++)
		{
//			if(trim($csv[$i][2]) == "")
//			{
				$status = "Confirmed";
//			}
//			elseif(trim($csv[$i][2]) == "Unsubscribed")
//			{
//				$status = "Unsubscribed";
//			}
//			elseif(trim($csv[$i][2]) == "Confirmed")
//			{
//				$status = "Confirmed";
//			}
//			elseif(trim($csv[$i][2]) == "Single Opt In")
//			{
//				$status = "Single Opt In";
//			}
//			else
//			{
//				$status = "Unconfirmed";
//			}
			$inputdata = array($csv[$i][1], $csv[$i][0], $status);
			$action = elp_cls_dbquery::elp_view_subscriber_ins($inputdata);
			if($action == "sus")
			{
				$inserted = $inserted + 1;
			}
			elseif($action == "ext")
			{
				$duplicate = $duplicate + 1;
			}
			elseif($action == "invalid")
			{
				$invalid = $invalid + 1;
			}
		}
		?>
		<div class="updated fade">
			<p><strong><?php echo $inserted; ?> <?php _e('Email(s) was successfully imported.', ELP_TDOMAIN); ?></strong></p>
			<p><strong><?php echo $duplicate; ?> <?php _e('Email(s) are already in our database.', ELP_TDOMAIN); ?></strong></p>
			<p><strong><?php echo $invalid; ?> <?php _e('Email(s) are invalid.', ELP_TDOMAIN); ?></strong></p>
			<p><strong><a href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers">
			<?php _e('Click here', ELP_TDOMAIN); ?></a> <?php _e(' to view the details', ELP_TDOMAIN); ?></strong></p>
		</div>
		<?php
	}
	else
	{
		?>
		<div class="error fade">
			<p><strong><?php _e('File upload failed or no data available in the csv file.', ELP_TDOMAIN); ?></strong></p>
		</div>
		<?php
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
	<form name="form_addemail" id="form_addemail" method="post" action="#" onsubmit="return _elp_importemail()" enctype="multipart/form-data">
      <h3><?php _e('Upload email', ELP_TDOMAIN); ?></h3>
	  <label for="tag-image"><?php _e('Select csv file', ELP_TDOMAIN); ?></label>
	  <input type="file" name="elp_csv_name" id="elp_csv_name" />
      <p><?php _e('Please select the input csv file. Please check official website for csv structure.', ELP_TDOMAIN); ?></p>
	    
      <input type="hidden" name="elp_form_submit" value="yes"/>
	  <div style="padding-top:5px;"></div>
      <p>
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Upload CSV', ELP_TDOMAIN); ?>" type="submit" />
		<input name="publish" lang="publish" class="button add-new-h2" onclick="_elp_redirect()" value="<?php _e('Back', ELP_TDOMAIN); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_elp_help()" value="<?php _e('Help', ELP_TDOMAIN); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('elp_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo ELP_OFFICIAL; ?></p>
</div>