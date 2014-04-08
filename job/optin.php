<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
if(isset($_GET['elp']))
{
	if($_GET['elp'] == "optin")
	{
		require_once(ELP_DIR.'classes'.DIRECTORY_SEPARATOR.'stater-mini.php');
		$blogname = get_option('blogname');
		$noerror = true;
		$home_url = home_url('/');
		?>
		<html>
		<head>
		<title><?php echo $blogname; ?></title>
		<meta http-equiv="refresh" content="10; url=<?php echo $home_url; ?>" />
		</head>
		<body>
		<?php
		// Load query string
		$form = array();
		$form['db'] = isset($_GET['db']) ? $_GET['db'] : '';
		$form['email'] = isset($_GET['email']) ? $_GET['email'] : '';
		$form['guid'] = isset($_GET['guid']) ? $_GET['guid'] : '';
		
		// Check errors in the query string
		if ( $form['db'] == '' || $form['email'] == '' || $form['guid'] == '' )
		{
			$noerror = false;
		}
		else
		{
			if(!is_numeric($form['db']))
			{
				$noerror = false;
			}
			
			if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL))
			{
				$noerror = false;
			}
		}
		
		// Load default message
		$data = array();
		$data = elp_cls_dbquery2::elp_setting_select(1);
		
		if($noerror)
		{
			$result = elp_cls_dbquery::elp_view_subscriber_job("Confirmed", $form['db'], $form['guid'], $form['email']);
			if($result)
			{
				elp_cls_sendmail::elp_prepare_welcome($form['db']);
				$message = esc_html(stripslashes($data['elp_c_subhtml']));
				$message = str_replace("\r\n", "<br />", $message);
			}
			else
			{
				$message = esc_html(stripslashes($data['elp_c_message2']));
			}
			if($message == "")
			{
				$message = __('Oops.. We are getting some technical error. Please try again or contact admin.', ELP_TDOMAIN);
			}
			echo $message;
		}
		else
		{
			$message = esc_html(stripslashes($data['elp_c_message2']));
			$message = str_replace("\r\n", "<br />", $message);
			if($message == "")
			{
				$message = __('Oops.. We are getting some technical error. Please try again or contact admin.', ELP_TDOMAIN);
			}
			echo $message;
		}
		?>
		</body>
		</html>
		<?php
	}
}
die();
?>