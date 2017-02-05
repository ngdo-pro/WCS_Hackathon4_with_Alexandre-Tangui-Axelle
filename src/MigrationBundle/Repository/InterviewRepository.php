<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 04/02/17
 * Time: 16:51
 */

namespace MigrationBundle\Repository;


class InterviewRepository extends \Doctrine\ORM\EntityRepository
{
    // function that returns the 20 most answered jobs
    public function get20jobs() {
        $qb = $this->createQueryBuilder('i')
            ->select('j.name as name', 'count(i.id) as total')
            ->innerJoin('i.job', 'j')
            ->groupBy('i.job')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();

        return $qb->getResult();

    }

    //  function that returns the 20 most answered domains
    public function get20domains()
    {
        $qb = $this->createQueryBuilder('i')
            ->select('j.domain as domain', 'count(i.id) as total')
            ->innerJoin('i.job', 'j')
            ->groupBy('j.domain')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();

        return $qb->getResult();
    }

    // function that returns the 20 most answered domains by sexe
    public function get20domainsbysexe($sexe) {
        $qb = $this->createQueryBuilder('i')
            ->select('j.domain as domain', 'count(i.id) as total')
            ->innerJoin( 'i.job', 'j')
            ->where('u.gender = :sexe')
            ->setParameter('sexe', $sexe)
            ->innerJoin('i.user', 'u')
            ->groupBy('j.domain')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();

        return $qb->getResult();
    }

    // function that returns the 20 most answered jobs by sexe
    public function get20jobsbysexe($sexe)
    {
        $qb = $this->createQueryBuilder('i')
            ->select('j.name as name', 'count(i.id) as total')
            ->innerJoin('i.job', 'j')
            ->where('u.gender = :sexe')
            ->setParameter('sexe', $sexe)
            ->innerJoin('i.user', 'u')
            ->groupBy('i.job')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();

        return $qb->getResult();
    }

    // function that returns the 20 most answered domains by status
    public function get20domainsbystatus($statut) {
        $qb = $this->createQueryBuilder('i')
            ->select('j.domain as domain', 'count(i.id) as total')
            ->innerJoin( 'i.job', 'j')
            ->where('u.status = :statut')
            ->setParameter('statut', $statut)
            ->innerJoin('i.user', 'u')
            ->groupBy('j.domain')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();

        return $qb->getResult();
    }

    // function that returns the 20 most answered jobs by status
    public function get20jobsbystatus($statut)
    {
        $qb = $this->createQueryBuilder('i')
            ->select('j.name as name', 'count(i.id) as total')
            ->innerJoin('i.job', 'j')
            ->where('u.status = :statut')
            ->setParameter('statut', $statut)
            ->innerJoin('i.user', 'u')
            ->groupBy('i.job')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();

        return $qb->getResult();
    }

    // function that returns the 20 most answered jobs by age
    public function get20jobsbyage($ageMin, $ageMax)
    {
        $qb = $this->createQueryBuilder('i')
            ->select('j.name as name', 'count(i.id) as total')
            ->innerJoin('i.job', 'j')
            ->where('u.age >= :ageMin')
            ->andWhere('u.age <= :ageMax')
            ->setParameter('ageMin', $ageMin)
            ->setParameter('ageMax', $ageMax)
            ->innerJoin('i.user', 'u')
            ->groupBy('i.job')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();

        return $qb->getResult();
    }

    // function that returns the 20 most answered domains by age
    public function get20domainsbyage($ageMin, $ageMax) {
        $qb = $this->createQueryBuilder('i')
            ->select('j.domain as domain', 'count(i.id) as total')
            ->innerJoin( 'i.job', 'j')
            ->where('u.age >= :ageMin')
            ->andWhere('u.age <= :ageMax')
            ->setParameter('ageMin', $ageMin)
            ->setParameter('ageMax', $ageMax)
            ->innerJoin('i.user', 'u')
            ->groupBy('j.domain')
            ->orderBy('total', 'DESC')
            ->setMaxResults(20)
            ->getQuery();

        return $qb->getResult();
    }


    // calculating occurence of each job for each job
    public function wordtojob($answer){
        $qb= $this->createQueryBuilder('i')
            ->select('j.id as jobid', 'count(i.id) as total', 'a.id as answerid')
            ->where('a.id = :aid')
            ->setParameter('aid', $answer)
            ->innerJoin('i.answer', 'a')
            ->groupBy('jobid')
            ->innerJoin('i.job', 'j')
            ->orderBy('total', 'DESC')
            ->getQuery();
        return $qb->getResult();
    }

}