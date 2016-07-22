<?php
namespace Cms;

return array(
    // The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'cms' => array(
				'type' => 'literal',
                'options' => array(
                    'route' => '/cms',
                    'defaults' => array(
                        'controller' => 'Cms\Controller\Cms',
                        'action' => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Cms\Controller\Cms',
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
            'home' => array(
                'may_terminate' => true,
                'child_routes' => array(
                    'page' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route' => '[:slug]',
                            'constraints' => array(
                                'slug' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'slug' => 'home',
                                'controller' => 'Cms\Controller\Cms',
                                'action' => 'view'
                            ),
                        ),
                    ),
                ),
            ),
        ),
	),
    
    'controllers' => array(
        'factories' => array(
            'Cms\Controller\Cms' => function($sm) {
                return new Controller\CmsController(
                    $sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'),
                    $sm->getServiceLocator()->get('CmsForm')
                );
            }
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'cms_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Cms/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Cms\Entity' => 'cms_entities'
                )
            )
        ),
    ),
);
