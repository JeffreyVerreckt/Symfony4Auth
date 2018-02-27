<?php

namespace App\Repository;

use App\Entity\User;

/**
 * Interface UserRepositoryInterface
 * @package App\Repository
 */
interface UserRepositoryInterface
{

    /**
     * @param int $userId
     * @return User
     */
    public function findById(int $userId): User;

    /**
     * @param string $email
     * @return User
     */
    public function findOneByEmail(string $email): User;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param User $user
     */
    public function save(User $user): void;
}
