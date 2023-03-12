<?php

namespace App\Repository;

use App\Entity\Band;
use App\Entity\Concert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Concert>
 *
 * @method Concert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concert[]    findAll()
 * @method Concert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concert::class);
    }

    public function save(Concert $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Concert $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findArchived(): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where($qb->expr()->andX(
                $qb->expr()->lte('c.date', $qb->expr()->literal((new \DateTime())->format('Y-m-d H:i:s'))),
            ))
        ;

        return $qb->getQuery()->getResult();
    }

    public function findFutureConcerts()
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->innerJoin('c.bands', 'b')
            ->where($qb->expr()->andX(
                $qb->expr()->gte('c.date', $qb->expr()->literal((new \DateTime())->format('Y-m-d H:i:s')))
            ));

        return $qb->getQuery()->getResult();
    }

    public function findFutureConcertsByBand(Band $band)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->innerJoin('c.bands', 'b')
            ->where($qb->expr()->andX(
                $qb->expr()->gte('c.date', $qb->expr()->literal((new \DateTime())->format('Y-m-d H:i:s'))),
                $qb->expr()->eq('b.id', $band->getId())
            ));

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Concert[] Returns an array of Concert objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Concert
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
