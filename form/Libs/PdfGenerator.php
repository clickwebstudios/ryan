<?php

use Dompdf\Dompdf;
use setasign\Fpdi\Fpdi;

class PdfGenerator
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

    public function generateAndStreamPdf(string $token)
    {
        $entity = $this->getEntityFormByToken($token);

//        $file = PLUGIN_ANSWER_FORM_PATH.'/dist/pdf/results.pdf';
        $file = PLUGIN_ANSWER_FORM_PATH.'/dist/pdf/report.pdf';
        $fileOutput = PLUGIN_ANSWER_FORM_PATH.'/dist/pdf/results_output.pdf';

        $firstName = $entity['first_name']?? '';
        $lastName = $entity['last_name']?? '';

        $pdf = new Fpdi('P','mm',array(216,280));
        $fontFilePath = plugin_dir_path(__FILE__) . 'fonts/KeplerStd-Regular.php';
        $pdf->AddFont('Kepler', '', 'KeplerStd-Regular.php');
        $pdf->SetFont('Helvetica', 'B', 26);
        $pdf->setSourceFile($file);

        $pages = $pdf->setSourceFile($file);
        for ($pageNumber = 1; $pageNumber <= $pages; $pageNumber++) {
            // Add a new page to the PDF
            $pdf->AddPage();
            // Import the template page
            $template = $pdf->importPage($pageNumber);
            $pdf->useTemplate($template);
            if($pageNumber == 1 ){
                $this->setUserDataFirstPage($pdf, $entity);
                continue;
            }
            if($pageNumber == 4 ||
                $pageNumber == 5 ||
                $pageNumber == 6 ||
                $pageNumber == 7){
                $this->setDataPage($pdf, $entity, $pageNumber);
            }
            if($pageNumber == 9 ){
                $this->setCopyright($pdf);
                continue;
            }

            // Skip first and last pages
            if ($pageNumber == $pages) {
                continue;
            }
            $this->setPageHeaderFooter($pdf, $entity);

            $pdf->endTemplate();
        }

        $pdf->Output($fileOutput, 'D');

        header("Content-disposition: inline;");
        exit();

        /*
        global $wpdb;
        $dompdf = new Dompdf(array('enable_remote' => true));
        
        ob_start();
          include_once PLUGIN_FORM_PATH.'/pdf-templates/result.php';        
          $html = ob_get_contents();
        ob_end_clean();
        
        $dompdf->loadHtml($html);
        //$dompdf->setPaper('letter');
        $dompdf->render();
        $dompdf->stream();
        exit();
        */
    }
    // Set user first and last name for the first page
    protected function setUserDataFirstPage(&$pdf,$entity){
        $firstName = $entity['first_name'];
        $lastName = $entity['last_name'];

        $pdf->SetLineWidth(20);
        $pdf->SetDrawColor(40,50,65);
        $pdf->Line(26,116, 60, 116);

        // set text
        $pdf->SetTextColor(188, 190, 192);
        $pdf->SetXY(21, 107);
        $pdf->Cell(160, 10, $firstName. ' ' . $lastName, 0, 0);
    }
    // Set user first and last name for the pages
    protected function setPageHeaderFooter(&$pdf,$entity){
        $firstName = $entity['first_name'];
        $lastName = $entity['last_name'];

        // Fill colored box
        $pdf->SetLineWidth(15);
        $pdf->SetDrawColor(40,50,65);
        $pdf->Line(110,8, 125, 8);

        // Set text in header
        $pdf->SetFont('Kepler', '', 18);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(103, 7.4);
        $pdf->Cell(40, 2, $firstName.' '.$lastName, 0, 0);

        $this->setCopyright($pdf);
    }

    protected function setCopyright(&$pdf)
    {
        $pdf->SetAutoPageBreak(0);
        $pdf->SetLineWidth(3);
        $year = date('Y');
        $pdf->SetFont('Helvetica', '', 9);

        $pdf->SetLineWidth(3);
        $pdf->SetDrawColor(255,255,255);
        $pdf->Line(139, 267, 135, 267);

        $pdf->SetTextColor(186, 189, 193);
        $pdf->SetXY(132.5, 267.2);
        
        
        $pdf->Cell(40, 0, $year, 0, 0);
        $pdf->SetAutoPageBreak(1);
    }

    protected function setDataPage(&$pdf, array $entity, $pageNumber){
        $score = 0;
        $title1 = '';
        $title2 = '';
        if($pageNumber == 4){
            $score = (new AnswerHelper)->getScoreFirst($entity);
            $title1 = (new AnswerHelper)->getTitleTopOne((float) $score);
            $title2 = (new AnswerHelper)->getTitleBottomOne((float) $score);
        } else if($pageNumber == 5){
            $score = (new AnswerHelper)->getScoreSeccond($entity);
            $title1 = (new AnswerHelper)->getTitleTopTwo((float) $score);
            $title2 = (new AnswerHelper)->getTitleBottomTwo((float) $score);
        } else if($pageNumber == 6){
            $score = (new AnswerHelper)->getScoreThird($entity);
            $title1 = (new AnswerHelper)->getTitleTopThree((float) $score);
            $title2 = (new AnswerHelper)->getTitleBottomThree((float) $score);
        } else if($pageNumber == 7){
            $score = (new AnswerHelper)->getScoreFour($entity);
            $title1 = (new AnswerHelper)->getTitleTopFour((float) $score);
            $title2 = (new AnswerHelper)->getTitleBottomFour((float) $score);
        }
        $this->prepareTablePage($pdf, $entity, $score, $title1, $title2);
        $this->setImage($pdf, $title1);
    }

    protected function setImage(&$pdf, $title){
        $imageFormat = 'png';
        $imageName = (new AnswerHelper)->getImageName($title, $imageFormat);
        $imagePath = PLUGIN_ANSWER_FORM_PATH.'/dist/pdf/new/'.$imageName;
        $pdf->Image($imagePath, 20, 110, 175, 0, $imageFormat);
    }


    protected function prepareTablePage(&$pdf, $entity, $score, $title1, $quartile)
    {
        // Top title
        $pdf->SetFont('Kepler', '', 20);
        $pdf->SetTextColor(70, 77, 92);
        $cellWidth = 200; // Set the width of the cell to 0 to make it extend to the right edge of the page
        $cellHeight = 8; // Set the height of the cell
        $pageWidth = $pdf->GetPageWidth();
        $x = ($pageWidth - $cellWidth) / 2;
        $pdf->SetXY($x, 40); // Set the X and Y position of the cell
        $pdf->Cell($cellWidth, $cellHeight, $title1, 0, 0, 'C'); // 'C' parameter for center alignment
        $titles = explode(' ', $title1);
        $titleLeft = $titles[0];
        $titleRight = $titles[1];

        // Left text
        $pdf->SetFont('Helvetica', '', 14);
        $pdf->SetTextColor(36, 49, 65);
        $pdf->SetXY(40, 61);
        $pdf->Cell(30, 2, $titleLeft, 0, 0);

        // Right text
        $pdf->SetXY(160, 61);
        $pdf->SetTextColor(36, 49, 65);
        $pdf->Cell(40, 2, $titleRight, 0, 0);

        // Score position
        $position = 0;
        if($title1){
            $position = $this->getScorePosition($quartile);
        }
        // Score
        $pdf->SetTextColor(36, 49, 65);
        if($quartile === 'Top Quartile'){
            $pdf->SetTextColor(255, 255, 255);
        }
        $pdf->SetFont('Helvetica', '', 20);
        $pdf->SetXY($position, 60);
        $pdf->Cell(40, 2, $score, 0, 0);

        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->SetXY($position - 1, 65);
        $pdf->Cell(40, 2, 'Raw Score', 0, 0);

        // Quartile title
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY($x, 92.5); // Set the X and Y position of the cell
        $pdf->Cell($cellWidth, $cellHeight, $quartile, 0, 0, 'C'); // 'C' parameter for center alignment
    }

    protected function getScorePosition($quartile){
        if ($quartile === 'Bottom Quartile') {
            return 66;
        } else if ($quartile === 'Second Quartile') {
            return 90;
        } else if ($quartile === 'Third Quartile') {
            return 114;
        } else if ($quartile === 'Top Quartile') {
            return 138;
        }
        return 0;
    }
}
