<?php

/*
* Base Controller class
*/
abstract class Controller {
    // An array which its indexes will be available as variables in its view 
	protected $data = array();
	protected $view = "";
	protected $page = array('title' => '', 'description' => '');

	public function renderView() {
		if ($this->view)
        {
            extract($this->protect($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");

            require("views/" . $this->view . ".phtml");
        }
	}

	public function redirect($url)
	{
		header("Location: /$url");
		header("Connection: close");
        exit;
	}

    public function authUser($admin = false)
    {
        $userManager = new UserManager();
        $user = $userManager->getUser();
        if (!$user || ($admin && !$user['admin']))
        {
            echo('You are not authorized to complete this action.');
            $this->redirect('account/login');
        }
    }

    public function getUser()
    {
        $userManager = new UserManager();
        $user = $userManager->getUser();
        if ($user)
            return $user;
    }

	/**
     * Protects any variable by converting HTML special characters to entities
     * @param mixed $x The variable to be protected
     * @return mixed The protected variable
     */
    private function protect($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach($x as $k => $v)
            {
                $x[$k] = $this->protect($v);
            }
            return $x;
        }
        else
            return $x;
    }
}