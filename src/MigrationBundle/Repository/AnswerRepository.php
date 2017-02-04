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

}