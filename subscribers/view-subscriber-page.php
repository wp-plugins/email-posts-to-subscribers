<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
$pg = isset($_GET['pg']) ? $_GET['pg'] : '1';
$tot = isset($_GET['tot']) ? $_GET['tot'] : '100';
$did = isset($_GET['did']) ? $_GET['did'] : '1';
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>subscribers/view-subscriber.js"></script>
<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
  <h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
  <div class="tool-box">
  <h3><?php _e('View subscriber', ELP_TDOMAIN); ?></h3>
	<table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="chk_delete[]" id="chk_delete[]" /></th>
            <th scope="col"><?php _e('Sno', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Email', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Name', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Status', ELP_TDOMAIN); ?></th>
            <th scope="col"><?php _e('Database ID', ELP_TDOMAIN); ?></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="chk_delete[]" id="chk_delete[]" /></th>
            <th scope="col"><?php _e('Sno', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Email address', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Name', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Status', ELP_TDOMAIN); ?></th>
            <th scope="col"><?php _e('Database ID', ELP_TDOMAIN); ?></th>
          </tr>
        </tfoot>
		<?php
		$subscribers = array();
		$offset = ($pg - 1) * $tot;
		$subscribers = elp_cls_dbquery::elp_view_subscriber_cron($offset, $tot);	
		$i = 1;
		if(count($subscribers) > 0)
		{
			foreach ($subscribers as $data)
			{
				?>
				<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
					<td align="left"><input name="chk_delete[]" id="chk_delete[]" type="checkbox" value="<?php echo $data['elp_email_id'] ?>" /></td>
					<td><?php echo $i; ?></td>
					<td><?php echo $data['elp_email_mail']; ?></td>
					<td><?php echo $data['elp_email_name']; ?></td>     
					<td><?php echo elp_cls_common::elp_disp_status($data['elp_email_status']); ?></td>
					<td><?php echo $data['elp_email_id']; ?></td>
				</tr>
				<?php
				$i = $i+1;
			}
		}
		else
		{
			?>
			<tr>
				<td colspan="6" align="center"><?php _e('No records available.', ELP_TDOMAIN); ?></td>
			</tr>
			<?php 
		}
		?>
		</tbody>
      </table>
	<div style="padding-top:10px;"></div>
    <div class="tablenav">
		<div class="alignleft">
			<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-configuration&ac=cron&did=<?php echo $did; ?>"><?php _e('Back', ELP_TDOMAIN); ?></a> &nbsp;
			<a class="button add-new-h2" target="_blank" href="<?php echo ELP_FAV; ?>"><?php _e('Help', ELP_TDOMAIN); ?></a> 
		</div>
    </div>
 	<p class="description"><?php echo ELP_OFFICIAL; ?></p>
  </div>
</div>