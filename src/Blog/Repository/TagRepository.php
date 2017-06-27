<?php

namespace Blog\Repository;

interface TagRepository
{
    /**
     * @return array
     */
    public function findAll();

    /**
     * @param array $names
     *
     * @return array
     */
    public function findByNames(array $names);
}