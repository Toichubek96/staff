<?php
//namespace App\Controllers;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    /**
     * Execute before the router so we can determine if this is a private controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();
        //Checks if a controller is private or not
//        $this->acl->rebuild();
//        print_die(1);
        if ($this->acl->isPrivate($controllerName)) {
            // Get the current identity
            $identity = $this->auth->getIdentity();
            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {
                $dispatcher->forward([
                    'controller' => 'index',
                    'action' => 'index'
                ]);
                return false;


            }
            // Check if the user have permission to the current option
            $actionName = $dispatcher->getActionName();
//            echo '<pre>';
//            var_dump($this->acl->getAcl());
//            echo '</pre>';
//            exit;
            if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {
                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

//                if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
//                    $dispatcher->forward([
//                        'controller' => $controllerName,
//                        'action' => 'index'
//                    ]);
//                } else {
                $dispatcher->forward([
                    'controller' => 'Alert',
                    'action' => 'index'
                ]);
                return false;
//                }


            }


        }


    }

}
