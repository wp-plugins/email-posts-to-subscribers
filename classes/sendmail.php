<?php
class elp_cls_sendmail
{
	public static function elp_prepare_optin($type= "", $id = 0, $idlist = "")
	{
		$subscribers = array();
		switch($type)
		{
			case 'group':
				$subscribers = elp_cls_dbquery::elp_view_subscriber_bulk($idlist);
				elp_cls_sendmail::elp_sendmail("optin", $subject = "", $content = "", $subscribers);
				break;
				
			case 'single':
				$subscribers = elp_cls_dbquery::elp_view_subscriber_search("", $id);
				elp_cls_sendmail::elp_sendmail("optin", $subject = "", $content = "", $subscribers);
				break;
		}
		return true;
	}
	
	public static function elp_prepare_welcome($id = 0)
	{
		$subscribers = array();
		$subscribers = elp_cls_dbquery::elp_view_subscriber_search("", $id);
		elp_cls_sendmail::elp_sendmail("welcome", $subject = "", $content = "", $subscribers);
	}
	
	public static function elp_prepare_newsletter($subject, $content, $pagenum = 0, $limit = 0)
	{
		$subscribers = array();
		$offset = ($pagenum - 1) * $limit;
		$subscribers = elp_cls_dbquery::elp_view_subscriber_cron($offset, $limit);	
		elp_cls_sendmail::elp_sendmail("newsletter", $subject, $content, $subscribers, "cron");
	}
	
	public static function elp_prepare_newsletter_manual($subject, $content, $recipients)
	{
		$subscribers = array();
		$subscribers = elp_cls_dbquery::elp_view_subscriber_manual($recipients);	
		elp_cls_sendmail::elp_sendmail("newsletter", $subject, $content, $subscribers, "manual");
	}
	
	public static function elp_sendmail($type = "", $subject = "", $content = "", $subscribers = array(), $action = "")
	{
		$data = array();
		$htmlmail = true;
		$wpmail = true;
		$unsublink = "";
		$unsubtext = "";
		$sendguid = "";
		$viewstatus = "";
		$viewstslink = "";
		$adminmail = "";
		$adminmailsubject = "";
		$adminmailcontant = "";
		$reportmail = "";
		$currentdate = date('Y-m-d G:i:s');
		$cacheid = elp_cls_common::elp_generate_guid(100);
		
		if( $type == "newsletter" )
		{
			$sendguid = elp_cls_common::elp_generate_guid(60);
			$url = home_url('/');
			$viewstatus = '<img src="'.$url.'?elp=viewstatus&delvid=###DELVIID###" width="1" height="1" />';
			elp_cls_dbquery2::elp_sentmail_ins($sendguid, $qstring = 0, $action, $currentdate, $enddt = "", count($subscribers), $content);
		}
		
		$data = elp_cls_dbquery2::elp_setting_select(1);
		$form = array(
			'elp_c_id' => $data['elp_c_id'],
			'elp_c_fromname' => $data['elp_c_fromname'],
			'elp_c_fromemail' => $data['elp_c_fromemail'],
			'elp_c_mailtype' => $data['elp_c_mailtype'],
			'elp_c_adminmailoption' => $data['elp_c_adminmailoption'],
			'elp_c_adminemail' => $data['elp_c_adminemail'],
			'elp_c_adminmailsubject' => stripslashes($data['elp_c_adminmailsubject']),
			'elp_c_adminmailcontant' => stripslashes($data['elp_c_adminmailcontant']),
			'elp_c_usermailoption' => $data['elp_c_usermailoption'],
			'elp_c_usermailsubject' => stripslashes($data['elp_c_usermailsubject']),
			'elp_c_usermailcontant' => stripslashes($data['elp_c_usermailcontant']),
			'elp_c_optinoption' => $data['elp_c_optinoption'],
			'elp_c_optinsubject' => stripslashes($data['elp_c_optinsubject']),
			'elp_c_optincontent' => stripslashes($data['elp_c_optincontent']),
			'elp_c_optinlink' => $data['elp_c_optinlink'],
			'elp_c_unsublink' => $data['elp_c_unsublink'],
			'elp_c_unsubtext' => stripslashes($data['elp_c_unsubtext']),
			'elp_c_unsubhtml' => stripslashes($data['elp_c_unsubhtml']),
			'elp_c_subhtml' => stripslashes($data['elp_c_subhtml']),
			'elp_c_message1' => stripslashes($data['elp_c_message1']),
			'elp_c_message2' => stripslashes($data['elp_c_message2'])
		);
		
		$adminmail = $form['elp_c_adminemail'];
		$elp_c_adminmailoption = $form['elp_c_adminmailoption'];
		
		if( trim($form['elp_c_fromname']) == "" || trim($form['elp_c_fromemail']) == '' )
		{
			get_currentuserinfo();
			$sender_name = $user_login;
			$sender_email = $user_email;
		}
		else
		{
			$sender_name = $form['elp_c_fromname'];
			$sender_email = $form['elp_c_fromemail'];
		}
		
		if( $form['elp_c_mailtype'] == "WP HTML MAIL" || $form['elp_c_mailtype'] == "PHP HTML MAIL" )  
		{
			$htmlmail = true;
		}
		else
		{
			$htmlmail = false;
		}
		
		if( $form['elp_c_mailtype'] == "WP HTML MAIL" || $form['elp_c_mailtype'] == "WP PLAINTEXT MAIL" )  
		{
			$wpmail = true;
		}
		else
		{
			$wpmail = false;
		}
		
		$headers  = "From: \"$sender_name\" <$sender_email>\n";
		$headers .= "Return-Path: <" . $sender_email . ">\n";
		$headers .= "Reply-To: \"" . $sender_name . "\" <" . $sender_email . ">\n";
		$headers .= "X-Mailer: PHP" . phpversion() . "\n";
		
		if($htmlmail)
		{
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: " . get_bloginfo('html_type') . "; charset=\"". get_bloginfo('charset') . "\"\n";
			$headers .= "Content-type: text/html\r\n"; 
		}
		else
		{
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/plain; charset=\"". get_bloginfo('charset') . "\"\n";
		}
		
		switch($type)
		{
			case 'optin':
				$subject = $form['elp_c_optinsubject'];
				$content = $form['elp_c_optincontent'];
				break;
				
			case 'welcome':
				$subject = $form['elp_c_usermailsubject'];
				$content = $form['elp_c_usermailcontant'];
				break;
		}
		if ( $form['elp_c_mailtype'] == "WP HTML MAIL" || $form['elp_c_mailtype'] == "PHP HTML MAIL" )
		{
			$content = str_replace("\r\n", "<br />", $content);
		}
		else
		{
			$content = str_replace("<br />", "\r\n", $content);
		}
		
		
		$count = 1;
		if(count($subscribers) > 0)
		{
			foreach ($subscribers as $subscriber)
			{
				$to = $subscriber['elp_email_mail'];
				$name = $subscriber['elp_email_name'];
				if($name == "")
				{
					$name = $to;
				}
				
				switch($type)
				{
					case 'optin':
						$content_send = str_replace("###NAME###", $name, $content);
						$content_send = str_replace("###EMAIL###", $to, $content_send);
						
						$optinlink = $form['elp_c_optinlink'];
						$optinlink = str_replace("###DBID###", $subscriber["elp_email_id"], $optinlink);
						$optinlink = str_replace("###EMAIL###", $subscriber["elp_email_mail"], $optinlink);
						$optinlink = str_replace("###GUID###", $subscriber["elp_email_guid"], $optinlink);
						$optinlink  = $optinlink . "&cache=".$cacheid;
						
						$content_send = str_replace("###LINK###", $optinlink , $content_send);
						break;
						
					case 'welcome':
						$content_send = str_replace("###NAME###", $name , $content);
						$content_send = str_replace("###EMAIL###", $to, $content_send);
						$adminmailsubject = $form['elp_c_adminmailsubject'];	
						$adminmailcontant = $form['elp_c_adminmailcontant'];
						$adminmailcontant = str_replace("###NAME###", $name , $adminmailcontant);
						$adminmailcontant = str_replace("###EMAIL###", $to, $adminmailcontant);
						if ( $form['elp_c_mailtype'] == "WP HTML MAIL" || $form['elp_c_mailtype'] == "PHP HTML MAIL" )
						{
							$adminmailcontant = nl2br($adminmailcontant);
						}
						else
						{
							$adminmailcontant = str_replace("<br />", "\r\n", $adminmailcontant);
							$adminmailcontant = str_replace("<br>", "\r\n", $adminmailcontant);
						}	
						break;
						
					case 'newsletter':
						$unsublink = $form['elp_c_unsublink'];				
						$unsublink = str_replace("###DBID###", $subscriber["elp_email_id"], $unsublink);
						$unsublink = str_replace("###EMAIL###", $subscriber["elp_email_mail"], $unsublink);
						$unsublink = str_replace("###GUID###", $subscriber["elp_email_guid"], $unsublink);
						$unsublink  = $unsublink . "&cache=".$cacheid;
						
						$unsubtext = $form['elp_c_unsubtext'];
						$unsubtext = str_replace("###LINK###", $unsublink , $unsubtext);
						if ( $form['elp_c_mailtype'] == "WP HTML MAIL" || $form['elp_c_mailtype'] == "PHP HTML MAIL" )
						{
							$unsubtext = '<br>' . $unsubtext;
						}
						else
						{
							$unsubtext = '\n' . $unsubtext;
						}
						
						$returnid = elp_cls_dbquery2::elp_delivery_ins($sendguid, $subscriber["elp_email_id"], $subscriber["elp_email_mail"]);
						$viewstslink = str_replace("###DELVIID###", $returnid, $viewstatus);
						
						$content_send = str_replace("###EMAIL###", $subscriber["elp_email_mail"], $content);
						$content_send = str_replace("###NAME###", $subscriber["elp_email_name"], $content_send);	
						
						if ( $form['elp_c_mailtype'] == "WP HTML MAIL" || $form['elp_c_mailtype'] == "PHP HTML MAIL" )
						{
							$content_send = nl2br($content_send);
						}
						else
						{
							$content_send = str_replace("<br />", "\r\n", $content_send);
							$content_send = str_replace("<br>", "\r\n", $content_send);
						}	
						break;
				}
				
				if($wpmail) 
				{
					wp_mail($to, $subject, $content_send . $unsubtext . $viewstslink, $headers);
					if($type == "welcome" && $adminmail <> "" && $elp_c_adminmailoption == "YES")
					{
						wp_mail($adminmail, $adminmailsubject, $adminmailcontant, $headers);
					}
				}
				else
				{
					mail($to ,$subject, $content_send . $unsubtext . $viewstslink, $headers);
					if($type == "welcome" && $adminmail <> "" && $elp_c_adminmailoption == "YES")
					{
						mail($adminmail, $adminmailsubject, $adminmailcontant, $headers);
					}
				}
				$count = $count + 1;
			}
		}
		
		if( $type == "newsletter" )
		{
			$count = $count - 1;
			elp_cls_dbquery2::elp_sentmail_ups($sendguid);
			if($adminmail <> "")
			{
				$subject = elp_cls_common::elp_sent_report_subject();
				if($htmlmail)
				{
					$reportmail = elp_cls_common::elp_sent_report_html();
				}
				else
				{
					$reportmail = elp_cls_common::elp_sent_report_plain();
				}
				$enddate = date('Y-m-d G:i:s');
				$reportmail = str_replace("###COUNT###", $count, $reportmail);	
				$reportmail = str_replace("###UNIQUE###", $sendguid, $reportmail);	
				$reportmail = str_replace("###STARTTIME###", $currentdate, $reportmail);	
				$reportmail = str_replace("###ENDTIME###", $enddate, $reportmail);
				if($wpmail) 
				{
					wp_mail($adminmail, $subject, $reportmail, $headers);
				}
				else
				{
					mail($adminmail ,$subject, $reportmail, $headers);
				}
			}
		}
	}
}
?>