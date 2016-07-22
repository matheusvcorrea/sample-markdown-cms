<?php
namespace Cms\Controller;

use Cms\Form\CmsForm;
use Cms\Entity\Page;
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\FormInterface;
use Zend\View\Model\JsonModel;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class CmsController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var CmsForm
     */
    protected $cmsForm;

    /**
     * Constructor
     * 
     * @param EntityManagerInterface $entityManager
     * @param  FormInterface $cmsForm
     */
    public function __construct(EntityManagerInterface $entityManager, FormInterface $cmsForm)
    {
        $this->entityManager = $entityManager;
        $this->cmsForm = $cmsForm;

    }

    /**
     * List of items
     * 
     * @return ViewModel
     */
    public function listAction()
    {
		$em    = $this->entityManager->getRepository('Cms\Entity\Page');
		$pages = $em->findAll();

        $adapter = new SelectableAdapter($em);

        $paginator = new Paginator($adapter);
        $page = (($this->params()->fromRoute('page')) ? $this->params()->fromRoute('page') : 1);
        $paginator->setCurrentPageNumber((int)$page)
                ->setItemCountPerPage(10);
		
        return new ViewModel(array(
        	'pages' => $pages,
            'paginator' => $paginator,
        ));
    }

    public function createAction()
    {
        $em   = $this->entityManager;
        $page = new Page();
        $form = $this->cmsForm;
        $identity = $this->identity();

        $form->bind($page);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $page->setCreated(new \DateTime());
                $page->setAuthor($identity);
                $em->persist($page);
                $em->flush();

                return $this->redirect()->toRoute('cms');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * Edit Page by ID
     * 
     * @return ViewModel
     */
    public function editAction()
    {
        $id   = $this->params()->fromRoute('id');
        $em   = $this->entityManager;
        $page = $em->getRepository('Cms\Entity\Page')->findOneBy(array('id' => $id));
        $form = $this->cmsForm;
        $identity = $this->identity();

        $form->bind($page);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $page->setCreated(new \DateTime());
                $page->setAuthor($identity);
                $em->persist($page);
                $em->flush();
            }
        }
    	
        return new ViewModel(array(
            'page' => $page,
            'form' => $form
        ));
    }

    public function viewAction()
    {
    	$slug = $this->params()->fromRoute('slug');
        $repository = $this->entityManager->getRepository('Cms\Entity\Page');
        $page = $repository->findOneBy(array('url' => $slug));
        
        if (!$page) {
            return $this->notFoundAction();
        }

        $previous = $repository->getPreviousPage($page->getId(), $page->getBook()->getId());
        $next = $repository->getNextPage($page->getId(), $page->getBook()->getId());

        return new ViewModel(array(
            'page' => $page,
            'nextPage' => $next,
            'previousPage' => $previous
        ));
    }

    public function deleteAction()
    {
        $id   = $this->params()->fromRoute('id');
        $em   = $this->entityManager;
        $page = $em->getRepository('Cms\Entity\Page')->find($id);
        
        if ($page) {
            $em->remove($page);
            $em->flush();
            
            return $this->redirect()->toRoute('cms');
        }
        
        return new ViewModel(array(
            'pageId' => $id
        ));
    }
}