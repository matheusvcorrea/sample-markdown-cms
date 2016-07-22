<?php
namespace Book\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

/**
* Book Form
*/
class BookForm extends Form
{
	/**
	 * Construct function
	 */
	public function __construct(ObjectManager $objectManager)
	{
		// we want to ignore the name passed
        parent::__construct('cms');
        $this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setAttribute('method', 'post');

        $this->add(array(
            'type' => 'Text',
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Title',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Title:',
            ),
        ));
        $this->add(array(
            'type' => 'Text',
            'name' => 'url',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Url',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Url:',
            ),
        ));
        $this->add(array(
            'type' => 'Button',
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'save',
                'class' => 'btn btn-success',
            ),
        )); 
    }
}