<?php

class PageCommentEmailNotification extends DataExtension {
	function onAfterPostComment($comment) {
		$email = new Email();
		$email->setTemplate('NewComment');
		$email->setFrom(Email::getAdminEmail());
		$email->setTo(Email::getAdminEmail());
		$email->addCustomHeader('Reply-To', $comment->Email);
		$email->setSubject('New Comment ' . str_replace(array("http://", "https://"), array("", ""), Director::absoluteBaseURL()));

		$email->populateTemplate(array(
				'URL' => Director::absoluteBaseURL() . $comment->Link(),
				'PageTitle' => $comment->getParent()->Title,
				'Comment' => $comment->Comment,
				'Name' => $comment->Name
			));
		$email->send();
	}
}
