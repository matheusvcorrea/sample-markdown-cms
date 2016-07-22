<?php
namespace Authorize\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthorizeControllerFactory implements FactoryInterface
{
	/**
	 * Create service
	 * @param  ServiceLocatorInterface $serviceLocator 
	 * @return AuthorizeController                                  
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new AuthorizeController($serviceLocator->getServiceLocator()->get('Zend\Authentication\AuthenticationService'));
	}
}