<?php
namespace Book\Controller;

use Book\Entity\Book;
use Book\Form\BookForm;
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class BookController extends AbstractActionController
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

	public function listAction()
	{
		$em    = $this->entityManager->getRepository('Book\Entity\Book');
        $books = $em->findAll();

        $adapter = new SelectableAdapter($em);

        $paginator = new Paginator($adapter);
        $page = (($this->params()->fromRoute('page')) ? $this->params()->fromRoute('page') : 1);
        $paginator->setCurrentPageNumber((int)$page)
                ->setItemCountPerPage(10);
        
        return new ViewModel(array(
            'books' => $books,
            'paginator' => $paginator,
        ));
	}

	public function viewAction() 
	{
		$url = $this->params()->fromRoute('url');
		if (!($url == 'empty')) {
			$em  = $this->entityManager;
			$repository = $em->getRepository('Book\Entity\Book');
			$book = $repository->findOneBy(array('url' => $url));

			return new ViewModel(array(
				'book' => $book,
			));
		} else {
			return $this->notFoundAction();
		}
	}

	public function createAction()
    {
        $em   = $this->entityManager;
        $book = new Book();
        $form = new BookForm($em);
        $identity = $this->identity();

        $form->bind($book);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // $book->setCreated(new \DateTime());
                // $book->setAuthor($identity);
                $em->persist($book);
                $em->flush();

                return $this->redirect()->toRoute('book');
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function editAction()
    {
        $id   = $this->params()->fromRoute('id');
        $em   = $this->entityManager;
        $book = $em->getRepository('Book\Entity\Book')->findOneBy(array('id' => $id));
        $form = new BookForm($em);
        $identity = $this->identity();

        $form->bind($book);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // $book->setCreated(new \DateTime());
                // $book->setAuthor($identity);
                $em->persist($book);
                $em->flush();
            }
        }
        
        return new ViewModel(array(
            'book' => $book,
            'form' => $form
        ));
    }

    public function deleteAction()
    {
        $id   = $this->params()->fromRoute('id');
        $em   = $this->entityManager;
        $book = $em->getRepository('Book\Entity\Book')->find($id);
        
        if ($book) {
            $em->remove($book);
            $em->flush();
            
            return $this->redirect()->toRoute('book');
        }
        
        return new ViewModel(array(
            'bookId' => $id
        ));
    }
}