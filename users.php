<?php

require_once 'db_pdo.php';
if (!isset($index_loaded)) {
    die('direct access to this file is forbidden');
}
require_once 'web_page.php';

class users
{
    public function LoginPageDisplay($err_msg = '', $prev_values = [])
    {
        if ($prev_values == []) {
            //initial values first time display
            $prev_values['email'] = '';
            $prev_values['pw'] = '';
        }
        if (isset($_COOKIE['user_name'])) {
            $welcome_msg = 'Welcome Back '.$_COOKIE['user_name'].' ! You last visited '.date('d-m-Y', $_COOKIE['last_login_date']);
        } else {
            $welcome_msg = '';
        }
        $LoginPage = new web_page();
        $LoginPage->title = 'Please Login';
        $LoginPage->content = <<<HTML
        <div class='alert alert-danger'>{$err_msg}</div>
        <div class='alert alert-success'>{$welcome_msg}</div>
        <form action="index.php?op=2" method="POST" style="width:300px">
        <input type="hidden" name="op" value="2">
        <input type="email" name="email"  class="form-control" required maxlength="126" size="25" placeholder="Email" value="{$prev_values['email']}"><br>
        <input type="password" class="form-control" name="pw" required maxlength="8" placeholder="Password(8 Character)" value="{$prev_values['pw']}"><br>
        <input type="submit" class="btn btn-primary" value="Continue">
        </form>
        HTML;
        $LoginPage->render();
    }

    public function LoginPageVerify()
    {
        /*$users = [['id' => 0, 'name' => 'Nidhi', 'email' => 'abc@gmail.com', 'pw' => '12345678', 'name' => 'mary', 'user_level' => 'employee'],
                   ['id' => 1, 'name' => 'Nidhi', 'email' => 'mno@gmail.com', 'pw' => '12345678', 'name' => 'mark', 'user_level' => 'customer'],
                   ['id' => 2, 'name' => 'Nidhi', 'email' => 'tiya@gmail.com', 'pw' => '124545678', 'name' => 'mac', 'user_level' => 'employee'],
                   ['id' => 3, 'name' => 'Nidhi', 'email' => 'riya@gmail.com', 'pw' => '12348678', 'name' => 'stan', 'user_level' => 'customer'],
                ];*/

        $DB = new db_pdo();
        $Users = $DB->querySelect('SELECT * from users');

        $err_msg = ''; //all error messages
        //email
        if (isset($_POST['email'])) {
            $email_input = $_POST['email'];
        } else {
            //echo 'test1';
            crash(500, 'Email not found in login form, class users.php');
        }

        if (!filter_var($email_input, FILTER_VALIDATE_EMAIL)) {
            $err_msg .= 'Email wrong in Login form, class users.php <br>';
        }

        //password
        if (isset($_POST['pw'])) {
            $pw_input = $_POST['pw'];
        } else {
            //echo 'test1';
            crash(500, 'Password not found in login form,class users.php');
        }

        if (strlen($pw_input) != 8) {
            $err_msg .= 'Password must be 8 characters<br>';
        }

        //data problem
        if ($err_msg != '') {
            //display form with error message and values previously entered
            $this->LoginPageDisplay($err_msg, $_POST);
        }

        //Verify if email+password in the list of users
        $flag = 0;

        foreach ($Users as $key => $value) {
            if ($email_input == $value['email'] && $pw_input == $value['pw']) {
                $flag = 1;
                $current_user_info = $value;
                break;
            }
        }

        if ($flag == 1) {
            $_SESSION['user_connected'] = true;
            $_SESSION['user_email'] = $current_user_info['email'];
            $_SESSION['user_name'] = $current_user_info['fullname'];
            $_SESSION['user_id'] = $current_user_info['id'];
            //$_SESSION['user_level'] = $current_user_info['user_level'];
            $_SESSION['user_pic'] = $current_user_info['pic'];

            //set cookies
            setcookie('user_name', $current_user_info['fullname'], time() + (2 * 365 * 24 * 60 * 60));
            setcookie('user_email', $current_user_info['email'], time() + (2 * 365 * 24 * 60 * 60));
            setcookie('last_login_date', time(), time() + (2 * 365 * 24 * 60 * 60));

            $validPage = new web_page();
            $validPage->content = '<h1>Logged in Successfully<h1><br><h2>Welcome Back  '.$email_input.'</h2>';
            $validPage->render();
        } else {
            if (!isset($_SESSION['login_count'])) {
                $_SESSION['login_count'] = 1;
            } else {
                ++$_SESSION['login_count'];
            }
            $this->LoginPageDisplay('Email or password doesnt not match, Try again!!!!!!', $_POST);
        }
    }

    // echo $email_input.'<br>';
    // echo $pw_input.'<br>';
    // echo 'Hello you are logged in';

    /*public function userList()
    {
        $DB = new db_pdo();
        $DB->_construct();
        $result = $DB->querySelect('SELECT * FROM users');
        $page = new web_page();
        $page->title = 'Users List';
        $page->content = userlist($result);
        $page->render();
    }*/

    public function logout()
    {
        $_SESSION['user_connected'] = null;
        $_SESSION['user_email'] = null;
        $_SESSION['user_name'] = null;
        $_SESSION['user_id'] = null;
        $_SESSION['user_level'] = null;
        $LoginPageDisplay = new web_page();
        $LoginPageDisplay->content = '<h1>Logged out Succesfully'.'</h2>';
        $LoginPageDisplay->render();
        homePage();
    }

    public function UsersWebService()
    {
        $DB = new db_pdo();
        $users = $DB->table('users');
        $usersJson = json_encode($users, JSON_PRETTY_PRINT);
        $content_type = 'content-Type: application/json; charset=UTF-8';
        header($content_type);
        http_response_code(200);
        echo $usersJson;
    }
}
