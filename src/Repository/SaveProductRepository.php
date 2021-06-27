<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\SaveProduct;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SaveProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaveProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaveProduct[]    findAll()
 * @method SaveProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaveProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaveProduct::class);
    }

    /**
     * @param SaveProduct $saveProduct
     * @throws ORMException
     */
    public function save(SaveProduct $saveProduct)
    {
        $this->_em->persist($saveProduct);
        $this->_em->flush();
    }

    /**
     * @param SaveProduct $saveProduct
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(SaveProduct $saveProduct)
    {
        $this->_em->remove($saveProduct);
        $this->_em->flush();
    }



    // /**
    //  * @return SaveProduct[] Returns an array of SaveProduct objects
    //  */

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUserAndProduct($userId, $productId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.user = :user')
            ->andWhere('s.product = :product')
            ->setParameters(['product' => $productId, 'user' => $userId])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?SaveProduct
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
