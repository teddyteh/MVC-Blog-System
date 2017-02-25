<?php

/*
* Manages user accounts
*/
class UserManager
{
    // Compute a password hash
    public function computeHash($password)
    {
        $salt = 'fd16sdfd2ew#$%';
        return hash('sha256', $password . $salt);
    }

    // Register a new user
    public function register($name, $password, $passwordRepeat, $year)
    {
        if ($year != date('Y'))
            throw new UserException('Invalid antispam.');
        if ($password != $passwordRepeat)
            throw new UserException('Password mismatch.');
        
        $user = array(
            'name' => $name,
            'password' => $this->computeHash($password),
        );
        
        try
        {
            Db::insert('users', $user);
        }
        catch (PDOException $ex)
        {
            throw new UserException('This username has already been taken.');
        }
    }

    // Log a user in
    public function login($name, $password)
    {
        $user = Db::queryOne('
                SELECT user_id, name, admin
                FROM users
                WHERE name = ? AND password = ?
        ', array($name, $this->computeHash($password)));

        if (!$user)
            throw new UserException('Invalid username or password.');

        $_SESSION['user'] = $user;
    }

    // Log the user off
    public function logout()
    {
        unset($_SESSION['user']);
    }

    // Return the name of the user currently logged in
    public function getUser()
    {
        if (isset($_SESSION['user']))
            return $_SESSION['user'];

        return null;
    }
}