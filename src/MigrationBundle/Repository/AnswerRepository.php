<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 04/02/17
 * Time: 16:06
 */

namespace MigrationBundle\Repository;


class AnswerRepository extends \Doctrine\ORM\EntityRepository
{
    public function migration(){
        $qb= $this->createQueryBuilder('a')
            ->select('a.word, a.id')
            ->getQuery();
        return $qb->getResult();
    }

    /* Query to get the 20 most used word in surveys*/
    public function getword20(){
        $qb= $this->createQueryBuilder('a')
            ->select('a.word as word', 'count(i) as total')
            ->groupBy('a.word')
            ->innerJoin('a.interview','i')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();
        return $qb->getResult();

    }

    /* Query to get the 20 most used word by sexes */
    public function getword20bysexe($sexe){
        $qb= $this->createQueryBuilder('a')
            ->select('a.word as word', 'count(i) as total')
            ->groupBy('a.word')
            ->innerJoin('a.interview','i')
            ->where('u.gender = :sexe')
            ->setParameter('sexe', $sexe)
            ->join('i.user', 'u')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();
        return $qb->getResult();
    }

    /* Query to get the 20 most used word by status */
    public function getword20bystatus($status){
        $qb= $this->createQueryBuilder('a')
            ->select('a.word as word', 'count(i) as total')
            ->groupBy('a.word')
            ->innerJoin('a.interview','i')
            ->where('u.status = :status')
            ->setParameter('status', $status)
            ->join('i.user', 'u')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();
        return $qb->getResult();
    }

    /* Query to get the 20 most used word by status */
    public function getword20byage($ageMin, $ageMax){
        $qb= $this->createQueryBuilder('a')
            ->select('a.word as word', 'count(i) as total')
            ->groupBy('a.word')
            ->innerJoin('a.interview','i')
            ->where('u.age >= :ageMin')
            ->andWhere('u.age <= :ageMax')
            ->setParameter('ageMin', $ageMin)
            ->setParameter('ageMax', $ageMax)
            ->join('i.user', 'u')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();
        return $qb->getResult();
    }
}