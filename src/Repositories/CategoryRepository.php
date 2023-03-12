<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository{
    
    public function findAllPaginated(int $page, int $limit = 5): array
    {
        $query = $this->createQueryBuilder('c');

        $query->setMaxResults($limit)->setFirstResult($limit * ($page - 1));

        return $query->getQuery()->getResult();
    }
    
}