<?php
namespace Privilege;

return array(
	'doctrine' => array(
		'driver' => array(
			'privilege_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/Privilege/Entity')
			),

			'orm_default' => array(
				'drivers' => array(
					'Privilege\Entity' => 'privilege_entities'
				)
			)
		)
	)
);