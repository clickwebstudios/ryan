<?php

use Hashemi\CsvExport\CsvExport;

class CsvGenerator
{
    protected function getEntityOrganizationByToken(string $token)
    {
        global $wpdb;
        
        $sql = "SELECT *
          FROM a_organizations 
          where token = '". addslashes($token)."'
        ";
        
        $result = $wpdb->get_results($sql, ARRAY_A);
        $item = $result[0]?? [];
        
        return $item;
    }
    
    protected function getEntityCoachByToken(string $token)
    {
        global $wpdb;
        
        $sql = "SELECT *
          FROM a_coaches 
          where token = '". addslashes($token)."'
        ";
        
        $result = $wpdb->get_results($sql, ARRAY_A);
        $item = $result[0]?? [];
        
        return $item;
    }
  
    protected function getForms(int $organizationId)
    {
        global $wpdb;
        
        $sql = "SELECT *
          FROM a_user_answers 
          where a_organization_id = ".$organizationId."
        ";
        
        $result = [];
        $items = $wpdb->get_results($sql, ARRAY_A);
        foreach ($items as $item) {
            $answers = $item['answers']? json_decode($item['answers'], true) : [];
            $item['answers'] = (new AnswerHelper)->fillAnswerData($answers);
            
            $result[] = $item;
        }
        
        return $result;
    }
    
    protected function getFormsCoach(int $coachId)
    {
        global $wpdb;
        
        $sql = "SELECT *
          FROM a_user_answers 
          where a_coach_id = ".$coachId."
        ";
        
        $result = [];
        $items = $wpdb->get_results($sql, ARRAY_A);
        foreach ($items as $item) {
            $answers = $item['answers']? json_decode($item['answers'], true) : [];
            $item['answers'] = (new AnswerHelper)->fillAnswerData($answers);
            
            $result[] = $item;
        }
        
        return $result;
    }
    
    protected function clearString(?string $string): ?string
    {
        $string = str_replace(array("\r\n", "\r", "\n"), ' ', $string);
        return trim($string);
    }
    
    protected function createFormRowCSV(array $row): array
    {
        $totalsScore = 0;
        foreach ($row['answers'] as $answer) {
            $totalsScore += $answer['answer']['score']?? 0;
        }
        
        $answerHelper = new AnswerHelper();
      
        $outcomes = "";
        
        // 1
        $score1 = $answerHelper->getScoreFirst($row);
        $outcomes .= "You have a ".$this->clearString($answerHelper->getTitleTopOne($score1)).' ';
        
        // 2
        $score2 = $answerHelper->getScoreSeccond($row);
        $outcomes .= "You have a ".$this->clearString($answerHelper->getTitleTopTwo($score2)).' ';
        
        // 3
        $score3 = $answerHelper->getScoreThird($row);
        $outcomes .= "You have a ".$this->clearString($answerHelper->getTitleTopThree($score3)).' ';
        
        // 4
        $score4 = $answerHelper->getScoreFour($row);
        $outcomes .= "You have a ".$this->clearString($answerHelper->getTitleTopFour($score4)).' ';
        
        $outcomes = trim($outcomes, ', ');
        
        return [
            ' '.date('Y-m-d H:i:s', strtotime($row['date_created'])).' ',
            $row['first_name'],
            $row['last_name'],
            $row['email'],
            $row['answers'][1]['answer']['score']?? 0,
            $row['answers'][2]['answer']['score']?? 0,
            $row['answers'][3]['answer']['score']?? 0,
            $row['answers'][4]['answer']['score']?? 0,
            $row['answers'][5]['answer']['score']?? 0,
            $row['answers'][6]['answer']['score']?? 0,
            $row['answers'][7]['answer']['score']?? 0,
            $row['answers'][8]['answer']['score']?? 0,
            $row['answers'][9]['answer']['score']?? 0,
            $row['answers'][10]['answer']['score']?? 0,
            $row['answers'][11]['answer']['score']?? 0,
            $row['answers'][12]['answer']['score']?? 0,
            $row['answers'][13]['answer']['score']?? 0,
            $row['answers'][14]['answer']['score']?? 0,
            $row['answers'][15]['answer']['score']?? 0,
            $row['answers'][16]['answer']['score']?? 0,
            $row['answers'][17]['answer']['score']?? 0,
            $row['answers'][18]['answer']['score']?? 0,
            $row['answers'][19]['answer']['score']?? 0,
            $row['answers'][20]['answer']['score']?? 0,
            (string) $totalsScore,
            (string) 20*7,
            ' '.$score1.' ',
            ' '.$score2.' ',
            ' '.$score3.' ',
            ' '.$score4.' ',
            $outcomes,
        ];
    }
  
    public function generateCsvExportOrganization(string $token)
    {
        $organization = $this->getEntityOrganizationByToken($token);
        
        if (!$organization){
            return;
        }
        
        $idOrg = (int) $organization['id'];
        $formRows = $this->getForms($idOrg);
        
        $headers = [
            'Date & Time',
            'Contact Name',
            'Contact Last Name',
            'Contact Email',
            'Question 1',
            'Question 2',
            'Question 3',
            'Question 4',
            'Question 5',
            'Question 6',
            'Question 7',
            'Question 8',
            'Question 9',
            'Question 10',
            'Question 11',
            'Question 12',
            'Question 13',
            'Question 14',
            'Question 15',
            'Question 16',
            'Question 17',
            'Question 18',
            'Question 19',
            'Question 20',
            'Total Custom Score',
            'Max Custom Score',
            'F1: Fixed/Growth',
            'F2: Closed/Open',
            'F3: Prevention/Promotion',
            'F4: Inward/Outward',
            'Outcome(s)',
        ];
        
        $rows = [];
        foreach ($formRows as $formRow) {
            $rows[] = $this->createFormRowCSV($formRow);
        }
        
        (new CsvExport())
            ->setHeaders($headers)
            ->setRows($rows)
            ->setFileName('results.csv')
            ->download(',');
        
        
        die();
    }
    
    
    public function generateCsvExportCoach(string $token)
    {
        $coach = $this->getEntityCoachByToken($token);
        
        if (!$coach){
            return;
        }
        
        $coachId = (int) $coach['id'];
        $formRows = $this->getFormsCoach($coachId);
        
        $headers = [
            'Date & Time',
            'Contact Name',
            'Contact Last Name',
            'Contact Email',
            'Question 1',
            'Question 2',
            'Question 3',
            'Question 4',
            'Question 5',
            'Question 6',
            'Question 7',
            'Question 8',
            'Question 9',
            'Question 10',
            'Question 11',
            'Question 12',
            'Question 13',
            'Question 14',
            'Question 15',
            'Question 16',
            'Question 17',
            'Question 18',
            'Question 19',
            'Question 20',
            'Total Custom Score',
            'Max Custom Score',
            'F1: Fixed/Growth',
            'F2: Closed/Open',
            'F3: Prevention/Promotion',
            'F4: Inward/Outward',
            'Outcome(s)',
        ];
        
        $rows = [];
        foreach ($formRows as $formRow) {
            $rows[] = $this->createFormRowCSV($formRow);
        }
        
        (new CsvExport())
            ->setHeaders($headers)
            ->setRows($rows)
            ->setFileName('results.csv')
            ->download(',');
        
        
        die();
    }
}
