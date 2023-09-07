<?php

class UserFormController
{
    public static function show()
    {
        global $wpdb;
        $id = $_POST['id']?? null;
        $id = (int) $id;
        
        $sql = "SELECT *
          FROM a_user_answers 
          where id = ".$id."
        ";
        
        $answer = $wpdb->get_results($sql, ARRAY_A);
        
        echo json_encode([
          'item' => $answer[0]?? [],
        ]);
        die();
    }
    
    public static function grid()
    {
        global $wpdb;
        $dataForm = $_POST['data']?? '[]';
        $dataForm = stripslashes($dataForm);
        $dataForm = json_decode($dataForm, true);
        
        $pageSize = $dataForm['pageSize']?? 20;
        $page = $dataForm['page']?? 1;
        
        // organization
        $organizationId = $dataForm['organization_id']?? 0;
        $organizationId = (int) $organizationId;
        
        // coach
        $coachId = $dataForm['coach_id']?? 0;
        $coachId = (int) $coachId;
        
        $pageSize = (int) $pageSize;
        $page = (int) $page;
        
        $orderField = $dataForm['orderField']?? 'date_created';
        $orderDir = $dataForm['orderDir']?? 'desc';
        $filter = '';
        
        if ($organizationId) {
            $filter = "where a_organization_id = ".$organizationId;
        }
        
        if ($coachId) {
            $filter = "where a_coach_id = ".$coachId;
        }
        
        $sql1 = "SELECT a_user_answers.*, a_organizations.`name` AS organization_name, a_coaches.`name` as coach_name
          FROM a_user_answers 
          
          LEFT JOIN a_organizations 
          ON a_user_answers.a_organization_id = a_organizations.id 
          
          LEFT JOIN a_coaches 
          ON a_user_answers.a_coach_id = a_coaches.id 
          
          ".$filter."

          order by ". addslashes($orderField)." ".addslashes($orderDir)."
          limit ".$pageSize."
          offset ".($pageSize * $page - $pageSize)."
        ";
        
        $answers = $wpdb->get_results($sql1, ARRAY_A);
        
        $sql2 = "SELECT count(id) as count_el
          FROM a_user_answers 
          ".$filter."
        ";
        
        $answerCount = $wpdb->get_results($sql2, ARRAY_A);
        
        echo json_encode([
          'items' => $answers,
          'total' => $answerCount[0]['count_el']?? 1,
        ]);
        die();
    }
}
