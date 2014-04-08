<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class elp_cls_newsletter
{
	public static function elp_template_compose($id = 0, $post = 5, $cat = "", $orderby = "", $order = "DESC", $action = "preview")
	{
		$excerpt_length = 50; // Change this value to increase the content length in newsletter.
		global $wpdb;
		$prefix = $wpdb->prefix;
		$preview = "";
		$arrRes = array();
		$sSql = "SELECT * FROM `".$prefix."elp_templatetable` where 1=1";
		$sSql = $sSql . " and elp_templ_id=".$id;
		$arrRes = $wpdb->get_row($sSql, ARRAY_A);
		
		if(count($arrRes) > 0)
		{
			$elp_templ_heading = stripslashes($arrRes['elp_templ_heading']);
			$elp_templ_header = stripslashes($arrRes['elp_templ_header']);
			$elp_templ_body = stripslashes($arrRes['elp_templ_body']);
			$elp_templ_footer = stripslashes($arrRes['elp_templ_footer']);
			$elp_templ_status = $arrRes['elp_templ_status'];
			
			//$preview = "<html>";
			//$preview = $preview . "<head><title>" . $elp_templ_heading . "</title></head>";
			//$preview = $preview . "<body>";
			$preview = $preview . '<div style="clear:both;"></div>';
			$preview = $preview . $elp_templ_header;
			$preview = $preview . '<div style="clear:both;"></div>';
			//-----------------------------------------------------------
			$body = $elp_templ_body;
			$post_id  = "";
			$post_title  = "";
			$post_excerpt  = "";
			$post_link  = "";
			$post_thumbnail  = "";
			$post_thumbnail_link  = "";
			$post_date = "";
			$post_author = "";
			$i = 1;
			$qstring = "posts_per_page=".$post."&post_status=publish&category='".$cat."'&orderby='".$orderby."'&order='".$order."'";
			$postlist  = get_posts( $qstring );
			$posts = array();
			foreach ( $postlist as $post ) 
			{
				setup_postdata($post);
				$post_id = $post->ID;
				$post_title = $post->post_title;
				$post_author = get_the_author();
				$post_date = $post->post_modified;
				$post_excerpt = elp_cls_newsletter::elp_excerpt_by_id($post_id, $excerpt_length);
				$post_link = get_permalink($post_id);	
					
				if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_id)))
				{
					$post_thumbnail = get_the_post_thumbnail($post_id, 'thumbnail');
				}
				
				if($post_thumbnail <> "")
				{
					$post_thumbnail_link = "<a href='".$post_link."' target='_blank'>".$post_thumbnail."</a>";
				}
				
				if($post_title <> "")
				{
					$post_title = "<a href='".$post_link."' target='_blank' style=''>".$post_title."</a>";
				}
				
				$bodyown = str_replace('###POSTTITLE###', $post_title, $body);
				$bodyown = str_replace('###POSTIMAGE###', $post_thumbnail_link, $bodyown);
				$bodyown = str_replace('###POSTDESC###', $post_excerpt, $bodyown);
				$bodyown = str_replace('###DATE###', $post_date, $bodyown);
				$bodyown = str_replace('###AUTHOR###', $post_author, $bodyown);
				
				//$preview = $preview . '<div style="clear:both;"></div>';
				$preview = $preview . $bodyown;
				$preview = $preview . '<div style="clear:both;"></div>';
				
				$post_id  = "";
				$post_title  = "";
				$post_excerpt  = "";
				$post_link  = "";
				$post_thumbnail  = "";
				$post_thumbnail_link  = "";
				$post_date = "";
				$post_author = "";
				$i = $i + 1;
			}
			wp_reset_postdata();
			wp_reset_query();
			//-----------------------------------------------------------
			$preview = $preview . '<div style="clear:both;"></div>';
			$preview = $preview . $elp_templ_footer;
			$preview = $preview . '<div style="clear:both;"></div>';
			
			if($action == "preview")
			{
				$preview = str_replace('###EMAIL###', "useremail@email.com", $preview);
				$preview = str_replace('###NAME###', "User Name", $preview);
			}
			//$preview = $preview . "<body>";
			//$preview = $preview . "</html>";
			$preview = str_replace("\r\n", "<br />", $preview);
		}
		return $preview;
	}
	
	public static function elp_excerpt_by_id($post_id, $excerpt_length)
	{
		$the_post = get_post($post_id);
		$the_excerpt = $the_post->post_content;
		$the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
		$words = explode(' ', $the_excerpt, $excerpt_length + 1);
		if(count($words) > $excerpt_length)
		{
			array_pop($words);
			array_push($words, '...');
			$the_excerpt = implode(' ', $words);
		}
		$the_excerpt = nl2br($the_excerpt);
		$the_excerpt = str_replace("<br>", " ", $the_excerpt);
		$the_excerpt = str_replace("<br />", " ", $the_excerpt);
		$the_excerpt = str_replace("\r\n", " ", $the_excerpt);
		return $the_excerpt;
	}
}
?>