<?php

class StorageController
{
    public static function getStorage()
    {
        global $wpdb;
        $user = wp_get_current_user();
        
        $sql = "SELECT *
          FROM a_answers 
        ";
        
        $answersDatas = $wpdb->get_results($sql, ARRAY_A);
        
        $sql2 = "SELECT *
          FROM a_questions 
        ";
        
        $questionsDatas = $wpdb->get_results($sql2, ARRAY_A);
        
        // organizations
        $sql3 = "SELECT *
          FROM a_organizations 
        ";
        $organizationsData = $wpdb->get_results($sql3, ARRAY_A);
        
        // coaches
        $sql4 = "SELECT *
          FROM a_coaches 
        ";
        $coachesData = $wpdb->get_results($sql4, ARRAY_A);
        
        echo json_encode([
          'answers' => $answersDatas,
          'questions' => $questionsDatas,
          'organizations' => $organizationsData,
          'coaches' => $coachesData,
        ]);
        die();
    }
}
