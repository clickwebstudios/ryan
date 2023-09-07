<?php

use Spatie\Newsletter\NewsletterListCollection;
use Spatie\Newsletter\Newsletter;
use DrewM\MailChimp\MailChimp;

class MailchimpController
{
    public static function actionSubscribe()
    {
        global $wpdb;
     
        $dataForm = $_POST['data_form']?? '[]';
        $dataForm = stripslashes($dataForm);
        $dataForm = json_decode($dataForm, true);
        
        $firstname = $dataForm['first_name']?? '';
        $lastname = $dataForm['last_name']?? '';
        $email = $dataForm['email']?? '';
        
        static::subscribe($email, $firstname, $lastname);
        
        echo json_encode([]);
        die();
    }
  
    public static function subscribe(string $email, string $firstName, string $lastName)
    {
        global $wpdb;
        $classNewslatter = static::provideClass();
        
        $response = $classNewslatter->subscribeOrUpdate($email, ['first_name' => $firstName, 'last_name' => $lastName]);

        if ($response === false) {
            $errors = Newsletter::getLastError();
            // print error
            dd($errors);
        }
        
        echo json_encode([]);
        die();
    }
    
    protected static function provideClass(): ?Newsletter
    {
        $mailChimp = new Mailchimp(MAILCHIMP_API);
        $mailChimp->verify_ssl = true;

        $configuredLists = NewsletterListCollection::createFromConfig([
          'driver' => 'api',
          'apiKey' => MAILCHIMP_API,
          'defaultListName' => 'subscribers',
          'lists' => [
              'subscribers' => [
                  'id' => '80e3ba9130',
                  'marketing_permissions' => [
                    
                  ],
              ],
          ],
          'ssl' => true,
        ]);

        $class = new Newsletter($mailChimp, $configuredLists);
        
        return $class;
    }
}
