<?php

class AnswerHelper
{
    public function getScorePositionText($quartile)
    {
        if ($quartile === 'Bottom Quartile') {
            return 'cell_1';
        } else if ($quartile === 'Second Quartile') {
            return 'cell_2';
        } else if ($quartile === 'Third Quartile') {
            return 'cell_3';
        } else if ($quartile === 'Top Quartile') {
            return 'cell_4';
        }
        return 'cell_1';
    }
  
    public function getImageName(string $title, string $imageFormat): ?string
    {
        if(!$imageFormat){
            $imageFormat = 'png';
        }
        if ($title === 'Strong Fixed Mindset') {
            return '01-strong-fixed.'.$imageFormat;
        }
        
        if ($title === 'Low Fixed Mindset') {
            return '02-low-fixed.'.$imageFormat;
        }
        
        if ($title === 'Low Growth Mindset') {
            return '03-low-growth.'.$imageFormat;
        }
        
        if ($title === 'Strong Growth Mindset') {
            return '04-strong-growth.'.$imageFormat;
        }
        
        if ($title === 'Strong Closed Mindset') {
            return '05-strong-closed.'.$imageFormat;
        }
        
        if ($title === 'Low Closed Mindset') {
            return '06-low-closed.'.$imageFormat;
        }
        
        if ($title === 'Low Open Mindset') {
            return '07-low-open.'.$imageFormat;
        }
        
        if ($title === 'Strong Open Mindset') {
            return '08-strong-open.'.$imageFormat;
        }
        
        if ($title === 'Strong Prevention Mindset') {
            return '09-strong-prevention.'.$imageFormat;
        }
        
        if ($title === 'Low Prevention Mindset') {
            return '10-low-prevention.'.$imageFormat;
        }

        if ($title === 'Low Promotion Mindset') {
            return '11-low-promotion.'.$imageFormat;
        }
        if ($title === 'Strong Promotion Mindset') {
            return '12-strong-promotion.'.$imageFormat;
        }

        if ($title === 'Strong Inward Mindset') {
            return '13-strong-inward.'.$imageFormat;
        }
        
        if ($title === 'Low Inward Mindset') {
            return '14-low-inward.'.$imageFormat;
        }
        
        if ($title === 'Low Outward Mindset') {
            return '15-low-outward.'.$imageFormat;
        }
        
        if ($title === 'Strong Outward Mindset') {
            return '16-strong-outward.'.$imageFormat;
        }       
        

        

    }
  
    public function getTitleTopOne(float $score): string
    {
        $response = [];
        if($score <= 3.75){
          return 'Strong Fixed Mindset';
        }
        if($score <= 4.75){
          return 'Low Fixed Mindset';
        }
        if($score <= 5.75){
          return 'Low Growth Mindset';
        }
        if($score <= 7){
          return 'Strong Growth Mindset';
        }
        return '';
    }
    
    public function getTitleTopTwo(float $score): string
    {
        if($score <= 3.8){
          return 'Strong Closed Mindset';
        }
        if($score <= 4.8){
          return 'Low Closed Mindset';
        }
        if($score <= 5.6){
          return 'Low Open Mindset';
        }
        if($score <= 7){
          return 'Strong Open Mindset';
        }
        return '';
    }
    
    public function getTitleTopThree(float $score): string
    {
        if($score <= 3.3){
          return 'Strong Prevention Mindset';
        }
        if($score <= 4.16){
          return 'Low Prevention Mindset';
        }
        if($score <= 4.9){
          return 'Low Promotion Mindset';
        }
        if($score <= 7){
          return 'Strong Promotion Mindset';
        }
        return '';
    }
    
    public function getTitleTopFour(float $score): string
    {
        if($score <= 4.1){
          return 'Strong Inward Mindset';
        }
        if($score <= 4.90){
          return 'Low Inward Mindset';
        }
        if($score <= 5.6){
          return 'Low Outward Mindset';
        }
        if($score <= 7){
          return 'Strong Outward Mindset';
        }
        return '';
    }
    
    public function getTitleBottomOne(float $score): string
    {
        if($score <= 3.75){
          return 'Bottom Quartile';
        }
        if($score <= 4.75){
          return 'Second Quartile';
        }
        if($score <= 5.75){
          return 'Third Quartile';
        }
        if($score <= 7){
          return 'Top Quartile';
        }
        return '';
    }
    
    public function getTitleBottomTwo(float $score): string
    {
        if($score <= 3.8){
          return 'Bottom Quartile';
        }
        if($score <= 4.8){
          return 'Second Quartile';
        }
        if($score <= 5.6){
          return 'Third Quartile';
        }
        if($score <= 7){
          return 'Top Quartile';
        }
        return '';
    }
    
    public function getTitleBottomThree(float $score): string
    {
        if($score <= 3.3){
          return 'Bottom Quartile';
        }
        if($score <= 4.16){
          return 'Second Quartile';
        }
        if($score <= 4.9){
          return 'Third Quartile';
        }
        if($score <= 7){
          return 'Top Quartile';
        }
        return '';
    }
    
    public function getTitleBottomFour(float $score): string
    {
        if($score <= 4.1){
          return 'Bottom Quartile';
        }
        if($score <= 4.90){
          return 'Second Quartile';
        }
        if($score <= 5.6){
          return 'Third Quartile';
        }
        if($score <= 7){
          return 'Top Quartile';
        }
        return '';
    }

    /**
     * Fixed/Growth Mindset
     * @param array $entity
     * @return string
     */
    public function getScoreFirst(array $entity): string
    {
      $ans1 = $entity['answers'][4];
      $ans2 = $entity['answers'][9];
      $ans3 = $entity['answers'][14];
      $ans4 = $entity['answers'][18];
      
      $summ = (int) $ans1['answer']['score'] + 
          (int)($ans2['answer']['score']) + 
          (int)($ans3['answer']['score']) + 
          (int)($ans4['answer']['score']);
      return number_format($summ/4, 2, '.', '');
    }

    /**
     * Closed/Open Mindset
     * @param array $entity
     * @return string
     */
    public function getScoreSeccond(array $entity): string
    {
        $ans1 = $entity['answers'][2];
        $ans2 = $entity['answers'][7];
        $ans3 = $entity['answers'][10];
        $ans4 = $entity['answers'][13];
        $ans5 = $entity['answers'][17];

        $summ = (int) $ans1['answer']['score'] + 
            (int)($ans2['answer']['score']) + 
            (int)($ans3['answer']['score']) + 
            (int)($ans4['answer']['score']) + 
            (int)($ans5['answer']['score']);
        return 8 - number_format($summ/5, 2, '.', '');
    }

    /**
     * Prevention/Promotion Mindset
     * @param array $entity
     * @return string
     */
    public function getScoreThird(array $entity): string
    {
        $ans1 = $entity['answers'][1];
        $ans2 = $entity['answers'][5];
        $ans3 = $entity['answers'][8];
        $ans4 = $entity['answers'][12];
        $ans5 = $entity['answers'][16];
        $ans6 = $entity['answers'][19];

        $summ = (int) $ans1['answer']['score'] + 
            (int)($ans2['answer']['score']) + 
            (int)($ans3['answer']['score']) + 
            (int)($ans4['answer']['score']) + 
            (int)($ans5['answer']['score']) + 
            (int)($ans6['answer']['score']);

        return 8 - number_format($summ/6, 2, '.', '');
    }

    /**
     * Inward/Outward Mindset
     * @param array $entity
     * @return string
     */
    public function getScoreFour(array $entity): string
    {
        $ans1 = $entity['answers'][3];
        $ans2 = $entity['answers'][6];
        $ans3 = $entity['answers'][11];
        $ans4 = $entity['answers'][15];
        $ans5 = $entity['answers'][20];

        $summ = (int) $ans1['answer']['score'] + 
            (int)($ans2['answer']['score']) + 
            (int)($ans3['answer']['score']) + 
            (int)($ans4['answer']['score']) + 
            (int)($ans5['answer']['score']);

        return number_format($summ/5, 2, '.', '');
    }
  
    public function fillAnswerData(array $datas)
    {
        $this->freshAnswers();
        
        foreach ($datas as &$data) {
            if (!empty($this->answers[$data['a_answer_id']])) {
                $data['answer'] = $this->answers[$data['a_answer_id']];
            }
        }
        
        return $datas;
    }
    
    protected $answers = [];
    
    protected function freshAnswers()
    {
        global $wpdb;
      
        $sql = "SELECT *
          FROM a_answers
        ";
        
        $results = $wpdb->get_results($sql, ARRAY_A);
        
        $data = [];
        foreach ($results as $res) {
            $data[$res['id']] = $res;
        }
        
        $this->answers = $data;
    }
  
}
