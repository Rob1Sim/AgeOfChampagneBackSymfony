<?php

namespace App\Repository;

use App\Entity\Carte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Carte>
 *
 * @method Carte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carte[]    findAll()
 * @method Carte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carte::class);
    }

    public function save(Carte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Carte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Carte[]
     */
    public function search(string $value = ''): array
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.nom LIKE :value')
            ->setParameter('value', '%'.$value.'%')
            ->orderBy('c.nom', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Carte[]
     */
    public function byVignerons(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.vignerons', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Carte[]
     */
    public function byRegion(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.region', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Carte[]
     */
    public function byCru(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.cru_r', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return int[]
     */
    public function getLastCardsId(): array
    {
        if ('PHP_SESSION_ACTIVE' == session_status()) {
            session_start();
        }

        if (isset($_SESSION['LAST_CARDS'])) {
            return $_SESSION['LAST_CARDS'];
        }

        return [];
    }

    public function addToCardList(int $carteId): void
    {
        if (!isset($_SESSION['LAST_CARDS'])) {
            $_SESSION['LAST_CARDS'] = [$carteId];
        } else {
            $key = array_search($carteId, $_SESSION['LAST_CARDS']);
            if (false !== $key) {
                unset($_SESSION['LAST_CARDS'][$key]);
            } elseif (10 === count($_SESSION['LAST_CARDS'])) {
                array_pop($_SESSION['LAST_CARDS']);
            }
            array_unshift($_SESSION['LAST_CARDS'], $carteId);
        }
    }

    private function replaceExistingCard(int $carteId)
    {
        if (!isset($_SESSION['LAST_CARDS'])) {
            $_SESSION['LAST_CARDS'] = [];
        }
        for ($i = 0; $i < count($_SESSION['LAST_CARDS']); ++$i) {
            if ($_SESSION['LAST_CARDS'][$i] == $carteId) {
                unset($_SESSION['LAST_CARDS']);
                if (!isset($_SESSION['LAST_CARDS'])) {
                    $_SESSION['LAST_CARDS'] = [];
                }
                $_SESSION['LAST_CARDS'] = array_values($_SESSION['LAST_CARDS']);
            }
        }
        array_unshift($_SESSION['LAST_CARDS'], $carteId);
    }
}

//    /**
//     * @return Carte[] Returns an array of Carte objects
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

//    public function findOneBySomeField($value): ?Carte
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }/**
