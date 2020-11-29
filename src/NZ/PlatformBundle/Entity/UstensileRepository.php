<?php

namespace NZ\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UstensileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UstensileRepository extends EntityRepository
{
	public function getUstensileWithKeyword($keyword)
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