<?php

class UserAnswerRepository
{
    protected function getOrganizationIdBySlug(?string $slug): ?int
    {
        global $wpdb;
      
        if (!$slug) {
            return null;
        }
        
        $sql = "SELECT id
          FROM a_organizations
          where slug = '". addslashes($slug)."'
        ";
        
        $founds = $wpdb->get_results($sql, ARRAY_A);
        return $founds[0]['id']?? null;
    }
    
    protected function getCoachBySlug(?string $slug): ?array
    {
        global $wpdb;
      
        if (!$slug) {
            return null;
        }
        
        $sql = "SELECT id, email
          FROM a_coaches
          where slug = '". addslashes($slug)."'
        ";
        
        $founds = $wpdb->get_results($sql, ARRAY_A);
        return isset($founds[0]['id'])? $founds[0] : null;
    }
  
    public function store($dataFormMain, $dataForm): array
    {        
        global $wpdb;
        $email = $dataFormMain['email']?? '';
        $email = trim($email);
        
        $answers = $dataForm?? [];
        $answers = json_encode($answers);
        
        $sql2 = "SELECT id, token
          FROM a_user_answers
          where email = '". addslashes($email)."'
        ";
        
        $founds = $wpdb->get_results($sql2, ARRAY_A);
        $foundId = $founds[0]['id']?? null;
        $foundToken = $founds[0]['token']?? null;
        $newToken = $this->generateUniqToken();
        
        $organizationSlug = $dataFormMain['organization']?? null;
        $organizationId = $this->getOrganizationIdBySlug($organizationSlug);
        
        $coachSlug = $dataFormMain['coach']?? null;
        $coach = $this->getCoachBySlug($coachSlug);
        
        $data = [
            "first_name" => $dataFormMain['first_name']?? null,
            "last_name" => $dataFormMain['last_name']?? null,
            "email" => $dataFormMain['email']?? null,
            "answers" => $answers,
            "a_organization_id" => $organizationId,
            "a_coach_id" => $coach? $coach['id'] : null,
            "date_created" => date('Y-m-d H:i:s'),
        ];
        
        $resultid = null;
        if (!$foundId){
            $resultToken = $newToken;
            $data['token'] = $newToken;
            $wpdb->insert("a_user_answers", $data);
            $resultid = $wpdb->insert_id;
            
        } else {
            $resultToken = $foundToken;
            $wpdb->update('a_user_answers', 
              $data, 
              array('email' => $email), 
              array('%s','%s','%s','%s'),
              array('%s')
            );
            
            $resultid = $foundId;
        }
        
        if ($coach) {
            $email = $coach['email']?? null;
        }
        
        if ($email) {
            $data['token'] = $resultToken;
            $attachment = $coach? true : false;
            
            (new EmailSender)->sendEmail($email, $data, $attachment, (int) $resultid);
        }
        
        return [
            'id' => (int) $resultid,
            'token' => (string) $resultToken,
        ];
    }
    
    protected function generateUniqToken(): string
    {
        global $wpdb;
      
        $token = $this->generateToken();
        
        while (true){
        
          $sql = "SELECT id
            FROM a_user_answers
            where token = '". addslashes($token)."'
          ";

          $founds = $wpdb->get_results($sql, ARRAY_A);
          $foundId = $founds[0]['id']?? null;
        
          if (!$foundId) {
              break;
          }
          
          $token = $this->generateToken();
        }
        
        return $token;
    }
    
    protected function generateToken(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(20));
    }
}
