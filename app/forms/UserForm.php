<?php


namespace App\Forms;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
//use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Submit;
//validation
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Email;


class UserForm extends Form
{
    public function initialize()
    {

        $name = new Text(
            'name',
            [
                'maxlength' => 30,
                'placeholder' => 'Type your name',
                'class' => "form-control"
            ]
        );
       $login =new Text(
           'login',
           [
               'maxlength' => 30,
               'placeholder' => 'Type your login',
               'class' => "form-control"
           ]
       );
        $password =new Text(
            'password',
            [
                'maxlength' => 30,
                'placeholder' => 'Type your password',
                'class' => "form-control"
            ]
        );

        $email = new Text(
            'email',
            [
                'maxlength' => 30,
                'placeholder' => 'Type your E-mail adress',
                'class' => "form-control"
            ]

        );
        $submit = new Submit(
            'submit',
            [
                'maxlength' => 30,
                'value' => 'log in',
                'class' => "btn btn-primary"
            ]

        );
        $this->add($name);
        $this->add($login);
        $this->add($password);
        $this->add($email);
        $this->add($submit);
        //validation
        $name->addValidator(
            new PresenceOf(
                [
                    'message' => 'The name is required',
                ]
            )
        );
        $login->addValidator(
            new PresenceOf(
                [
                    'message' => 'The login is required',
                ]
            )
        );
        $password->addValidator(
            new PresenceOf(
                [
                    'message' => 'The password is required',
                ]
            )
        );
        $email->addValidator(
            new PresenceOf(
                [
                    'message' => 'The email is required',
                ]
            )
        );
        $email->addValidator(
            new Email(
                [
                    'message' => 'The email is not valid',
                ]
            )
        );



    }


}