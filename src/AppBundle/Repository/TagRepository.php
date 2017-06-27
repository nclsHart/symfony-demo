<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository implements \Blog\Repository\TagRepository
{
    public function findByNames(array $names)
    {
        return parent::findBy(['name' => $names]);
    }
}