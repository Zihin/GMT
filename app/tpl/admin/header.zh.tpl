<link href="scripts/global.css" rel="stylesheet" type="text/css" />
<link href="scripts/admin_menu.css" rel="stylesheet" type="text/css" />
<script src="scripts/myjs/base.js"></script>
<script src="scripts/myjs/menu.js"></script>
<script language="javascript">
function switchBar(bid, icon){
	//打开/关闭窗口
	var f = $(bid);
	var icon = $(icon);
	if("none" != f.style.display){
		f.style.display="none"
		icon.src="imgs/icon/arr_r.gif";
	}else{
		f.style.display=""
		icon.src="imgs/icon/arr_l.gif";
	}
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#336699">
  <tr>
    <td align="left" valign="top" style="padding:7px;font:bold 12px '宋体';color: #eff;">欢迎你,
        <?php $sess = Session :: singleton(); echo $sess->get('username');?>
      <em>(<?= $sess->get('groupname');?>)</em></td>
    <td align="right" valign="top"><span id="time" style="padding:3px 10px 0 5px;color: #eff;font-size:12px;"></span>
        <script language="JavaScript" type="text/javascript">
function showTime(){
	var d = new Date();
	document.getElementById('time').innerHTML= d.getFullYear() + '年' + (d.getMonth()+1) + '月' + d.getDate() + '日 ' + d.getHours() +':'+d.getMinutes();
	setTimeout('showTime();',20000);
}
showTime();
  </script>
      <input type="button" name="logoff" value=" 退出 " class="btn_b" onclick="location.replace('admincp.php?default,logoff');" /></td>
  </tr>
</table>