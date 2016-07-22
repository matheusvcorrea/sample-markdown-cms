<?php
namespace Book;

return array(
    // The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'book' => array(
				'type' => 'literal',
                'options' => array(
                    'route'    => '/book',
                    'defaults' => array(
                        'controller' => 'Book\Controller\Book',
                        'action'     => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/action/[:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Book\Controller\Book',
                            ),
                        ),
                    ),
                    'view' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route' => '/[:url]',
                            'constraints' => array(
                                'url' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'url' => 'empty',
                                'controller' => 'Book\Controller\Book',
                                'action' => 'view'
                            ),
                        ),
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[page/:page]',
                            'defaults' => array(
                                'page' => 1,
                            ),
                        ),
                    ),
                ),
            ),
		),
	),
    
    'controllers' => array(
        'factories' => array(
            'Book\Controller\Book' => function($sm) {
                return new Controller\BookController($sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
            }
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'book_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Book/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Book\Entity' => 'book_entities'
                )
            )
        )
    ),
);