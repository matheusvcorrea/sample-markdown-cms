<?php
namespace Cms\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
* Page Repository
*/
class PageRepository extends EntityRepository
{
	public function getNextPage($pageId, $bookId)
    {
        $dql   = "SELECT p FROM Cms\Entity\Page p WHERE p.id > :id AND p.book = :bookId ORDER BY p.order ASC, p.created ASC";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameters(array('id' => $pageId, 'bookId' => $bookId));
		$query->setMaxResults(1);
		$page  = $query->getOneOrNullResult();

		return $page;
    }

    public function getPreviousPage($pageId, $bookId)
    {
        $dql   = "SELECT p FROM Cms\Entity\Page p WHERE p.id < :id AND p.book = :bookId ORDER BY p.id DESC, p.created DESC";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameters(array('id' => $pageId, 'bookId' => $bookId));
        $query->setMaxResults(1);
        $page  = $query->getOneOrNullResult();

        return $page;
    }
}