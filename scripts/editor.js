var currentTextArea = null
function openEditor(id) {
	// location of edit.php file:
	var editFile = 'scripts/editor/edit.php';	
	currentTextArea = document.getElementById(id);
	var edit = window.open(editFile, 'editorWindow', 'width=720, height=450, resizable=1');
	edit.focus();
}
var image_action = true 
function openImageWindow(cbFunc, previewId, elementId ) { 
   
    wp_openDialog('scripts/editor/dialog_frame.php?window=image.php&return_function=' + cbFunc+'&previewId=' + previewId+'&elementId=' + elementId, 'modal',730,450) 
}  
function insertImg(iurl, iwidth, iheight, ialign, ialt, iborder, imargin, previewId, elementId) { 
    
    self.document.getElementById(elementId).value=iurl;
	
	self.document.getElementById(previewId).innerHTML = loadMedia(previewId, iurl);
}

function openDocWindow() { 
    wp_openDialog('scripts/editor/dialog_frame.php?window=document.php&return_function=insertDoc', 'modal',730,450) 
} 
function insertDoc(iHref,iTarget,iTitle) { 
    document.main_form.document.value=iHref; 
}