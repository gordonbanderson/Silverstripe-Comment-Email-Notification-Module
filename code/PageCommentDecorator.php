<?php
class PageCommentDecorator extends DataObjectDecorator  {
   function extraStatics() {
      return array(
         'db' => array(
            "CommenterEmail" => "Varchar(255)",
         )
      );
   }
    public function updateCMSFields(FieldSet &$fields) {
        $fields->push(new TextField('CommenterEmail', 'Commenter Email'));
    }
    function updateFieldLabels(&$labels) {
      parent::updateFieldLabels($labels);
      $labels['CommenterEmail'] = "Commenter Email";
   }
    
  
}
?>
