<?php

namespace Blog\Model;

interface Author
{
    public function getFullName();

    /**
     * @param string $fullName
     */
    public function setFullName($fullName);

    public function getEmail();

    /**
     * @param string $email
     */
    public function setEmail($email);
}