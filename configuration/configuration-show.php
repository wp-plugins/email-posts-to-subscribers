<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_elp_display']) && $_POST['frm_elp_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$elp_success = '';
	$elp_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$result = elp_cls_dbquery::elp_configuration_count($did);
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', ELP_TDOMAIN); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('elp_form_show');
			
			//	Delete selected record from the table
			elp_cls_dbquery::elp_configuration_delete($did);
			
			//	Set success message
			$elp_success_msg = TRUE;
			$elp_success = __('Selected record was successfully deleted.', ELP_TDOMAIN);
		}
	}
	
	if ($elp_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $elp_success; ?></strong></p></div><?php
	}
}
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>configuration/configuration.js"></script>
<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
    <div class="tool-box">
	<h3><?php _e('Mail Configuration', ELP_TDOMAIN); ?>  
	<a class="add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-configuration&amp;ac=add"><?php _e('Add New', ELP_TDOMAIN); ?></a></h3>
	<?php
	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	$limit = 25;
	$offset = ($pagenum - 1) * $limit;
	$total = elp_cls_dbquery::elp_configuration_count(0);
	$fulltotal = $total;
	$total = ceil( $total / $limit );
	
	$myData = array();
	$myData = elp_cls_dbquery::elp_configuration_select(0, $offset, $limit);
	?>
	<form name="frm_elp_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="3%" class="check-column" scope="col" style="padding: 8px 2px;"><input type="checkbox" name="elp_group_item[]" /></th>
            <th scope="col"><?php _e('Mail Subject', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Template', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Send Count', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('No of Post', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Post Category', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Orderby', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Order', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Cron Details', ELP_TDOMAIN); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th width="3%" class="check-column" scope="col" style="padding: 8px 2px;"><input type="checkbox" name="elp_group_item[]" /></th>
            <th scope="col"><?php _e('Mail Subject', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Template', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Send Count', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('No of Post', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Post Category', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Orderby', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Order', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Cron Details', ELP_TDOMAIN); ?></th>
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
						<td align="left"><input type="checkbox" value="<?php echo $data['elp_set_id']; ?>" name="elp_group_item[]"></td>
					  	<td><?php echo esc_html(stripslashes($data['elp_set_name'])); ?>
						<div class="row-actions">
						<span class="edit">
						<a title="Edit" href="<?php echo ELP_ADMINURL; ?>?page=elp-configuration&amp;ac=edit&amp;did=<?php echo $data['elp_set_id']; ?>"><?php _e('Edit', ELP_TDOMAIN); ?></a> |
						<a title="Cron Links" href="<?php echo ELP_ADMINURL; ?>?page=elp-configuration&amp;ac=cron&amp;did=<?php echo $data['elp_set_id']; ?>"><?php _e('Cron Links', ELP_TDOMAIN); ?></a> |
						<a title="Send Mail" href="<?php echo ELP_ADMINURL; ?>?page=elp-sendemail"><?php _e('Send Mail', ELP_TDOMAIN); ?></a> |
						<a title="Preview" href="<?php echo ELP_ADMINURL; ?>?page=elp-configuration&amp;ac=preview&amp;did=<?php echo $data['elp_set_id']; ?>"><?php _e('Preview', ELP_TDOMAIN); ?></a>
						</span>
						<?php if($data['elp_set_id'] > 4) { ?>
						<span class="trash"> | <a onClick="javascript:_elp_delete('<?php echo $data['elp_set_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', ELP_TDOMAIN); ?></a></span> 
						</div>
						<?php } ?>
					  	</td>
						<td>
						<?php
						$Template = array();
						$Template = elp_cls_dbquery::elp_template_select($data['elp_set_templid']);
						echo $Template['elp_templ_heading'];
						?>
						</td>
						<td><?php echo $data['elp_set_totalsent']; ?></td>
						<td><?php echo $data['elp_set_postcount']; ?></td>
						<td><?php echo $data['elp_set_postcategory']; ?></td>
						<td><?php echo $data['elp_set_postorderby']; ?></td>
						<td><?php echo $data['elp_set_postorder']; ?></td>
						<td>
						<a title="Cron Details" href="<?php echo ELP_ADMINURL; ?>?page=elp-configuration&amp;ac=cron&amp;did=<?php echo $data['elp_set_id']; ?>"><?php _e('Cron Details', ELP_TDOMAIN); ?></a>
						</td>
					</tr>
					<?php
					$i = $i+1;
				}
			}
			else
			{
				?><tr><td colspan="8"><?php _e('No records available.', ELP_TDOMAIN); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
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
		<?php wp_nonce_field('elp_form_show'); ?>
		<input type="hidden" name="frm_elp_display" value="yes"/>
      </form>	
	  <div style="padding-top:10px;"></div>
	  <div class="tablenav">
		  <div class="alignleft">
			<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-configuration&amp;ac=add"><?php _e('Add New', ELP_TDOMAIN); ?></a>
			<a class="button add-new-h2" target="_blank" href="<?php echo ELP_FAV; ?>"><?php _e('Help', ELP_TDOMAIN); ?></a>
		  </div>
		  <div class="alignright">
				<?php echo $page_links; ?>
			</div>
	  </div>
	  <div style="height:10px;"></div>
	  <p class="description"><?php echo ELP_OFFICIAL; ?></p>
	</div>
</div>