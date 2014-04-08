<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
if(isset($_GET['elp']))
{
	if($_GET['elp'] == "cronjob")
	{
		require_once(ELP_DIR.'classes'.DIRECTORY_SEPARATOR.'stater.php');
		$noerror = true;
		
		$form = array();
		$form['guid'] = isset($_GET['guid']) ? $_GET['guid'] : '';
		$form['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
		if ( $form['guid'] == '' )
		{
			$noerror = false;
		}
		
		if($noerror)
		{
			$data = array();
			$data = elp_cls_dbquery::elp_configuration_cron($form['guid']);
			
			if(count($data) > 0)
			{
				$subject = $data[0]['elp_set_name'];
				$content = elp_cls_newsletter::elp_template_compose($data[0]['elp_set_templid'], $data[0]['elp_set_postcount'], 
									$data[0]['elp_set_postcategory'], $data[0]['elp_set_postorderby'], $data[0]['elp_set_postorder'], "send");
									
				elp_cls_sendmail::elp_prepare_newsletter($subject, $content, $form['page'], $data[0]['elp_set_totalsent']);
			}
		}
	}
}
die();
?>