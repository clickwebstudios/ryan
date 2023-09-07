<?php

class UserOrganizationController
{
    protected static function generateToken(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(20));
    }
  
    protected static function generateUniqToken(): string
    {
        global $wpdb;
      
        $token = static::generateToken();
        
        while (true){
        
          $sql = "SELECT id
            FROM a_organizations
            where token = '". addslashes($token)."'
          ";

          $founds = $wpdb->get_results($sql, ARRAY_A);
          $foundId = $founds[0]['id']?? null;
        
          if (!$foundId) {
              break;
          }
          
          $token = static::generateToken();
        }
        
        return $token;
    }
  
    public static function store()
    {
        global $wpdb;
        
        $dataForm = $_POST['entity']?? '[]';
        $dataForm = stripslashes($dataForm);
        $dataForm = json_decode($dataForm, true);
        
        $nameCompany = $dataForm['name']?? '';
        $slugCompany = OrganizationHelper::generateSlug($nameCompany);
        
        $wpdb->insert( 'table', [ 'column' => 'foo', 'field' => 1337 ], [ '%s', '%d' ] );
        
        $result = $wpdb->insert('a_organizations', array(
            'name' => $nameCompany,
            'email' => $dataForm['email']?? '',
            'slug' => $slugCompany,
            'date_created' => date('Y-m-d H:i:s'),
            'token' => static::generateUniqToken(),
          ), 
          array('%s','%s','%s','%s'));
        
        die();
    }
  
    public static function destroy()
    {
        global $wpdb;
        
        $id = $_POST['id']?? null;
        $id = (int) $id;  
        
        $wpdb->delete('a_organizations', ['id' => $id]);
    }
    
    public static function update()
    {
        global $wpdb;
        
        $id = $_POST['id']?? null;
        $id = (int) $id;  
      
        $dataForm = $_POST['entity']?? '[]';
        $dataForm = stripslashes($dataForm);
        $dataForm = json_decode($dataForm, true);
        
        $nameCompany = $dataForm['name']?? '';
        $slugCompany = OrganizationHelper::generateSlug($nameCompany, $id);
        
        $result = $wpdb->update('a_organizations', array(
            'name' => $nameCompany,
            'email' => $dataForm['email']?? '',
            'slug' => $slugCompany,
          ), 
          array('id' => $id), 
          array('%s','%s','%s'),
          array('%d'));
        
        die();
    }
  
    public static function show()
    {
        global $wpdb;
        $id = $_POST['id']?? null;
        $id = (int) $id;
        
        $sql = "SELECT *
          FROM a_organizations 
          where id = ".$id."
        ";
        
        $answer = $wpdb->get_results($sql, ARRAY_A);
        
        echo json_encode([
          'item' => $answer[0]?? [],
        ]);
        die();
    }
  
    public static function index()
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
        
        $sql1 = "      
          SELECT * FROM(
            SELECT a_organizations.*,
            COUNT(a_user_answers.id) AS count_answers

            FROM a_organizations

            LEFT JOIN a_user_answers
            ON a_user_answers.a_organization_id = a_organizations.id

            GROUP BY a_organizations.id

            order by ". addslashes($orderField)." ".addslashes($orderDir)."
          ) AS tmp_table
          limit ".$pageSize."
          offset ".($pageSize * $page - $pageSize)."
        ";
        
        /*
        $sql1 = "SELECT *
          FROM a_organizations 
          order by ". addslashes($orderField)." ".addslashes($orderDir)."
          limit ".$pageSize."
          offset ".($pageSize * $page - $pageSize)."
        ";
        */
        
        $answers = $wpdb->get_results($sql1, ARRAY_A);
        
        $sql2 = "SELECT count(id) as count_el
          FROM a_organizations 
        ";
        
        $answerCount = $wpdb->get_results($sql2, ARRAY_A);
        
        echo json_encode([
          'items' => $answers,
          'total' => $answerCount[0]['count_el']?? 1,
        ]);
        die();
    }
}
