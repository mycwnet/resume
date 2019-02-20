<?php

namespace App\Repository;

use App\Entity\Proficiencies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method Proficiencies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proficiencies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proficiencies[]    findAll()
 * @method Proficiencies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProficienciesRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Proficiencies::class);
    }

}