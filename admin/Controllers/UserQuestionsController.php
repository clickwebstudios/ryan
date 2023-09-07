<?php

class UserQuestionsController
{
    public static function update()
    {
        global $wpdb;
        
        $id = $_POST['id']?? null;
        $id = (int) $id;  
      
        $dataForm = $_POST['entity']?? '[]';
        $dataForm = stripslashes($dataForm);
        $dataForm = json_decode($dataForm, true);
        
        $result = $wpdb->update('a_questions', array(
              'q_left' => $dataForm['q_left']?? '',
              'q_right' => $dataForm['q_right']?? '',
          ), 
          array('id' => $id), 
          array('%s','%s'),
          array('%d'));
        
        die();
    }
  
    public static function show()
    {
        global $wpdb;
        $id = $_POST['id']?? null;
        $id = (int) $id;
        
        $sql = "SELECT *
          FROM a_questions 
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
        
        $pageSize = (int) $pageSize;
        $page = (int) $page;
        
        $orderField = $dataForm['orderField']?? 'id';
        $orderDir = $dataForm['orderDir']?? 'asc';
        
        $sql1 = "SELECT *
          FROM a_questions 
          order by ". addslashes($orderField)." ".addslashes($orderDir)."
          limit ".$pageSize."
          offset ".($pageSize * $page - $pageSize)."
        ";
        
        $answers = $wpdb->get_results($sql1, ARRAY_A);
        
        $sql2 = "SELECT count(id) as count_el
          FROM a_questions 
        ";
        
        $answerCount = $wpdb->get_results($sql2, ARRAY_A);
        
        echo json_encode([
          'items' => $answers,
          'total' => $answerCount[0]['count_el']?? 1,
        ]);
        die();
    }
}
