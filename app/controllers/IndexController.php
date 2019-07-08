<?php
//namespace App\Controllers;

use App\Forms\LoginForm;
use App\Forms\SignUpForm;
//use Phalcon\Mvc\Controller as ControllerBase;
use App\library\Auth\Exception as AuthException;
use App\Models\Profiles;
use App\Models\Users;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $form = new LoginForm();
        try {
            if ($this->request->isPost()) {
                if ($form->isValid($this->request->getPost()) == false) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                } else {

                    $this->auth->check([
                        'email' => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password')
                    ]);
                    if ($this->auth->getProfile() == 'user') {
                        return $this->response->redirect('users');
                    } else {
                        return $this->response->redirect('admin');
                    }

                }
            }


        } catch (AuthException $e) {
            $this->flash->error($e->getMessage());
        }
        $this->view->form = $form;

    }

    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();

        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) != false) {
                $profile = Profiles::findFirstByName('admin');
                $user = new Users([
                    'name' => $this->request->getPost('name', 'striptags'),
                    'login' => $this->request->getPost('name', 'striptags'),
                    'password' => $this->security->hash($this->request->getPost('password')),
                    'email' => $this->request->getPost('email'),
                    'active' => 'Y',
                    'profilesId' => $profile->id
                ]);

                if ($user->save()) {
//                    return $this->dispatcher->forward([
//                        'controller' => 'index',
//                        'action' => 'index'
//                    ]);
                    return $this->response->redirect('index');
                }

                $this->flash->error($user->getMessages());
            }
//            else{
//                foreach ($form->getMessages() as $message) {
//                    $this->flash->error($message);
//                }
//            }
        }

        $this->view->form = $form;
    }


}

