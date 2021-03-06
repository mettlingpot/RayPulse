<?php

namespace MP\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByDate()
    {
      $qb = $this->createQueryBuilder('a');

      $qb
         ->orderBy('a.datedebut', 'ASC')
      ;

      return $qb
        ->getQuery()
        ->getResult()
      ;
    }
    
    public function findByUser($id)
    {
      $qb = $this->createQueryBuilder('a');

      $qb->where('a.user = :id')->setParameter('id', $id)
      ;

      return $qb
        ->getQuery()
        ->getResult()
      ;
    }

    public function findByRecherche($recherche)
    {
  
      $qb = $this->createQueryBuilder('a');

      $qb   ->innerJoin('a.adresse', 'adr')
            ->innerJoin('a.categories', 'c')
            ->addSelect('adr')
            ->addSelect('c')
            ->where('a.title LIKE :id')
            ->orwhere('a.content LIKE :id')
            ->orwhere('a.id LIKE :id')
            ->orwhere('adr.ville LIKE :id')
            ->orwhere('c.name LIKE :id')
            
            ->setParameter('id', '%'.$recherche.'%')
            ->orderBy('a.datedebut', 'ASC')
      ;

      return $qb
        ->getQuery()
        ->getResult()
      ;
    }
    public function findAllPagination($page, $nbMaxParPage)
    {
        if (!is_numeric($page)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
            );
        }

        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }

        if (!is_numeric($nbMaxParPage)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $nbMaxParPage est incorrecte (valeur : ' . $nbMaxParPage . ').'
            );
        }
    
        $qb = $this->createQueryBuilder('a')
         ->orderBy('a.datedebut', 'ASC');
        
        $query = $qb->getQuery();

        $premierResultat = ($page - 1) * $nbMaxParPage;
        $query->setFirstResult($premierResultat)->setMaxResults($nbMaxParPage);
        $paginator = new Paginator($query);

        if ( ($paginator->count() <= $premierResultat) && $page != 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas.'); // page 404, sauf pour la première page
        }

        return $paginator;
    }
    public function findByApi($id){

        $qb = $this->createQueryBuilder('a');

      $qb->where('a.user = :id')->setParameter('id', $id)
      ;

      return $qb
        ->getQuery()
        ->getResult()
      ;
    }
}


