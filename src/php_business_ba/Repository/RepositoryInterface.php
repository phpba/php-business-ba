<?php
declare(strict_types=1);

namespace PhpBa\PhpBusinessBa\Repository;

/**
 * Interface that defines the return of the rules of API data
 *
 * Interface RepositoryInterface
 * @package PhpBa\PhpBusinessBa\Repository
 * @author edyonil <edyonil@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * Method that returns the API data
     *
     * @return array
     */
    public function getData() : array;
}
