function _elp_addemail()
{
	if(document.form_addemail.elp_email_mail.value=="")
	{
		alert("Please enter email address.")
		document.form_addemail.elp_email_mail.focus();
		return false;
	}
	else if(document.form_addemail.elp_email_status.value=="" || document.form_addemail.elp_email_status.value=="Select")
	{
		alert("Please select the status.")
		document.form_addemail.elp_email_status.focus();
		return false;
	}
}

function _elp_delete(id, query)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_elp_display.action="admin.php?page=elp-view-subscribers&search="+query+"&ac=del&did="+id;
		document.frm_elp_display.submit();
	}
}

function _elp_redirect()
{
	window.location = "admin.php?page=elp-view-subscribers";
}

function _elp_help()
{
	window.open("http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/");
}

function _elp_resend(id,query)
{
	document.frm_elp_display.action="admin.php?page=elp-view-subscribers&ac=resend&search="+query+"&did="+id;
	document.frm_elp_display.submit();
}

function _elp_search_sts_action(sts)
{
	var searchquery = document.frm_elp_display.searchquery.value;
	var cnt = document.frm_elp_display.searchquery_cnt.value;
	document.frm_elp_display.frm_elp_bulkaction.value = 'search_sts';
	document.frm_elp_display.action="admin.php?page=elp-view-subscribers&search=" + searchquery + "&sts=" + sts + "&cnt=" + cnt;
	document.frm_elp_display.submit();
}

function _elp_search_count_action(cnt)
{
	var searchquery = document.frm_elp_display.searchquery.value;
	var sts = document.frm_elp_display.searchquery_sts.value;
	document.frm_elp_display.frm_elp_bulkaction.value = 'search_cnt';
	document.frm_elp_display.action="admin.php?page=elp-view-subscribers&search=" + searchquery + "&sts=" + sts + "&cnt=" + cnt;
	document.frm_elp_display.submit();
}

function _elp_bulkaction()
{
	if(document.frm_elp_display.bulk_action.value=="")
	{
		alert("Please select the bulk action."); 
		document.frm_elp_display.bulk_action.focus();
		return false;
	}
	
	if(document.frm_elp_display.bulk_action.value == "delete")
	{
		if(confirm("Do you want to delete selected record(s)?"))
		{
			if(confirm("Are you sure you want to delete?"))
			{
				var searchquery = document.frm_elp_display.searchquery.value;
				document.frm_elp_display.frm_elp_bulkaction.value = 'delete';
				document.frm_elp_display.action="admin.php?page=elp-view-subscribers&bulkaction=delete&search=" + searchquery;
				document.frm_elp_display.submit();
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	else if(document.frm_elp_display.bulk_action.value == "resend")
	{
		if(confirm("Do you want to resend confirmation email? \nAlso please note, this will update subscriber current status to 'Unconfirmed'."))
		{
			var searchquery = document.frm_elp_display.searchquery.value;
			document.frm_elp_display.frm_elp_bulkaction.value = 'resend';
			document.frm_elp_display.action="admin.php?page=elp-view-subscribers&bulkaction=resend&search=" + searchquery;
			document.frm_elp_display.submit();
		}
		else
		{
			return false;
		}
	}
}

function _elp_exportcsv(url, option)
{
	if(confirm("Do you want to export the emails?"))
	{
		document.frm_elp_subscriberexport.action= url+"&option="+option;
		document.frm_elp_subscriberexport.submit();
	}
	else
	{
		return false;
	}
}

function _elp_importemail()
{
	var filename = document.getElementById('elp_csv_name').value;
	var extension = filename.substr(filename.lastIndexOf('.')+1).toLowerCase();
	if(extension == 'csv') 
	{
        return true;
    } 
	else 
	{
        alert('Please select only csv file. \nPlease check official website for csv structure.');
        return false;
    }
}

function _elp_checkall(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}