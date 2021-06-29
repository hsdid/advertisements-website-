<?php

namespace App\Repository;

use App\Entity\AttributesForCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttributesForCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributesForCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributesForCategory[]    findAll()
 * @method AttributesForCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributesForCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttributesForCategory::class);
    }

    /**
     * @param AttributesForCategory $attributesForCategory
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(AttributesForCategory $attributesForCategory)
    {
        $this->_em->persist($attributesForCategory);
        $this->_em->flush();
    }

    // /**
    //  * @return AttributesForCategory[] Returns an array of AttributesForCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttributesForCategory
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
