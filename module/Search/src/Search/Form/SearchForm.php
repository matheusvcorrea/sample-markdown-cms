<?php
namespace Search\Form;

use Zend\Form\Form;

/**
* Search Form
*/
class SearchForm extends Form
{
	/**
	 * Construct function
	 */
	public function __construct()
	{
		// we want to ignore the name passed
        parent::__construct('search');
		$this->setAttribute('method', 'get');
        // $this->setAttribute('action', 'search');
		
        $this->add(array(
            'name' => 'q', // 'usr_name',
            'type' => 'Text',
            'attributes' => array(
                'type'  => 'search',
                'class' => 'form-control',
                'placeholder' => 'Search for...',
            ),
            'options' => array(
                'label' => 'Search',
            ),
        ));
        $this->add(array(
            'type' => 'Button',
            'name' => 'submit',
            'options' => array(
                'label' => 'Search',
            ),
            'attributes' => array(
                'type' => 'submit',
                'class' => 'btn btn-default'
            )
        )); 
	}
}