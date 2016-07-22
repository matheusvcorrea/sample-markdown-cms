<?php
namespace Authorize;

return array(
    // The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'authentication' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        'controller' => 'Authorize\Controller\Authorize',
                        'action'     => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'Authorize\Controller\Authorize',
                        'action'     => 'logout',
                    ),
                ),
            ),
		),
	),

    'service_manager' => array(
        'services' => array(
            // 'AuthorizeService' => new \Authorize\Service\AuthorizeService(),
            'RoleProvider'      => 'Role\Entity\Role',
            'ResourceProvider'  => 'Resource\Entity\Resource',
            'PrivilegeProvider' => 'Privilege\Entity\Privilege',
        ),
        'invokables' => array(
            'AuthorizeRouteListener' => 'Authorize\Listener\AuthorizeRouteListener',
            'AuthenticateListener' => 'Authorize\Listener\AuthenticateListener',
        ),
    ),
    
    'controllers' => array(
        'factories' => array(
            'Authorize\Controller\Authorize' => 'Authorize\Controller\AuthorizeControllerFactory'
        ),
    ),

    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager'      => 'Doctrine\ORM\EntityManager',
                'identity_class'      => 'User\Entity\User',
                'identity_property'   => 'username',
                'credential_property' => 'password',
                'credential_callable' => function(\User\Entity\User $user, $passwordGiven) {
                    if ($user->getPassword() == md5($passwordGiven)) {
                        return true;
                    }
                    
                    return false;
                },
            ),
        ),
    ),
    
    'view_manager' => array(        
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
