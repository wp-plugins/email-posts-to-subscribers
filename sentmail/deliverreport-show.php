<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<script language="javaScript" src="<?php echo ELP_URL; ?>sentmail/sentmail.js"></script>
<?php
$sentguid = isset($_GET['sentguid']) ? $_GET['sentguid'] : '';
if ($sentguid == '')
{
	?>
	<div class="error fade">
	  <p><strong><?php _e('Oops.. Unexpected error occurred. Please try again.', ELP_TDOMAIN); ?></strong></p>
	</div>
	<?php
}
?>
<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
	<h3><?php _e('Mail Delivery Report', ELP_TDOMAIN); ?></h3>
    <div class="tool-box">
	<?php
	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	$limit = 100;
	$offset = ($pagenum - 1) * $limit;
	$total = elp_cls_dbquery2::elp_delivery_count($sentguid);
	$fulltotal = $total;
	$total = ceil( $total / $limit );

	$myData = array();
	$myData = elp_cls_dbquery2::elp_delivery_select($sentguid, $offset, $limit);
	?>
	<form name="frm_elp_display" method="post" onsubmit="return _elp_bulkaction()">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="3%" class="check-column" scope="col" style="padding: 8px 2px;"><input type="checkbox" name="elp_group_item[]" /></th>
			<th scope="col"><?php _e('Email', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Sent Date', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Viewed Status', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Viewed Date', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Database ID', ELP_TDOMAIN); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th width="3%" class="check-column" scope="col" style="padding: 8px 2px;"><input type="checkbox" name="elp_group_item[]" /></th>
			<th scope="col"><?php _e('Email', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Sent Date', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Viewed Status', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Viewed Date', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Database ID', ELP_TDOMAIN); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0)
			{
				$i = 1;
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['elp_deliver_id']; ?>" name="elp_group_item[]"></td>
					  	<td><?php echo $data['elp_deliver_emailmail']; ?></td>
						<td><?php echo $data['elp_deliver_sentdate']; ?></td>
						<td><?php echo elp_cls_common::elp_disp_status($data['elp_deliver_status']); ?></td>
						<td><?php echo $data['elp_deliver_viewdate']; ?></td>
						<td><?php echo $data['elp_deliver_emailid']; ?></td>
					</tr>
					<?php
					$i = $i+1;
				}
			}
			else
			{
				?><tr><td colspan="6" align="center"><?php _e('No records available.', ELP_TDOMAIN); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('elp_form_show'); ?>
		<input type="hidden" name="frm_elp_display" value="yes"/>
		<div style="padding-top:10px;"></div>
		<?php
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'pagenum', '%#%' ),
			'format' => '',
			'prev_text' => __( ' &lt;&lt; ' ),
			'next_text' => __( ' &gt;&gt; ' ),
			'total' => $total,
			'show_all' => False,
			'current' => $pagenum
		) );
		?>
		<style>
		.page-numbers {
			background: none repeat scroll 0 0 #E0E0E0;
    		border-color: #CCCCCC;
			color: #555555;
    		padding: 5px;
			text-decoration:none;
			margin-left:2px;
			margin-right:2px;
		}
		.current {
			background: none repeat scroll 0 0 #BBBBBB;
		}
		</style>
		<div class="tablenav">
			<div class="alignleft">
				<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-sentmail"><?php _e('Back', ELP_TDOMAIN); ?></a> &nbsp;
				<a class="button add-new-h2" target="_blank" href="<?php echo ELP_FAV; ?>"><?php _e('Help', ELP_TDOMAIN); ?></a> 
			</div>
			<div class="alignright">
				<?php echo $page_links; ?>
			</div>
		</div>
      </form>
	  <p class="description"><?php echo ELP_OFFICIAL; ?></p>
	</div>
</div>