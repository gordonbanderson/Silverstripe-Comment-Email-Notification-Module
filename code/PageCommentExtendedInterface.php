<?php
class PageCommentExtendedInterface extends PageCommentInterface {
     
   function PostCommentForm() {
            $fields = new FieldSet(
            new HiddenField("ParentID", "ParentID", $this->page->ID)
        );
         
        $member = Member::currentUser();
         
        if((self::$comments_require_login || self::$comments_require_permission) && $member && $member->FirstName) {
            // note this was a ReadonlyField - which displayed the name in a span as well as the hidden field but
            // it was not saving correctly. Have changed it to a hidden field. It passes the data correctly but I 
            // believe the id of the form field is wrong.
            $nameTaf = new ReadonlyField("NameView", _t('PageCommentInterface.YOURNAME', 'Your name'), $member->getName());
            $nameTaf->addExtraClass('span12');
            $fields->push($nameTaf);
            $fields->push(new HiddenField("Name", "", $member->getName()));
        } else {
            $taf = new TextField("Name", _t('PageCommentInterface.YOURNAME', 'Your name'));
            $taf->addExtraClass('span9');
            $fields->push($taf);
        }
        // optional commenter EMAIL
        $emailTaf = new TextField("CommenterEmail", _t('PageCommentInterface.COMMENTEREMAIL', "Email:"));
        $emailTaf->addExtraClass('span9');
        $fields->push($emailTaf);
        // optional commenter URL
        $webTaf = new TextField("CommenterURL", _t('PageCommentInterface.COMMENTERURL', "Your website URL"));
        $webTaf->addExtraClass('span9');
        $fields->push($webTaf);
         
        if(MathSpamProtection::isEnabled()){
            $fields->push(new TextField("Math", sprintf(_t('PageCommentInterface.SPAMQUESTION', "Spam protection question: %s"), MathSpamProtection::getMathQuestion())));
        }               
         
        $commTaf = new TextareaField("Comment", _t('PageCommentInterface.YOURCOMMENT', "Comments"));
        $commTaf->addExtraClass('span9');
        $fields->push($commTaf);

                
        // Create action
        $fa = new FormAction("postcomment", _t('PageCommentInterface.POST', 'Post'));

        // for bootstrap
        $fa->useButtonTag = true;
        $fa->addExtraClass('btn btn-primary');
         
        $form = new NewPageCommentInterface_Form($this, "PostCommentForm", $fields, new FieldSet(
            $fa
        ));
         
        // Set it so the user gets redirected back down to the form upon form fail
        $form->setRedirectToFormOnValidationError(true);
         
        // Optional Spam Protection.
        if(class_exists('SpamProtectorManager')) {
            SpamProtectorManager::update_form($form, null, array('Name', 'CommenterURL', 'Comment'));
            self::set_use_ajax_commenting(false);
        }
         
        // Shall We use AJAX?
        if(self::$use_ajax_commenting) {
            Requirements::javascript(THIRDPARTY_DIR . '/behaviour.js');
            Requirements::javascript(THIRDPARTY_DIR . '/prototype.js');
            Requirements::javascript(THIRDPARTY_DIR . '/scriptaculous/effects.js');
            Requirements::javascript(CMS_DIR . '/javascript/PageCommentInterface.js');
        }
         
        // Load the data from Session
        $form->loadDataFrom(array(
            "Name" => Cookie::get("PageCommentInterface_Name"),
            "Comment" => Cookie::get("PageCommentInterface_Comment"),
            "CommenterEmail" => Cookie::get("PageCommentInterface_CommenterEmail"),
            "CommenterURL" => Cookie::get("PageCommentInterface_CommenterURL")   
        ));

        $form->setTemplate('CustomizedForm');
         
        return $form;
   }
}
/**
 * @package cms
 * @subpackage comments
 */
class NewPageCommentInterface_Form extends PageCommentInterface_Form {
    function postcomment($data) {
        Cookie::set("PageCommentInterface_CommenterEmail", $data['CommenterEmail']);
        return parent::postcomment($data);
    }
}
?>