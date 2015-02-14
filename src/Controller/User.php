<?php

namespace Masterclass\Controller;

use PDO;
use Masterclass\Model\User as UserModel;
use Aura\Web\Response;
use Aura\Web\Request;
use Aura\View\View;

class User {
    
    protected $userModel;
    protected $template;
    protected $response;
    protected $request;
            
    public function __construct(UserModel $user,
                                View $template,
                                Request $request,
                                Response $response
                               ) 
    {
        $this->userModel = $user;
        $this->response = $response;
        $this->template = $template;
        $this->request = $request;
    }
    
    public function create() 
    {
        $error = null;
        
        $create = $this->request->post->get('create');
        $username = $this->request->post->get('username');
        $email = $this->request->post->get('email');
        $password = $this->request->post->get('password');
        $password_check = $this->request->post->get('password_check');
        
        // Do the create
        if(isset($create)) {
            if(!$username || !$email || !$password || !$password_check) {
                $error = 'You did not fill in all required fields.';
            }
            
            if(is_null($error)) {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Your email address is invalid';
                }
            }
            
            if(is_null($error)) {
                if($password != $password_check) {
                    $error = "Your passwords didn't match.";
                }
            }
            
            if(is_null($error)) {
                if($this->userModel->checkUserExists($username)) {
                    $error = 'Your chosen username already exists. Please choose another.';
                }
            }
            
            if(is_null($error)) {
                
                $this->userModel->createUser($_POST['username'], 
                                              $_POST['email'], 
                                              $_POST['password']
                );
            
                $this->response->redirect->to('/user/login');
                return $this->response;
            }
        }
        // Show the create form
        $this->template->setLayout('layout');
        $this->template->setView('account_create');
        $this->template->setData([
            'error' => $error
        ]);
        
        $this->response->content->set($this->template->__invoke());
        
        return $this->response;
    }
    
    public function account() 
    {
        $error = null;
        if(!isset($_SESSION['AUTHENTICATED'])) {
            $this->response->redirect->to('/user/login');
            return $this->response;
        }
        
        $updatepw = $this->request->post->get('updatepw');
        $password = $this->request->post->get('password');
        $password_check = $this->request->post->get('password_check');
        
        if($updatepw) {
            if((!$password || !$password_check) ||
               ($password != $password_check)) {
                $error = 'The password fields were blank or they did not match. Please try again.';       
            }
            else {
                $this->userModel->updatePassword($password, $_SESSION['username']);
                $error = 'Your password was changed.';
            }
        }
        
        $details = $this->userModel->getUserDetails($_SESSION['username']);
        
        $this->template->setLayout('layout');
        $this->template->setView('account');
        $this->template->setData([
           'error' => $error,
           'details' => $details,
        ]);
        
        $this->response->content->set($this->template->__invoke());
        return $this->response;
    }
    
    public function login() 
    {
        $error = null;
        $login = $this->request->post->get('login');
        if($login) {
            
            $data = $this->userModel->validateUser($_POST['user'], $_POST['pass']);
            if($data) {
               
               session_regenerate_id();
               $_SESSION['username'] = $data['username'];
               $_SESSION['AUTHENTICATED'] = true;
               $this->response->redirect->to('/');
               return $this->response;
            }
            else {
                $error = 'Your username/password did not match.';
            }
        }
        
        $this->template->setLayout('layout');
        $this->template->setView('login');
        $this->template->setData([
            'error' => $error,
        ]);
        
        $this->response->content->set($this->template->__invoke());
        return $this->response;
    }
    
    public function logout() 
    {
        // Log out, redirect
        session_destroy();
        $this->response->redirect->to('/');
        return $this->response;
    }
}