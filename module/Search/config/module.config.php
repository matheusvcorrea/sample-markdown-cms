<?php
namespace Search;

return array(
    // The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'search' => array(
				'type' => 'literal',
                'options' => array(
                    'route'    => '/search',
                    'defaults' => array(
                        'controller' => 'Search\Controller\Search',
                        'action' => 'search',
                    ),
                ),
                'may_terminate' => true,
            ),
		),
	),
    
    'controllers' => array(
        'factories' => array(
            'Search\Controller\Search' => function($sm) {
                return new Controller\SearchController($sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
            }
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
