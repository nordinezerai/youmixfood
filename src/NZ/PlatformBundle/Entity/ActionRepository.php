<?php

namespace NZ\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ActionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActionRepository extends EntityRepository
{
	public function getActionWithKeyword($keyword)
	  {
	    $qb = $this->createQueryBuilder('a');
	
	    $qb
	      ->where('a.name LIKE :keyword')
	      ->setParameter('keyword','%'.$keyword.'%')
	      ->orderBy('a.name','ASC')
	    ;

	    return $qb->getQuery()->getResult()
	    ;
	  }
}
