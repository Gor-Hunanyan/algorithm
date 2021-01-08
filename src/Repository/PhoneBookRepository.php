<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class PhoneBookRepository extends EntityRepository
{
    public function getPhones($offset = 0, $limit = 10)
    {
        return $this->getEntityManager()->createQuery("SELECT p FROM App\Entity\PhoneBook p")
            ->setFirstResult($offset * 10)
            ->setMaxResults($limit)
            ->getResult();
    }
}
