<?php

namespace Blog\Repository;

use Blog\Model\Author;
use Blog\Model\Post;
use Pagerfanta\Pagerfanta;

interface PostRepository
{
    /**
     * @param int $id
     *
     * @return Post|null
     */
    public function findById(int $id);

    /**
     * @param string $slug
     *
     * @return Post|null
     */
    public function findOneBySlug(string $slug);

    /**
     * @param Author $author
     *
     * @return array
     */
    public function findByAuthor(Author $author);

    /**
     * @param int $page
     *
     * @return Pagerfanta
     */
    public function findLatest($page = 1);

    /**
     * @param Post $post
     */
    public function save(Post $post);

    /**
     * @param Post $post
     */
    public function remove(Post $post);

}