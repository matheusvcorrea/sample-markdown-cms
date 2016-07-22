<?php
namespace Search\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SearchController extends AbstractActionController
{
	/** 
     * @var EntityManagerInterface;
     **/
    protected $entityManager;

    /**
     * Constructor.
     * 
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function searchAction()
    {
    	$query = $this->params()->fromQuery('q');
        if (!empty($query)) {
        	$repository = $this->entityManager->getRepository('Cms\Entity\Page');
        	$param      = '%' . $query . '%';

    		$result = $repository->createQueryBuilder('page')
					->where('page.title LIKE :query')
					->orWhere('page.url LIKE :query')
					->setParameter('query', $param)
					->getQuery()
					->getResult();
            
            return new ViewModel(array(
            	'query'  => $query,
            	'result' => $result,
            ));
        } else {
            $repository = $this->entityManager->getRepository('Cms\Entity\Page');
            $result = $repository->findAll();
            
            return new ViewModel(array(
                'query'  => '&nbsp',
                'result' => $result,
            ));
        }
    }
}