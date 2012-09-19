<?php

class PageCommentEmailNotification extends DataObjectDecorator { 
	function onAfterWrite() { 
		parent::onAfterWrite();

	       $email = new Email(); 
			$email->setTemplate('NewComment'); 
			$email->setFrom(Email::getAdminEmail()); 
			$email->setTo(Email::getAdminEmail()); 
			// $email->addCustomHeader('Reply-To', Member::currentUser()->Email); 
			$email->setSubject('New Comment ' . str_replace(array("http://", "https://"), array("", ""), Director::absoluteBaseURL())); 
			$email->populateTemplate(array( 
				'URL' => Director::absoluteBaseURL() . $this->owner->Parent()->URLSegment, 
				'PageTitle' => $this->owner->Parent()->Title, 
				'Comment' => $this->owner->Comment, 
				'Name' => $this->owner->Name, 
			)); 
			$email->send(); 
		} 
}
