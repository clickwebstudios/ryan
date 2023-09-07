<?php

use Dompdf\Dompdf;
use setasign\Fpdi\Fpdi;

class PdfGeneratorV2
{
    protected function getEntityFormByToken(string $token)
    {
        global $wpdb;

        $sql = "SELECT *
          FROM a_user_answers 
          where token = '". addslashes($token)."'
        ";

        $result = $wpdb->get_results($sql, ARRAY_A);
        $item = $result[0]?? [];

        $answers = $item['answers']? json_decode($item['answers'], true) : [];
        $item['answers'] = (new AnswerHelper)->fillAnswerData($answers);

        return $item;
    }
  
    protected function getEntityFormById(int $id)
    {
        global $wpdb;

        $sql = "SELECT *
          FROM a_user_answers 
          where id = '". $id."'
        ";

        $result = $wpdb->get_results($sql, ARRAY_A);
        $item = $result[0]?? [];

        $answers = $item['answers']? json_decode($item['answers'], true) : [];
        $item['answers'] = (new AnswerHelper)->fillAnswerData($answers);

        return $item;
    }

    public function generateAndStreamPdf(string $token)
    {
        $entity = $this->getEntityFormByToken($token);
        
        global $wpdb;
        $dompdf = new Dompdf(array('enable_remote' => true));
        
        $options = $dompdf->getOptions();
        //$options->setDpi(300.77);
        $dompdf->setOptions($options);
        $siteUrl = site_url();
        
        
        ob_start();
          include_once PLUGIN_FORM_PATH.'/pdf-templates/result.php';        
          $html = ob_get_contents();
        ob_end_clean();
        
        //echo $html;
        //exit();
        
        $dompdf->loadHtml($html);
        //$customPaper = array(0,0,360,360);
        //$dompdf->setPaper($customPaper);
        //$dompdf->setPaper('letter');
        
        $dompdf->render();
        $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        exit();
    }
    
    public function generatePdfFileById(int $id): string
    {
        $entity = $this->getEntityFormById($id);
        
        global $wpdb;
        $dompdf = new Dompdf(array('enable_remote' => true));
        
        $options = $dompdf->getOptions();
        //$options->setDpi(300.77);
        $dompdf->setOptions($options);
        $siteUrl = site_url();
        
        ob_start();
          include_once PLUGIN_FORM_PATH.'/pdf-templates/result.php';        
          $html = ob_get_contents();
        ob_end_clean();
        
        //echo $html;
        //exit();
        
        $dompdf->loadHtml($html);
        //$customPaper = array(0,0,360,360);
        //$dompdf->setPaper($customPaper);
        //$dompdf->setPaper('letter');
        
        $filePath = PLUGIN_ANSWER_FORM_PATH.'/pdf/'.'results_'.$id.'.pdf';
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents($filePath, $output);
        
        return $filePath;
    }

}
