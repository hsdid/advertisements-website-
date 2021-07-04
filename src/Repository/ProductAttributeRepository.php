<?php

namespace App\Repository;

use App\Entity\ProductAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductAttribute[]    findAll()
 * @method ProductAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductAttribute::class);
    }

    /**
     * @param ProductAttribute $productAttribute
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(ProductAttribute $productAttribute)
    {
        $this->_em->persist($productAttribute);
        $this->_em->flush();
    }

    /**
     * @param ProductAttribute $productAttribute
     * @throws ORMException
     */
    public function persist(ProductAttribute $productAttribute)
    {
        $this->_em->persist($productAttribute);
    }
    // /**
    //  * @return ProductAttribute[] Returns an array of ProductAttribute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductAttribute
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
