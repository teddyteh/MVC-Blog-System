<?php

/*
* Contact page
*/
class ContactController extends Controller
{
    public function process($params)
    {
        $this->page['title'] = 'Contact me';

        // Check if a valid email address is given
        if (isset($_POST["email"]))
        {
            // Validate the captcha
            if ($_POST['abc'] == date("Y"))
            {
                $emailSender = new EmailSender();
                $emailSender->send("tedislander@gmail.com", "Email from your website", $_POST['message'], $_POST['email']);
            }
        }

        $this->view = 'contact';
    }
}