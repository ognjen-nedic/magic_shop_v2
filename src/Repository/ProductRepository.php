<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Product $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function sort_by_price($sort_type = 'ASC') {
        return $this->createQueryBuilder('p')
            ->orderBy('p.product_price', $sort_type)
            ->getQuery()
            ->getResult();
        
    }

    public function filter_by_type($value) {
        return $this->createQueryBuilder('p')
            ->andWhere('p.type = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getResult();
    }

    public function filter_by_rarity($value) {
        return $this->createQueryBuilder('p')
            ->andWhere('p.rarity = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getResult();
    }

    
    public function filter_by_price_range($min_price = 1, $max_price) {
        //$max_price = $this->findBy(['product_price' > "0"], ['product_price' => 'DESC'], 1)[0]->getProductPrice();
        $max_price = $this->findBy([],['product_price' => 'DESC'],1)[0]->getProductPrice();
        return $this->createQueryBuilder('p')
            ->andWhere('p.product_price BETWEEN :minPrice AND :maxPrice')
            ->setParameter('minPrice', $min_price)
            ->setParameter('maxPrice', $max_price)
            ->getQuery()
            ->getResult();
    }

    /* public function max_price_from_each_type() {
        $statement = $this->_em->getConnection()->prepare("SELECT * FROM products p1 JOIN (SELECT type_id, MAX(product_price) as max_product_price_by_type FROM products GROUP BY type_id)p2 ON p1.type_id = p2.type_id AND p1.product_price = p2.max_product_price_by_type ORDER BY p1.type_id;");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    } */
}
