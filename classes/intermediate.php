<?php
class elp_cls_intermediate
{
	public static function elp_information()
	{
		require_once(ELP_DIR.'help'.DIRECTORY_SEPARATOR.'help.php');
	}
	
	public static function elp_template()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ELP_DIR.'template'.DIRECTORY_SEPARATOR.'template-add.php');
				break;
			case 'edit':
				require_once(ELP_DIR.'template'.DIRECTORY_SEPARATOR.'template-edit.php');
				break;
			case 'preview':
				require_once(ELP_DIR.'template'.DIRECTORY_SEPARATOR.'template-preview.php');
				break;
			default:
				require_once(ELP_DIR.'template'.DIRECTORY_SEPARATOR.'template-show.php');
				break;
		}
	}
	
	public static function elp_subscribers()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ELP_DIR.'subscribers'.DIRECTORY_SEPARATOR.'view-subscriber-add.php');
				break;
			case 'edit':
				require_once(ELP_DIR.'subscribers'.DIRECTORY_SEPARATOR.'view-subscriber-edit.php');
				break;
			case 'export':
				require_once(ELP_DIR.'subscribers'.DIRECTORY_SEPARATOR.'view-subscriber-export.php');
				break;
			case 'import':
				require_once(ELP_DIR.'subscribers'.DIRECTORY_SEPARATOR.'view-subscriber-import.php');
				break;
			case 'page':
				require_once(ELP_DIR.'subscribers'.DIRECTORY_SEPARATOR.'view-subscriber-page.php');
				break;
			default:
				require_once(ELP_DIR.'subscribers'.DIRECTORY_SEPARATOR.'view-subscriber-show.php');
				break;
		}
	}
	
	public static function elp_configuration()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ELP_DIR.'configuration'.DIRECTORY_SEPARATOR.'configuration-add.php');
				break;
			case 'edit':
				require_once(ELP_DIR.'configuration'.DIRECTORY_SEPARATOR.'configuration-edit.php');
				break;
			case 'cron':
				require_once(ELP_DIR.'configuration'.DIRECTORY_SEPARATOR.'configuration-cron.php');
				break;
			case 'preview':
				require_once(ELP_DIR.'configuration'.DIRECTORY_SEPARATOR.'configuration-preview.php');
				break;
			default:
				require_once(ELP_DIR.'configuration'.DIRECTORY_SEPARATOR.'configuration-show.php');
				break;
		}
	}
	
	public static function elp_sentmail()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'delivery':
				require_once(ELP_DIR.'sentmail'.DIRECTORY_SEPARATOR.'deliverreport-show.php');
				break;
			case 'preview':
				require_once(ELP_DIR.'sentmail'.DIRECTORY_SEPARATOR.'sentmail-preview.php');
				break;
			default:
				require_once(ELP_DIR.'sentmail'.DIRECTORY_SEPARATOR.'sentmail-show.php');
				break;
		}
	}
	
	public static function elp_sendemail()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'sub':
				require_once(ELP_DIR.'sendmail'.DIRECTORY_SEPARATOR.'sendmail-subscriber.php');
				break;
			default:
				require_once(ELP_DIR.'sendmail'.DIRECTORY_SEPARATOR.'sendmail-subscriber.php');
				break;
		}
	}
	
	public static function elp_settings()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ELP_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-add.php');
				break;
			default:
				require_once(ELP_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-edit.php');
				break;
		}
	}
	
	public static function elp_schedule()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ELP_DIR.'settings'.DIRECTORY_SEPARATOR.'schedule-add.php');
				break;
			case 'edit':
				require_once(ELP_DIR.'settings'.DIRECTORY_SEPARATOR.'schedule-edit.php');
				break;
			case 'show':
				require_once(ELP_DIR.'settings'.DIRECTORY_SEPARATOR.'schedule-show.php');
				break;
			default:
				require_once(ELP_DIR.'settings'.DIRECTORY_SEPARATOR.'schedule-show.php');
				break;
		}
	}
}
?>