<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    protected $max_price;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
        $this->max_price = $this->findBy([],['product_price' => 'DESC'],1)[0]->getProductPrice();
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
        // $max_price = $this->findBy(['product_price' > "0"], ['product_price' => 'DESC'], 1)[0]->getProductPrice();
        // $max_price = $this->findBy([],['product_price' => 'DESC'],1)[0]->getProductPrice();
        return $this->createQueryBuilder('p')
            ->andWhere('p.product_price BETWEEN :minPrice AND :maxPrice')
            ->setParameter('minPrice', $min_price)
            ->setParameter('maxPrice', $max_price)
            ->getQuery()
            ->getResult();
    }

    public function max_price_from_each_type() {
        $entityManager = $this->getEntityManager();

        $rsm = new ResultSetMapping;

        $rsm->addEntityResult(Product::class,'p1');
        $rsm->addFieldResult('p1','product_id','product_id');
        $rsm->addFieldResult('p1','type','type_id');
        $rsm->addFieldResult('p1','product_price','product_price');

        $rsm->addEntityResult(Product::class,'p2');
        $rsm->addFieldResult('p2','type','type_id');
        $rsm->addFieldResult('p2','product_price','product_price');

        $sql = "SELECT p1.product_id, p1.type_id FROM products p1 JOIN (SELECT type_id, MAX(product_price) as max_product_price_by_type FROM products GROUP BY type_id)p2 ON p1.type_id = p2.type_id AND p1.product_price = p2.max_product_price_by_type ORDER BY p1.type_id";

        return $entityManager->createNativeQuery($sql ,$rsm)->getResult();
    }
}
