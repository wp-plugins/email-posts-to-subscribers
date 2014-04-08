function _elp_redirect()
{
	window.location = "admin.php?page=elp-sendemail";
}

function _elp_help()
{
	window.open("http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/");
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

function _elp_mailsubject(guid)
{
	document.getElementById("guid").value = guid;
	document.getElementById("page").value = 1;
	document.elp_form.action="admin.php?page=elp-sendemail";
	document.elp_form.submit();
}

function _elp_mailpage(page)
{
	document.getElementById("guid").value = document.elp_form.guid.value;
	document.getElementById("page").value = page;
	document.elp_form.action="admin.php?page=elp-sendemail";
	document.elp_form.submit();
}

function _elp_submit()
{
	if(document.elp_form.elp_set_guid.value=="")
	{
		alert("Please select mail configuration.")
		document.elp_form.elp_set_guid.focus();
		return false;
	}
	
	if(confirm("Are you sure you want to send email to all selected email address?"))
	{
		document.getElementById("guid").value = document.elp_form.guid.value;
		document.getElementById("page").value = 1;
		document.getElementById("sendmailsubmit").value = "yes";
		document.elp_form.submit();
	}
	else
	{
		return false;
	}
}