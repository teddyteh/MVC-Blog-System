<?php

class ContactController extends Controller
{
    public function process($params)
    {
        $this->page = array(
                'title' => 'Contact form'
        );

        if (isset($_POST["email"]))
        {
            if ($_POST['abc'] == date("Y"))
            {
                $emailSender = new EmailSender();
                $emailSender->send("tedislander@gmail.com", "Email from your website", $_POST['message'], $_POST['email']);
            }
        }

        $this->view = 'contact';
    }
}