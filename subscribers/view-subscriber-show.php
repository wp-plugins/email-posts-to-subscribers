<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
$search = isset($_GET['search']) ? $_GET['search'] : 'A,B,C';
$search_sts = isset($_GET['sts']) ? $_GET['sts'] : '';
$search_count = isset($_GET['cnt']) ? $_GET['cnt'] : '1';

// ------------ Security check----------------------------------------------------------------
if(!is_numeric($search_count)) { die('<p>Security check failed. Are you sure you want to do this?</p>'); }
if(!is_numeric($search_count)) { die('<p>Security check failed. Are you sure you want to do this?</p>'); }
$search_nocomma = str_replace(",", "", $search);
if(preg_match('/[^a-z_\-0-9]/i', $search_nocomma))
{
	die('<p>Security check failed. Are you sure you want to do this?</p>');
}
if($search_sts != '' && $search_sts != 'Confirmed' 
	&& $search_sts != 'Unconfirmed' && $search_sts != 'Unsubscribed' && $search_sts != 'Single Opt In')
{
	die('<p>Security check failed. Are you sure you want to do this?</p>');
}
// ------------ Security check----------------------------------------------------------------

if (isset($_POST['frm_elp_display']) && $_POST['frm_elp_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$elp_success = '';
	$elp_success_msg = FALSE;
	if (isset($_POST['frm_elp_bulkaction']) && $_POST['frm_elp_bulkaction'] != 'delete' 
			&& $_POST['frm_elp_bulkaction'] != 'resend' && $_POST['frm_elp_bulkaction'] != 'groupupdate' 
				&& $_POST['frm_elp_bulkaction'] != 'search_sts' && $_POST['frm_elp_bulkaction'] != 'search_cnt')
	{	
		// First check if ID exist with requested ID
		$result = elp_cls_dbquery::elp_view_subscriber_count($did);
		if ($result != '1')
		{
			?>
			<div class="error fade">
			  <p><strong><?php _e('Oops, selected details doesnt exist.', ELP_TDOMAIN); ?></strong></p>
			</div>
			<?php
		}
		else
		{
			// Form submitted, check the action
			if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
			{
				//	Just security thingy that wordpress offers us
				check_admin_referer('elp_form_show');
				
				//	Delete selected record from the table
				elp_cls_dbquery::elp_view_subscriber_delete($did);
				
				//	Set success message
				$elp_success_msg = TRUE;
				$elp_success = __('Selected record was successfully deleted.', ELP_TDOMAIN);
			}
			
			if (isset($_GET['ac']) && $_GET['ac'] == 'resend' && isset($_GET['did']) && $_GET['did'] != '')
			{
				$did = isset($_GET['did']) ? $_GET['did'] : '0';
				$setting = array();
				$setting = elp_cls_dbquery2::elp_setting_select(1);
				if($setting['elp_c_optinoption'] <> "Double Opt In")
				{
					?>
					<div class="error fade">
					  <p><strong><?php _e('To send confirmation mail, Please change the Opt-in option to Double Opt In.', ELP_TDOMAIN); ?></strong></p>
					</div>
					<?php
				}
				else
				{
					elp_cls_sendmail::elp_prepare_optin("single", $did, "");
					elp_cls_dbquery::elp_view_subscriber_upd_status("Unconfirmed", $did);
					$elp_success_msg = TRUE;
					$elp_success  = __('Confirmation email resent successfully.', ELP_TDOMAIN);
				}
			}
		}
	}
	else
	{
		check_admin_referer('elp_form_show');
		
		if (isset($_POST['frm_elp_bulkaction']) && $_POST['frm_elp_bulkaction'] == 'delete')
		{
			$chk_delete = isset($_POST['chk_delete']) ? $_POST['chk_delete'] : '';
			if(!empty($chk_delete))
			{			
				$count = count($chk_delete);
				for($i=0; $i<$count; $i++)
				{
					$del_id = $chk_delete[$i];
					elp_cls_dbquery::elp_view_subscriber_delete($del_id);
				}
				
				//	Set success message
				$elp_success_msg = TRUE;
				$elp_success = __('Selected record was successfully deleted.', ELP_TDOMAIN);
			}
			else
			{
				?>
				<div class="error fade">
				  <p><strong><?php _e('Oops, No record was selected.', ELP_TDOMAIN); ?></strong></p>
				</div>
				<?php
			}
		}
		elseif (isset($_POST['frm_elp_bulkaction']) && $_POST['frm_elp_bulkaction'] == 'resend')
		{
			$chk_delete = isset($_POST['chk_delete']) ? $_POST['chk_delete'] : '';
			
			$setting = array();
			$setting = elp_cls_dbquery2::elp_setting_select(1);
			if($setting['elp_c_optinoption'] <> "Double Opt In")
			{
				?>
				<div class="error fade">
				  <p><strong><?php _e('To send confirmation mail, Please change the Opt-in option to Double Opt In.', ELP_TDOMAIN); ?></strong></p>
				</div>
				<?php
			}
			else
			{
				if(!empty($chk_delete))
				{			
					$count = count($chk_delete);
					$idlist = "";
					for($i = 0; $i<$count; $i++)
					{
						$del_id = $chk_delete[$i];
						if($i < 1)
						{
							$idlist = $del_id;
						}
						else
						{
							$idlist = $idlist . ", " . $del_id;
						}
					}
					elp_cls_sendmail::elp_prepare_optin("group", 0, $idlist);
					elp_cls_dbquery::elp_view_subscriber_upd_status("Unconfirmed", $idlist);
					$elp_success_msg = TRUE;
					$elp_success = __('Confirmation email(s) resent successfully.', ELP_TDOMAIN);
				}
				else
				{
					?>
					<div class="error fade">
					  <p><strong><?php _e('Oops, No record was selected.', ELP_TDOMAIN); ?></strong></p>
					</div>
					<?php
				}
			}
		}
		elseif (isset($_POST['frm_elp_bulkaction']) && $_POST['frm_elp_bulkaction'] == 'search_sts')
		{
			// Nothing
		}
		elseif (isset($_POST['frm_elp_bulkaction']) && $_POST['frm_elp_bulkaction'] == 'search_cnt')
		{
			// Nothing
		}
	}
	
	if ($elp_success_msg == TRUE)
	{
		?>
		<div class="updated fade">
		  <p><strong><?php echo $elp_success; ?></strong></p>
		</div>
		<?php
	}
}
?>
<script language="javaScript" src="<?php echo ELP_URL; ?>subscribers/view-subscriber.js"></script>
<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
  <h2><?php _e(ELP_PLUGIN_DISPLAY, ELP_TDOMAIN); ?></h2>
  <div class="tool-box">
  <h3><?php _e('View subscriber', ELP_TDOMAIN); ?> 
  <a class="add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers&amp;ac=add"><?php _e('Add New', ELP_TDOMAIN); ?></a></h3>
	<?php
	$myData = array();
	$offset = 0;
	$limit = 200;
	if ($search_count == 0)
	{
		$limit = 9999;
	}
	if ($search_count > 1)
	{
		$offset = $search_count;
	}
	$myData = elp_cls_dbquery::elp_view_subscriber_search2($search, 0, $search_sts, $offset, $limit);
	?>
	<div class="tablenav">
		<span style="text-align:left;">
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=A,B,C">A,B,C</a>&nbsp;&nbsp; 
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=D,E,F">D,E,F</a>&nbsp;&nbsp; 
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=G,H,I">G,H,I</a>&nbsp;&nbsp; 
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=J,K,L">J,K,L</a>&nbsp;&nbsp; 
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=M,N,O">M,N,O</a>&nbsp;&nbsp; 
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=P,Q,R">P,Q,R</a>&nbsp;&nbsp; 
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=S,T,U">S,T,U</a>&nbsp;&nbsp; 
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=V,W,X,Y,Z">V,W,X,Y,Z</a>&nbsp;&nbsp; 
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=0,1,2,3,4,5,6,7,8,9">0-9</a>&nbsp;&nbsp; 
			<a class="button add-new-h2" href="admin.php?page=elp-view-subscribers&search=A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,0,1,2,3,4,5,6,7,8,9">ALL</a> 
		<span>
		<span style="float:right;">
			<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers&amp;ac=add"><?php _e('Add New', ELP_TDOMAIN); ?></a> 
			<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers&amp;ac=import"><?php _e('Import Email', ELP_TDOMAIN); ?></a> 
			<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers&amp;ac=export"><?php _e('Export Email (CSV)', ELP_TDOMAIN); ?></a> 
			<a class="button add-new-h2" target="_blank" href="<?php echo ELP_FAV; ?>"><?php _e('Help', ELP_TDOMAIN); ?></a> 
		</span>
    </div>
    <form name="frm_elp_display" method="post" onsubmit="return _elp_bulkaction()">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col" style="padding: 8px 2px;">
			<input type="checkbox" name="elp_checkall" id="elp_checkall" onClick="_elp_checkall('frm_elp_display', 'chk_delete[]', this.checked);" /></th>
            <th scope="col"><?php _e('Sno', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Email', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Name', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Status', ELP_TDOMAIN); ?></th>
            <th scope="col"><?php _e('Database ID', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Action', ELP_TDOMAIN); ?></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th class="check-column" scope="col" style="padding: 8px 2px;">
			<input type="checkbox" name="elp_checkall" id="elp_checkall" onClick="_elp_checkall('frm_elp_display', 'chk_delete[]', this.checked);" /></th>
            <th scope="col"><?php _e('Sno', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Email address', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Name', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Status', ELP_TDOMAIN); ?></th>
            <th scope="col"><?php _e('Database ID', ELP_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Action', ELP_TDOMAIN); ?></th>
          </tr>
        </tfoot>
        <tbody>
          <?php 
			$i = 0;
			$displayisthere = FALSE;
			if(count($myData) > 0)
			{
				if ($offset == 0)
				{
					$i = 1;
				}
				else
				{
					$i = $offset;
				}
				foreach ($myData as $data)
				{					
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
					<td align="left"><input name="chk_delete[]" id="chk_delete[]" type="checkbox" value="<?php echo $data['elp_email_id'] ?>" /></td>
					<td><?php echo $i; ?></td>
					<td><?php echo $data['elp_email_mail']; ?></td>
					<td><?php echo $data['elp_email_name']; ?></td>     
					<td><?php echo elp_cls_common::elp_disp_status($data['elp_email_status']); ?></td>
					<td><?php echo $data['elp_email_id']; ?></td>
					<td><div> 
					<span class="edit">
						<a title="Edit" href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers&amp;ac=edit&search=<?php echo $search; ?>&amp;did=<?php echo $data['elp_email_id']; ?>&sts=<?php echo $search_sts; ?>&cnt=<?php echo $search_count; ?>">
					<?php _e('Edit', ELP_TDOMAIN); ?></a> | </span> 
					<span class="trash">
					<a onClick="javascript:_elp_delete('<?php echo $data['elp_email_id']; ?>','<?php echo $search; ?>')" href="javascript:void(0);">
					<?php _e('Delete', ELP_TDOMAIN); ?></a>
					</span>
					<?php
					if($data['elp_email_status'] != "Confirmed")
					{
						?>
						<span class="edit"> 
						| <a onClick="javascript:_elp_resend('<?php echo $data['elp_email_id']; ?>','<?php echo $search; ?>')" href="javascript:void(0);">
						<?php _e('Resend Confirmation', ELP_TDOMAIN); ?></a>
						</span> 
						<?php
					}
					?>
					</div>
					</td>
					</tr>
					<?php
					$i = $i+1;
				} 
			}
			else
			{
				?>
				<tr>
					<td colspan="7" align="center"><?php _e('No records available. Please use the above alphabet search button to search.', ELP_TDOMAIN); ?></td>
				</tr>
				<?php 
			}
			?>
        </tbody>
      </table>
      <?php wp_nonce_field('elp_form_show'); ?>
      <input type="hidden" name="frm_elp_display" value="yes"/>
	  <input type="hidden" name="frm_elp_bulkaction" value=""/>
	  <input name="searchquery" id="searchquery" type="hidden" value="<?php echo $search; ?>" />
	  <input name="searchquery_sts" id="searchquery_sts" type="hidden" value="<?php echo $search_sts; ?>" />
	  <input name="searchquery_cnt" id="searchquery_cnt" type="hidden" value="<?php echo $search_count; ?>" />
	<div style="padding-top:10px;"></div>
    <div class="tablenav">
		<div class="alignleft">
			<select name="bulk_action" id="bulk_action">
				<option value=""><?php _e('Bulk Actions', ELP_TDOMAIN); ?></option>
				<option value="delete"><?php _e('Delete', ELP_TDOMAIN); ?></option>
				<option value="resend"><?php _e('Resend Confirmation', ELP_TDOMAIN); ?></option>
			</select>
			<input type="submit" value="<?php _e('Apply', ELP_TDOMAIN); ?>" class="button action" id="doaction" name="">
			<select name="search_sts_action" id="search_sts_action" onchange="return _elp_search_sts_action(this.value)">
				<option value=""><?php _e('View all status', ELP_TDOMAIN); ?></option>
				<option value="Confirmed" <?php if($search_sts=='Confirmed') { echo 'selected="selected"' ; } ?>><?php _e('Confirmed', ELP_TDOMAIN); ?></option>
				<option value="Unconfirmed" <?php if($search_sts=='Unconfirmed') { echo 'selected="selected"' ; } ?>><?php _e('Unconfirmed', ELP_TDOMAIN); ?></option>
				<option value="Unsubscribed" <?php if($search_sts=='Unsubscribed') { echo 'selected="selected"' ; } ?>><?php _e('Unsubscribed', ELP_TDOMAIN); ?></option>
				<option value="Single Opt In" <?php if($search_sts=='Single Opt In') { echo 'selected="selected"' ; } ?>><?php _e('Single Opt In', ELP_TDOMAIN); ?></option>
			</select>
			<select name="search_count_action" id="search_count_action" onchange="return _elp_search_count_action(this.value)">
				<option value="1" <?php if($search_count=='1') { echo 'selected="selected"' ; } ?>>1 to 200 emails</option>
				<option value="201" <?php if($search_count=='201') { echo 'selected="selected"' ; } ?>>201 to 400 emails</option>
				<option value="401" <?php if($search_count=='401') { echo 'selected="selected"' ; } ?>>401 to 600 emails</option>
				<option value="601" <?php if($search_count=='601') { echo 'selected="selected"' ; } ?>>601 to 800 emails</option>
				<option value="801" <?php if($search_count=='801') { echo 'selected="selected"' ; } ?>>801 to 1000 emails</option>
				<option value="0" <?php if($search_count=='0') { echo 'selected="selected"' ; } ?>>display all</option>
			</select>
		</div>
		<div class="alignright">
			<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers&amp;ac=add"><?php _e('Add New', ELP_TDOMAIN); ?></a> 
			<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers&amp;ac=import"><?php _e('Import Email', ELP_TDOMAIN); ?></a> 
			<a class="button add-new-h2" href="<?php echo ELP_ADMINURL; ?>?page=elp-view-subscribers&amp;ac=export"><?php _e('Export Email (CSV)', ELP_TDOMAIN); ?></a> 
			<a class="button add-new-h2" target="_blank" href="<?php echo ELP_FAV; ?>"><?php _e('Help', ELP_TDOMAIN); ?></a> 
		</div>
    </div>
	</form>
    <p class="description"><?php echo ELP_OFFICIAL; ?></p>
  </div>
</div>