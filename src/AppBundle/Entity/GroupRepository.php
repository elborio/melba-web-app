<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 11/9/2016
 * Time: 8:04 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
{
    public function getGroupsForUser(User $user) {

        return $this->createQueryBuilder('g')
            ->join('g.users', 'u')
            ->where("u.id = :userId")
            ->setParameter("userId", $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function getForId($id) {

        return $this->createQueryBuilder('g')
            ->where("g.id = :id")
            ->setParameter("id", $id)
            ->getQuery()->getSingleResult();
    }
}