<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use Blog\Model\Author;
use Blog\Model\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * This custom Doctrine repository contains some methods which are useful when
 * querying for blog post information.
 *
 * See https://symfony.com/doc/current/book/doctrine.html#custom-repository-classes
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class PostRepository extends EntityRepository implements \Blog\Repository\PostRepository
{
    /**
     * @param int $page
     *
     * @return Pagerfanta
     */
    public function findLatest($page = 1)
    {
        $query = $this->getEntityManager()
            ->createQuery(sprintf('
                SELECT p, a, t
                FROM %s p
                JOIN p.author a
                LEFT JOIN p.tags t
                WHERE p.publishedAt <= :now
                ORDER BY p.publishedAt DESC
            ', Post::class))
            ->setParameter('now', new \DateTime())
        ;

        return $this->createPaginator($query, $page);
    }

    /**
     * @param int $id
     *
     * @return Post|null
     */
    public function findById(int $id)
    {
        return parent::find($id);
    }

    /**
     * @param string $slug
     *
     * @return Post|null
     */
    public function findOneBySlug(string $slug)
    {
        return parent::findOneBy(['slug' => $slug]);
    }

    /**
     * @param Author $author
     *
     * @return array
     */
    public function findByAuthor(Author $author)
    {
        return parent::findBy(['author' => $author], ['publishedAt' => 'DESC']);
    }

    /**
     * @param Post $post
     */
    public function save(Post $post)
    {
        $this->_em->persist($post);
        $this->_em->flush($post);
    }

    /**
     * @param Post $post
     */
    public function remove(Post $post)
    {
        $this->_em->remove($post);
        $this->_em->flush($post);
    }

    private function createPaginator(Query $query, $page)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(Post::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
