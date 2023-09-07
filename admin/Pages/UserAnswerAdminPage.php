<?php

class UserAnswerAdminPage
{
    public function generate(): string
    {
        global $wpdb;

        ob_start();
          include_once PLUGIN_ANSWER_FORM_PATH.'/views/admin/user_answers.php';        
          $html = ob_get_contents();
        ob_end_clean();
        
        return $html;
    }
}
