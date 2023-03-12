<?php

namespace App\Repositories;

use App\Models\Category;
use Doctrine\ORM\EntityRepository;

class VideoRepository extends EntityRepository
{
    public function findByTitlePaginated(?string $title, int $page, int $limit = 5): array
    {

        $query = $this->createQueryBuilder('v');
            
        if($title){
            $query->where('v.title LIKE :title')
                ->setParameter('title', "%$title%");
        }

        $query->setMaxResults($limit)->setFirstResult($limit * ($page - 1));

        return $query->getQuery()->getResult();
        
    }

    public function findByCategoryPaginated(Category $category, int $page, int $limit = 5): array
    {
        $query = $this->createQueryBuilder('v')
            ->where('v.category = :category')
            ->setParameter('category', $category);

        $query->setMaxResults($limit)->setFirstResult($limit * ($page - 1));

        return $query->getQuery()->getResult();
    }

    public function getPage($page = 1)
    {
        if ($page < 1) {
            $page = 1;
        }

        return floor($page);
    }

    public function getLimit($limit = 20)
    {
        if ($limit < 1 || $limit > 20) {
            $limit = 20;
        }

        return floor($limit);
    }

    public function getOffset($page, $limit)
    {
        $offset = 0;
        if ($page != 0 && $page != 1) {
            $offset = ($page - 1) * $limit;
        }

        return $offset;
    }
}