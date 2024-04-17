<?php

namespace Ifedko\DoctrineDbalPagination;

use Doctrine\DBAL\Query\QueryBuilder;
use Ifedko\DoctrineDbalPagination\Filter\FilterInterface;

interface ListPaginatorBuilderConfiguratorInterface
{

    /**
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */
    public function getBaseQuery(QueryBuilder $queryBuilder);

    /**
     * @return FilterInterface[]
     */
    public function getAvailableFilterByParameter();

    /**
     * @return SortingInterface[]
     */
    public function getAvailableSorting();
}
