<?php

namespace App\Repository;

use App\Entity\Mep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mep>
 *
 * @method Mep|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mep|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mep[]    findAll()
 * @method Mep[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MepRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mep::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(Mep $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
