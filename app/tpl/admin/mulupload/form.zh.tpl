<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
        <?=$v['title']?>
        </title>
        <link href="css/default.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="swfupload/swfupload.js"></script>
        <script type="text/javascript" src="scripts/swfupload.queue.js"></script>
        <script type="text/javascript" src="scripts/fileprogress.js"></script>
        <script type="text/javascript" src="scripts/handlers.js"></script>
        <script type="text/javascript">
            var swfu;

            window.onload = function() {
                var settings = {
                    flash_url : "swfupload/swfupload.swf",
                    upload_url: "upload.php?assoc_id=<?php echo $v['assoc_id']; ?>&cate_id=<?php echo $v['cate_id']; ?>",
                    post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
                    file_size_limit : "100 MB",
                    file_types : "*.*",
                    file_types_description : "All Files",
                    file_upload_limit : 100,
                    file_queue_limit : 0,
                    custom_settings : {
                        progressTarget : "fsUploadProgress", 
                        upload_target : "divFileProgressContainer",
                        cancelButtonId : "btnCancel"
                    },
                    debug: false,

                    // Button settings
                    button_image_url: "images/TestImageNoText_65x29.png",
                    button_width: "65",
                    button_height: "29",
                    button_placeholder_id: "spanButtonPlaceHolder",
                    button_text: '<span class="theFont">浏览</span>',
                    button_text_style: ".theFont { font-size: 16; }",
                    button_text_left_padding: 12,
                    button_text_top_padding: 3,
				
                    // The event handler functions are defined in handlers.js
                    file_queued_handler : fileQueued,
                    file_queue_error_handler : fileQueueError,
                    file_dialog_complete_handler : fileDialogComplete,
                    upload_start_handler : uploadStart,
                    upload_progress_handler : uploadProgress,
                    upload_error_handler : uploadError,
                    upload_success_handler : uploadSuccess,
                    upload_complete_handler : uploadComplete,
                    queue_complete_handler : queueComplete	// Queue plugin event
                };

                swfu = new SWFUpload(settings);
            };
        </script>
        </head>

        <body>
<?php plugin('admin_header');?>
<form id="main_form" name="main_form" action="<?=$v['form_act'];?>" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
          <td width="180" valign="top" bgcolor="#a0c6e5" id='left_menu' height='600'><?php echo plugin('admin_menu','图片管理');?> 
    <script language="JavaScript" type="text/javascript">var m = new Menu('menu');</script></td>
          <td width="8" valign="top"><img src="imgs/icon/arr_l.gif" width="8" height="14" border='0' onclick="switchBar('left_menu',this);" style="cursor:pointer;" /></td>
          <td valign="top"><div class="winbox">
    <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
        <h1>
            <?=$v['title']?>
        </h1>
        <div class="boxcontent">
            <div id="content">
                <h2>上传相册图片</h2>
                <form id="form1" action="<?= $v['form_act']; ?>" method="post" enctype="multipart/form-data">
                    <input name="item[assoc_id]" type="hidden" id="item[assoc_id]" value="<?= $v['item']['assoc_id'] ?>" />
                    <input name="item[cate_id]" type="hidden" id="item[cate_id]" value="<?= $v['item']['cate_id'] ?>" />
                    <p></p>
                    <div class="fieldset flash" id="fsUploadProgress"> <span class="legend">Upload Queue</span>
                        <div id="thumbnails">
                        <div id="submitbuttion"></div>
                        </div>
                    </div>
                    <div id="divStatus">0 Files Uploaded</div>
                    <div> 
                        <span id="spanButtonPlaceHolder"></span>
                    <input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
                    <input name="submit" type="submit" value="确定上传图片" id="submit" />
                    <?php echo $v['btn']; ?> </div>
                    <div id="divFileProgressContainer" style="height: 75px;">
                    </div>
                </form>
            </div>
        </div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
</td>
</tr>
</table>
</form>
</body>
</html>
