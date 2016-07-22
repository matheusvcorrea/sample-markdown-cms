<?php
namespace Authorize\Listener;

use Authorize\Event\AuthenticateEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\ListenerAggregateInterface;

class AuthenticateListener extends AbstractListenerAggregate implements ListenerAggregateInterface
{
    protected $listeners = array();

	/**
     * {@inheritDoc}
     */
	public function attach(EventManagerInterface $events)
    {
    	$sharedEvents      = $events->getSharedManager();
    	$this->listeners[] = $sharedEvents->attach(
								'Zend\Mvc\Controller\AbstractActionController',
								AuthenticateEvent::EVENT_AUTHENTICATE,
								array($this, 'onAuthenticate')
                            );
        $this->listeners[] = $sharedEvents->attach(
                                'Zend\Mvc\Controller\AbstractActionController',
                                AuthenticateEvent::EVENT_AUTHENTICATE_SUCCESS,
                                array($this, 'onAuthenticateSuccess')
                            );
        $this->listeners[] = $sharedEvents->attach(
                                'Zend\Mvc\Controller\AbstractActionController',
                                AuthenticateEvent::EVENT_AUTHENTICATE_FAIL,
                                array($this, 'onAuthenticate')
                            );
    }

    /**
     * {@inheritDoc}
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Event callback to be triggered on authenticate
     * 
     * @param  Event $e
     * @return 
     */
    public function onAuthenticate($e)
    {
        // $controller = $e->getTarget();
        // $controller->plugin('redirect')->toRoute('home');
    }

    /**
     * Event callback to be triggered on authenticate
     * 
     * @param  Event $e
     * @return 
     */
    public function onAuthenticateSuccess($e)
    {
        // $controller = $e->getTarget();
        // $controller->plugin('redirect')->toRoute('dashboard');
    }
}