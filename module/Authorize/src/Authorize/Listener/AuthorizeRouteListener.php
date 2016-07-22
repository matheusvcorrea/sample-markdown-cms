<?php
namespace Authorize\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class AuthorizeRouteListener extends AbstractListenerAggregate
{
    /**
     * {@inheritDoc}
     */
	public function attach(EventManagerInterface $events)
    {
    	$this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'), -1000);
    }

    /**
     * Event callback to be triggered on route, causes application error triggering
     * in case of failed authorization check
     * 
     * @param  MvcEvent $e
     * @return mixed
     */
    public function onRoute(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $aclService = $serviceManager->get('AclService');
        $authenticationService = $serviceManager->get('Zend\Authentication\AuthenticationService');

        $identity = 'Guest';
        if ($authenticationService->getIdentity()) {
            $identity = $authenticationService->getIdentity()->getRole()->getName();
        }
        $resource  = $e->getRouteMatch()->getParam('controller');
        $privilege = $e->getRouteMatch()->getParam('action');

        if ($aclService->isAllowed($identity, $resource, $privilege)) {
            return;
        }

        // Set the event's 'error' vars
        $e->setError('ERROR_EXCEPTION');
        $e->setParam('exception', new \Exception('Permission Denied. This user is not allowed'));

        // Trigger the dispatch.error event
        $e->getApplication()->getEventManager()->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $e);

        // The missing piece! Required to ensure the remaining dispatch 
        // listeners are not triggered
        $e->stopPropagation(true);

        // Contains the view model that was set via the ExceptionStrategy
        return $e->getResult();
    }
}