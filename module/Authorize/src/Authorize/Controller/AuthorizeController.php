<?php
namespace Authorize\Controller;

use Authorize\Form\LoginForm;
use Authorize\Event\AuthenticateEvent;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;

class AuthorizeController extends AbstractActionController
{
	/**
	 * @var AuthenticationServiceInterface
	 */
	protected $authenticationService;

	/**
	 * Constructor.
	 * 
	 * @param AuthenticationServiceInterface $authenticationService
	 */
	public function __construct(AuthenticationServiceInterface $authenticationService)
	{
		$this->authenticationService = $authenticationService;
	}

	public function loginAction()
	{
		$form    = new LoginForm();
		$request = $this->getRequest();
		
       	$this->getEventManager()->trigger(AuthenticateEvent::EVENT_AUTHENTICATE, $this);
		if ($request->isPost()) {
			$data = $request->getPost();
			$form->setData($data);
			if ($form->isValid()) {
				$adapter = $this->authenticationService->getAdapter();
				$adapter->setIdentityValue($data['username']);
				$adapter->setCredentialValue($data['password']);
				$authResult = $this->authenticationService->authenticate();

				if ($authResult->isValid()) {
					$this->getEventManager()->trigger(AuthenticateEvent::EVENT_AUTHENTICATE_SUCCESS, $this);
					return $this->redirect()->toRoute('dashboard');
				} else {
					$this->getEventManager()->trigger(AuthenticateEvent::EVENT_AUTHENTICATE_FAIL, $this);
					throw new \Exception("Not Authorized. User or password incorrect");
				}
			}
		}

		return array('form'	=> $form,);
	}

	public function logoutAction()
	{
		$this->authenticationService->clearIdentity();
		
		return $this->redirect()->toRoute('authentication');
	}
}