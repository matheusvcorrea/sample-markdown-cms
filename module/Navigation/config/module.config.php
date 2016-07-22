<?php
namespace Navigation;

return array(
    'service_manager' => array(
        'factories' => array(
            'MyNavigation' => 'Navigation\Service\NavigationFactory',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'navigation_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Navigation/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Navigation\Entity' => 'navigation_entities'
                )
            )
        )
    )
);
