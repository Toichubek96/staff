<?php

class AdminController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('admin_');
    }
    public function indexAction()
    {
//        var_dump($this->session->get('auth-identity'));
////        var_dump( $this->auth-> hasIdentity());
//        $this->view->disable();
//        echo 'salam';


    }

}

