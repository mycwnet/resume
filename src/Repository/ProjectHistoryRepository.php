<?php

namespace App\Repository;

use App\Entity\ProjectHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method ProjectHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectHistory[]    findAll()
 * @method ProjectHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectHistoryRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, ProjectHistory::class);
    }

}