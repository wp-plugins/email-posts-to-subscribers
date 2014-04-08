<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<script language="javaScript" src="<?php echo ELP_URL; ?>subscribers/view-subscriber.js"></script>
<?php
if (!session_id())
{
    session_start();
}
$_SESSION['elp_exportcsv'] = "YES"; 
$home_url = home_url('/');
$cnt_subscriber = 0;
$cnt_users = 0;
$cnt_comment_author = 0;
$cnt_subscriber = elp_cls_dbquery::elp_view_subscriber_count(0);
$cnt_users = $wpdb->get_var("select count(DISTINCT user_email) from ". $wpdb->prefix . "users");
$cnt_comment_author = $wpdb->get_var("SELECT count(DISTINCT comment_author_email) from ". $wpdb->prefix . "comments WHERE comment_author_email <> ''");
?>

<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
  <h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
  <div class="tool-box">
  <h3 class="title"><?php _e('Export email address in csv format', ELP_TDOMAIN); ?></h3>
  <form name="frm_elp_subscriberexport" method="post">
  <table width="100%" class="widefat" id="straymanage">
    <thead>
      <tr>
        <th width="3%" class="check-column" scope="col"><input type="checkbox" name="eemail_group_item[]" /></th>
        <th scope="col"><?php _e('Sno', ELP_TDOMAIN); ?></th>
        <th scope="col"><?php _e('Export option', ELP_TDOMAIN); ?></th>
		<th scope="col"><?php _e('Total email', ELP_TDOMAIN); ?></th>
        <th scope="col"><?php _e('Action', ELP_TDOMAIN); ?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th width="3%" class="check-column" scope="col"><input type="checkbox" name="eemail_group_item[]" /></th>
        <th scope="col"><?php _e('Sno', ELP_TDOMAIN); ?></th>
        <th scope="col"><?php _e('Export option', ELP_TDOMAIN); ?></th>
		<th scope="col"><?php _e('Total email', ELP_TDOMAIN); ?></th>
        <th scope="col"><?php _e('Action', ELP_TDOMAIN); ?></th>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <td><input type="checkbox" value="" name="eemail_group_item[]"></td>
        <td>1</td>
        <td><?php _e('Subscriber email address', ELP_TDOMAIN); ?></td>
		<td><?php echo $cnt_subscriber; ?></td>
        <td><a onClick="javascript:_elp_exportcsv('<?php echo $home_url. "?elp=export"; ?>', 'view_subscriber')" href="javascript:void(0);"><?php _e('Click to export csv', ELP_TDOMAIN); ?></a> </td>
      </tr>
      <tr class="alternate">
        <td><input type="checkbox" value="" name="eemail_group_item[]"></td>
        <td>2</td>
        <td><?php _e('Registered email address', ELP_TDOMAIN); ?></td>
		<td><?php echo $cnt_users; ?></td>
        <td><a onClick="javascript:_elp_exportcsv('<?php echo $home_url. "?elp=export"; ?>', 'registered_user')" href="javascript:void(0);"><?php _e('Click to export csv', ELP_TDOMAIN); ?></a> </td>
      </tr>
      <tr>
        <td><input type="checkbox" value="" name="eemail_group_item[]"></td>
        <td>3</td>
        <td><?php _e('Comments author email address', ELP_TDOMAIN); ?></td>
		<td><?php echo $cnt_comment_author; ?></td>
        <td><a onClick="javascript:_elp_exportcsv('<?php echo $home_url. "?elp=export"; ?>', 'commentposed_user')" href="javascript:void(0);"><?php _e('Click to export csv', ELP_TDOMAIN); ?></a> </td>
      </tr>
    </tbody>
  </table>
  </form>
  <div class="tablenav">
	  <h2>
		<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>/wp-admin/admin.php?page=elp-view-subscribers&amp;ac=add"><?php _e('Add Email', ELP_TDOMAIN); ?></a> 
		<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>/wp-admin/admin.php?page=elp-view-subscribers&amp;ac=import"><?php _e('Import Email', ELP_TDOMAIN); ?></a>
		<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>/wp-admin/admin.php?page=elp-view-subscribers"><?php _e('Back', ELP_TDOMAIN); ?></a>
		<a class="button add-new-h2" target="_blank" href="<?php echo ELP_FAV; ?>"><?php _e('Help', ELP_TDOMAIN); ?></a>
	  </h2>
  </div>
  <div style="height:10px;"></div>
  <p class="description"><?php echo ELP_OFFICIAL; ?></p>
  </div>
</div>