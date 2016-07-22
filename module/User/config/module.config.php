<?php
namespace User;

return array(
	'doctrine' => array(
		'driver' => array(
			'user_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/User/Entity')
			),

			'orm_default' => array(
				'drivers' => array(
					'User\Entity' => 'user_entities'
				)
			)
		)
	)
);