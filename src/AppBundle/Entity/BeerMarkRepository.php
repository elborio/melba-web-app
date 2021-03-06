<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 11/14/2016
 * Time: 5:40 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\DateTime;

class BeerMarkRepository extends EntityRepository
{

    /**
     * @param $user User
     * @return int
     */
    public function getBeerCountForUser($user)
    {
        return $this->createQueryBuilder('s')
            ->select("COUNT(s.id)")
            ->where("s.user = :user")
            ->andWhere("s.group = :group")
            ->setParameter("user", $user)
            ->setParameter("group", $user->getCurrentGroup())
            ->getQuery()->getSingleScalarResult();
    }

    public function getBeerCountForGroup($group)
    {
        return $this->createQueryBuilder('s')
            ->select("COUNT(s.id)")
            ->where("s.group = :group")
            ->setParameter("group", $group)
            ->getQuery()->getSingleScalarResult();
    }

    public function getBeerCountForGroupLastWeek($group)
    {
        $dateTime = new \DateTime("-1 week");

        return $this->createQueryBuilder('s')
            ->select("COUNT(s.id)")
            ->where("s.group = :group")
            ->setParameter("group", $group)
            ->andWhere("s.dateAdded > :date")
            ->setParameter("date", $dateTime)
            ->getQuery()->getSingleScalarResult();
    }
}