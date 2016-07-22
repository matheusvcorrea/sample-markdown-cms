<?php
namespace Search\View\Helper;

use Search\Form\SearchForm;
use Zend\Mvc\MvcEvent;
use Zend\Form\FormInterface;
use Zend\View\Helper\AbstractHelper;

class Search extends AbstractHelper
{
	protected $query;

	public function __construct(MvcEvent $e)
	{
		$this->query = $e->getRequest()->getQuery('q', null);
	}

	public function __invoke($class = null)
	{
		$url = $this->getView()->plugin('url');
		$form = new SearchForm();
		$form->setAttribute('action', $url('search'));
		
		if ($this->query) {
			$form->get('q')->setValue($this->query);
		}

		if ($class) {
			$form->setAttribute('class', $class);
		}

		return $this->render($form);
	}

	public function render(FormInterface $form)
	{
		$form->prepare();
		$viewForm    = $this->getView()->plugin('form');
		$formElement = $this->getView()->plugin('formElement');
		$html = $viewForm->openTag($form);
		
		/*// ...loop through and render the form elements...
		foreach ($form as $element) {
		    $formElement = $this->getView()->plugin('formElement');
		    $html .= $formElement($element);
		}*/
		
		$html .= '<div class="input-group">';
		$html .= $formElement($form->get('q'));
	    $html .= '<span class="input-group-btn">';
		$html .= $formElement($form->get('submit'));
	    $html .= '</span>';
	    $html .= '</div><!-- /input-group -->';
		$html .= $viewForm->closeTag();
		
		return $html;
	}
}