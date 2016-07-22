<?php
namespace Authorize\Form;

use Zend\Form\Form;

/**
* Login Form
*/
class LoginForm extends Form
{
	/**
	 * Construct function
	 */
	public function __construct()
	{
		// we want to ignore the name passed
        parent::__construct('login');
		$this->setAttribute('method', 'post');
		
        $this->add(array(
            'type' => 'Text',
            'name' => 'username', // 'usr_name',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Username',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));        
        $this->add(array(
            'type' => 'Password',
            'name' => 'password', // 'usr_password',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'form-control',
                'placeholder' => 'Password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));        
        $this->add(array(
            'type' => 'Button',
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                'id' => 'login',
                'class' => 'btn btn-default',
            ),
        )); 
	}
}