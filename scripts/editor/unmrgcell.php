<?php
include_once ('./config.php');
include_once('./editor_functions.php');
include_once ('./includes/common.php');
include_once ('./lang/'.$lang_include);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Unmerge Cell</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?=WP_WEB_DIRECTORY; ?>dialoge_theme.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="<?=WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?=WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script type="text/javascript" language="JavaScript">
<!--//
function end() {
	if (document.getElementById('right').checked) {
		parentWindow.wp_unMergeRight(obj);
	} else if (document.getElementById('below').checked) {
		parentWindow.wp_unMergeDown(obj);
	}
	window.close();
	return false;
}
//-->
</script>
</head>
<body onLoad="hideLoadMessage();">
<?php include('./includes/load_message.php'); ?>
<div class="dialog_content" align="center"> 
	<form name="add_form" id="add_form" onSubmit="return end()">
		<fieldset>
		<legend><?=$lang['unmerge_cell2']; ?></legend>
		<table id="background" width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr> 
				<td><p> 
						<input id="right" type="radio" name="where" value="right" checked="checked" />
						<?=$lang['unmerge_right']; ?></p>
					<p> 
						<input id="below" type="radio" name="where" value="below" />
						<?=$lang['unmerge_below']; ?></p></td>
			</tr>
		</table>
		</fieldset>
		<br />
		<div align="center"> 
			<button type="submit" id="ok"><?=$lang['ok']; ?></button>
			&nbsp; 
			<button type="button" onClick="window.close();"><?=$lang['cancel']; ?></button>
		</div>
	</form>
</div>
</body>
</html>
