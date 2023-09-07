<?php

class FormController
{
    public static function store()
    {
        global $wpdb;
        
        $dataForm = $_POST['data_form']?? '[]';
        $dataForm = stripslashes($dataForm);
        $dataForm = json_decode($dataForm, true);
        
        $dataFormMain = $_POST['data_form_main']?? '[]';
        $dataFormMain = stripslashes($dataFormMain);
        $dataFormMain = json_decode($dataFormMain, true);
        
        $result = (new UserAnswerRepository)->store($dataFormMain, $dataForm);
        
        echo json_encode([
          'id' => $result['id'],
          'token' => $result['token'],
        ]);
        die();
    }
}
