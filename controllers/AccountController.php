<?php

/*
* Handles registration and login/ logout
*/
class AccountController extends Controller
{
    public function process($params)
    {
        // The UserManager model class manages users
        $userManager = new UserManager();

        if (!empty($params[0]) && $params[0] == 'login') {
            // Check if the user has already logged in
            if ($userManager->getUser()) {
                $this->redirect('blog');                
            }

            $this->page['title'] = 'Login';

            // Log a user in
            if ($_POST)
            {
                try
                {
                    $userManager->login($_POST['name'], $_POST['password']);
                    $this->redirect('blog');
                }
                catch (UserException $ex)
                {
                    echo $ex->getMessage();
                }
            }

            $this->view = 'login';
        } else if (!empty($params[0]) && $params[0] == 'logout') {
            // Log the user out
            $userManager->logout();
            $this->redirect('blog');
        } else if (!empty($params[0]) && $params[0] == 'register') {
            $this->page['title'] = 'Register';
            
            // Register a user
            if ($_POST)
            {
                try
                {
                    $userManager->register($_POST['name'], $_POST['password'], $_POST['password_repeat'], $_POST['abc']);
                    $userManager->login($_POST['name'], $_POST['password']);
                    $this->redirect('blog');
                }
                catch (UserException $ex)
                {
                    echo $ex->getMessage();
                }
            }

            $this->view = 'register';
        }
    }
}