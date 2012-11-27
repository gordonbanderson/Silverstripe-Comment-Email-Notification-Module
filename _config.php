<?php
//DataObject::add_extension('PageComment','PageCommentDecorator');
DataObject::add_extension('CommentingController', 'PageCommentEmailNotification');
//Director::addRules(50, array( 'admin/comments//$Action/$ID' => 'CommentAdminExtension', )); 
//CMSMenu::remove_menu_item('CommentAdmin'); 
?>