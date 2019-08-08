<?php

namespace App\Repository;

use App\Entity\CoverLetter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoverLetterRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, CoverLetter::class);
    }

}
