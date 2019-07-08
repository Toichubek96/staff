<?php


namespace App\Forms;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Hidden;

//use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Submit;
//validation
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
class LoginForm extends Form
{
    public function initialize()
    {
        // Email
        $email = new Text('email', [
            'placeholder' => 'Email',
            'class' => "form-control"
        ]);

        $email->addValidators([
            new PresenceOf([
                'message' => 'The e-mail is required'
            ]),
            new Email([
                'message' => 'The e-mail is not valid'
            ])
        ]);

        $this->add($email);

        // Password
        $password = new Password('password', [
            'placeholder' => 'Password',
            'class' => "form-control"
        ]);

        $password->addValidator(new PresenceOf([
            'message' => 'The password is required'
        ]));

        $password->clear();

        $this->add($password);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        ]));

        $csrf->clear();

        $this->add($csrf);

        $this->add(new Submit('login', [
            'class' => "btn btn-primary"
        ]));
    }

}