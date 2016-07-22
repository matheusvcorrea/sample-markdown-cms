<?php
namespace Role;

return array(
	'doctrine' => array(
		'driver' => array(
			'role_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/Role/Entity')
			),

			'orm_default' => array(
				'drivers' => array(
					'Role\Entity' => 'role_entities'
				)
			)
		)
	)
);