<?php

namespace App\Repository;

use App\Entity\BlogPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BlogPost>
 *
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    public function add(BlogPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BlogPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getPaginatedBlogPost($page, $limit, $filters = null) {
        $query = $this->createQueryBuilder('b');

        if ($filters !== null) {
            $query->where('b.category IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }

        $query->orderBy('b.createdAt')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
            ;
        return $query->getQuery()->getResult();
    }


    public function getTotalBlogPost($filters = null) {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)');

        if ($filters !== null) {
            $query->where('b.category IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }
        return $query->getQuery()->getSingleScalarResult();
    }

}
