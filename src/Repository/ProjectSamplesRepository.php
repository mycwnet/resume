<?php

namespace App\Repository;

use App\Entity\ProjectSamples;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method ProjectSamples|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectSamples|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectSamples[]    findAll()
 * @method ProjectSamples[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectSamplesRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, ProjectSamples::class);
    }

}