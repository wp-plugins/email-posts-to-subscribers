<?php
class elp_cls_widget
{
	public static function elp_widget_int($arr)
	{
		$elp_name = "";
		$elp_desc = "";
		require_once(ELP_DIR.'widget'.DIRECTORY_SEPARATOR.'widget.php');
	}
}

function elp_shortcode( $atts ) 
{
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	
	//[email-posts-subscribers namefield="YES" desc=""]
	$elp_name = isset($atts['namefield']) ? $atts['namefield'] : 'YES';
	$elp_desc = isset($atts['desc']) ? $atts['desc'] : '';
	
	$arr = array();
	$arr["elp_title"] 	= "";
	$arr["elp_desc"] 	= $elp_desc;
	$arr["elp_name"] 	= $elp_name;
	require_once(ELP_DIR.'widget'.DIRECTORY_SEPARATOR.'widget.php');
}

function elp_subbox( $elp_name = "YES", $elp_desc = "" )
{
	$arr = array();
	$arr["elp_title"] 	= "";
	$arr["elp_desc"] 	= $elp_desc;
	$arr["elp_name"] 	= $elp_name;	
	require_once(ELP_DIR.'widget'.DIRECTORY_SEPARATOR.'widget.php');
}
?>