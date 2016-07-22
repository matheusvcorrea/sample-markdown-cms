<?php
namespace Book\Form;

use Cms\Form\CmsForm as Base;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

/**
* Cms Form
*/
class CmsForm extends Base
{
	/**
	 * Construct function
	 */
	public function __construct(ObjectManager $objectManager)
	{
		// we want to ignore the name passed
        parent::__construct($objectManager);
        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'book',
                'options' => array(
                    'object_manager'  => $objectManager,
                    'target_class'    => 'Book\Entity\Book',
                    'label_generator' => function($targetEntity) {
                        return $targetEntity->getTitle();
                    },
                    'label' => 'Book: ',
                )
            )
        );
    }
}