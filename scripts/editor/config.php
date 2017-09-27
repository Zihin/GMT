<?php
/* /////////////////////////////////////////////////////////////////////////
*                             		config.php
*                              -------------------
*  author      : Chris Bolt
*  copyright   : (C) Chris Bolt 2004. All Rights Reserved
*  version     : 2.2.4
*	purpose 		: WYSIWYG PRO PHP configuration file
///////////////////////////////////////////////////////////////////////////*/
include_once('../../app/etc/editor_cfg.php');
// -----------------------------------------------------
// Advanced variables, no need to change anything below unless something's not working!!! 

define('WP_FILE_DIRECTORY',  dirname(__FILE__) . '/');   // file path to this folder
define('SAVE_DIRECTORY', WP_FILE_DIRECTORY.'save/');     // where to store cached configurations
define('SAVE_LENGTH', 9000);                             // length of time to cache configurations for
define('NOCACHE', true);                                 // whether to send nocache headers to prevent proxy servers from sending the wrong content to browsers
define('CHMOD_MODE', 0);                                 // chmod settings for new directories, you shouldn't need to set this as settings should be inherited from the parent directory

//-----------------------------------------------------
// do not change anything below here!
define('WP_CONFIG', true);   
global $wp_has_been_previous;
$wp_has_been_previous = false;
?>