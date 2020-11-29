<?php

namespace NZ\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AppareilRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AppareilRepository extends EntityRepository
{
	public function getAppareilWithKeyword($keyword)
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