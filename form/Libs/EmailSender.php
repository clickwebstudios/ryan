<?php

class EmailSender
{
    public function sendEmail(string $email, array $data, bool $attachemnt = false, ?int $formId = null)
    {
        $attachments = [];
        if ($attachemnt and $formId) {
          $pdfFile = (new PdfGeneratorV2)->generatePdfFileById($formId);
          $attachments[] = $pdfFile;
        }
        
        $siteUrl = get_site_url();
		
        $html = '';
        ob_start();
          include_once PLUGIN_FORM_PATH.'/email-templates/user.php';        
          $html = ob_get_contents();
        ob_end_clean();
        $headers[] = 'From: Ryan Gottfredson <ryan@ryangottfredson.com>';
        add_filter( 'wp_mail_content_type', 'set_email_html_content_type' );
        wp_mail($email, 'Personal Mindset Assessment', $html, $headers, $attachments);
    }
}
