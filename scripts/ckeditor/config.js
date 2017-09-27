/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.toolbar_MyToolbar =   
    [   
        ['NewPage','Preview'],   
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Scayt'],   
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],  
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],  		
        ['Image','Flash','HorizontalRule','Smiley','SpecialChar','PageBreak'],   
        '/',   
        ['Styles','Format'],   
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],  
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],   
        ['Link','Unlink','Anchor'],   
        ['Maximize','-','About']   
    ];   

};
