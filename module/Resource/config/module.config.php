<?php
namespace Resource;

return array(
	'doctrine' => array(
		'driver' => array(
			'resource_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/Resource/Entity')
			),

			'orm_default' => array(
				'drivers' => array(
					'Resource\Entity' => 'resource_entities'
				)
			)
		)
	)
);