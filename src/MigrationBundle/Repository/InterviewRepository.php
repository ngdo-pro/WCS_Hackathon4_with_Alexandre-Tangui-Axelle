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
    public function get20domainsbysexe($sexe) { //  function that returns the 20 most asnwered domains
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

    public function get20wordsbysexe($sexe) { //  function that returns the 20 most asnwered domains
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