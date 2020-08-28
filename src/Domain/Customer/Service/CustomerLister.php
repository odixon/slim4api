<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerListerRepository;
use App\Exception\ValidationException;
use Psr\Container\ContainerInterface;

/**
 * Service.
 */
final class CustomerLister
{
    /**
     * @var CustomerListerRepository
     */
    private $repository;
    private $defaultPage;
    private $defaultPageSize;

    /**
     * The constructor.
     *
     * @param CustomerListerRepository $repository The repository
     */
    public function __construct(CustomerListerRepository $repository, ContainerInterface $ci)
    {
        $this->repository = $repository;
        $this->defaultPage = $ci->get('settings')['db']['defaultPage'];
        $this->defaultPageSize = $ci->get('settings')['db']['defaultPageSize'];
    }

    /**
     * Read Customer list.
     *
     * @param int page Page number
     * @param int pagesize Nb of lines
     *
     * @throws ValidationException
     *
     * @return CustomerList
     */
    public function getCustomerList(int $page, int $pagesize): array
    {
        // Validation

        if (!is_numeric($page) || $page < $this->defaultPage) {
            $page = $this->defaultPage;
        }

        if (!is_numeric($pagesize) || $pagesize < 1 || $pagesize > $this->defaultPageSize) {
            $pagesize = $this->defaultPageSize;
        }

        return $this->repository->getCustomers($page, $pagesize);
    }

    /**
     * Count customers.
     *
     * @return nb
     */
    public function getCustomerCount(): int
    {
        return $this->repository->countCustomers();
    }
}