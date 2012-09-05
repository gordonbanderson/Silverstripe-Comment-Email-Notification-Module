<?php
/*Copied from CommentAdmin.php version 2.3.1
    - Added Email field
 */
class CommentAdminExtension extends CommentAdmin  { 
    public function EditForm() {
        $section = $this->Section();
         
        if($section == 'approved') {
            $filter = 'IsSpam=0 AND NeedsModeration=0';
            $title = "<h2>". _t('CommentAdmin.APPROVEDCOMMENTS', 'Approved Comments')."</h2>";
        } else if($section == 'unmoderated') {
            $filter = 'NeedsModeration=1';
            $title = "<h2>"._t('CommentAdmin.COMMENTSAWAITINGMODERATION', 'Comments Awaiting Moderation')."</h2>";
        } else {
            $filter = 'IsSpam=1';
            $title = "<h2>"._t('CommentAdmin.SPAM', 'Spam')."</h2>";
        }
         
        $filter .= ' AND ParentID>0';
         
        $tableFields = array(
            "Name" => _t('CommentAdmin.AUTHOR', 'Author'),
            "Comment" => _t('CommentAdmin.COMMENT', 'Comment'),
            "CommenterEmail" => _t('CommentAdmin.COMMENTEREMAIL', 'Email'),
            "PageTitle" => _t('CommentAdmin.PAGE', 'Page'),
            "CommenterURL" => _t('CommentAdmin.COMMENTERURL', 'URL'),
            "Created" => _t('CommentAdmin.DATEPOSTED', 'Date Posted')
        );  
         
        $popupFields = new FieldSet(
            new TextField('Name', _t('CommentAdmin.NAME', 'Name')),
            new TextField('CommenterEmail', _t('CommentAdmin.COMMENTEREMAIL', 'Email')),
            new TextField('CommenterURL', _t('CommentAdmin.COMMENTERURL', 'URL')),
            new TextareaField('Comment', _t('CommentAdmin.COMMENT', 'Comment'))
        );
         
        $idField = new HiddenField('ID', '', $section);
        $table = new CommentTableField($this, "Comments", "PageComment", $section, $tableFields, $popupFields, array($filter));
        $table->setParentClass(false);
         
        $fields = new FieldSet(
            new TabSet( 'Root',
                new Tab(_t('CommentAdmin.COMMENTS', 'Comments'),
                    new LiteralField("Title", $title),
                    $idField,
                    $table
                )
            )
        );
         
        $actions = new FieldSet();
         
        if($section == 'unmoderated') {
            $actions->push(new FormAction('acceptmarked', _t('CommentAdmin.ACCEPT', 'Accept')));
        }
         
        if($section == 'approved' || $section == 'unmoderated') {
            $actions->push(new FormAction('spammarked', _t('CommentAdmin.SPAMMARKED', 'Mark as spam')));
        }
         
        if($section == 'spam') {
            $actions->push(new FormAction('hammarked', _t('CommentAdmin.MARKASNOTSPAM', 'Mark as not spam')));
        }
         
        $actions->push(new FormAction('deletemarked', _t('CommentAdmin.DELETE', 'Delete')));
         
        if($section == 'spam') {
            $actions->push(new FormAction('deleteall', _t('CommentAdmin.DELETEALL', 'Delete All')));
        }
         
        $form = new Form($this, "EditForm", $fields, $actions);
         
        return $form;
    }
}
?>
