<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 04/02/17
 * Time: 16:38
 */

namespace MigrationBundle\Repository;


class JobRepository extends \Doctrine\ORM\EntityRepository
{
    public function migration(){
        $qb= $this->createQueryBuilder('j')
            ->select('j.id, j.name, j.domain')
            ->getQuery();
        return $qb->getResult();
    }

}