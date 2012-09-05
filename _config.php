<?php
DataObject::add_extension('PageComment','PageCommentDecorator');
Director::addRules(50, array( 'admin/comments//$Action/$ID' => 'CommentAdminExtension', )); 
CMSMenu::remove_menu_item('CommentAdmin'); 
?>
