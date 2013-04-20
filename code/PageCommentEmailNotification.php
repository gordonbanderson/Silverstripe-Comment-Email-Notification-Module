<?php

class PageCommentEmailNotification extends DataExtension {
	function onAfterPostComment($comment) {
		$from = $comment->Email;
		$to = Email::getAdminEmail();
		$subject = SiteConfig::current_site_config()->Title.' - ';
		$subject .= 'New Comment has been posted';
		$email = new Email( $from, $to, $subject );
		$email->setTemplate('NewComment');
		$email->populateTemplate(array(
				'URL' => Director::absoluteBaseURL() . $comment->Link(),
				'PageTitle' => $comment->getParent()->Title,
				'Comment' => $comment->Comment,
				'Name' => $comment->Name,
				'EditLink' => Director::absoluteBaseURL().'admin/comments/EditForm/field/Comments/item/'.$comment->ID.'/edit'
		));
		$email->send();
	}
}
?>