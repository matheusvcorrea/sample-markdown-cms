<?php
namespace Authorize\Event;

use Zend\EventManager\Event;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

class AuthenticateEvent extends Event implements EventManagerAwareInterface
{
	const EVENT_AUTHENTICATE = 'authenticate';
    const EVENT_AUTHENTICATE_FAIL = 'authenticate.fail';
    const EVENT_AUTHENTICATE_SUCCESS = 'authenticate.success';

    /**
     * @var EventManagerInterface
     */
    protected $events;

    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $events;
        return $this;
    }

    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }
}