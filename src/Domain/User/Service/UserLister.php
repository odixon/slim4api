<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserListerRepository;
use App\Exception\ValidationException;
use Psr\Container\ContainerInterface;

/**
 * Service.
 */
final class UserLister
{
    /**
     * @var UserListerRepository
     */
    private $repository;
    private $defaultPage;
    private $defaultPageSize;

    /**
     * The constructor.
     *
     * @param UserListerRepository $repository The repository
     */
    public function __construct(UserListerRepository $repository, ContainerInterface $ci)
    {
        $this->repository = $repository;
        $this->defaultPage = $ci->get('settings')['db']['defaultPage'];
        $this->defaultPageSize = $ci->get('settings')['db']['defaultPageSize'];
    }

    /**
     * Read user list.
     *
     * @param int page Page number
     * @param int pagesize Nb of lines
     *
     * @throws ValidationException
     *
     * @return UserList
     */
    public function getUserList(int $page, int $pagesize): array
    {
        // Validation

        if (!is_numeric($page) || $page < $this->defaultPage) {
            $page = $this->defaultPage;
        }

        if (!is_numeric($pagesize) || $pagesize < 1 || $pagesize > $this->defaultPageSize) {
            $pagesize = $this->defaultPageSize;
        }

        return $this->repository->getUsers($page, $pagesize);
    }

    /**
     * Count users.
     *
     * @return nb
     */
    public function getUserCount(): int
    {
        return $this->repository->countUsers();
    }
}