<?php

namespace Ifedko\DoctrineDbalPagination;

use Doctrine\DBAL\Connection;

final class ListPaginationBuilder extends ListBuilder
{
    /** @var ListPaginatorBuilderConfiguratorInterface */
    private $listPaginationBuilderConfigurator;

    public function __construct(Connection $dbConnection, ListPaginatorBuilderConfiguratorInterface $listBuilder)
    {
        parent::__construct($dbConnection);
        $this->listPaginationBuilderConfigurator = $listBuilder;
    }


    protected function baseQuery()
    {
        $queryBuilder = $this->getQueryBuilder();
        return $this->listPaginationBuilderConfigurator->getBaseQuery($queryBuilder);
    }

    protected function configureFilters($parameters)
    {
        $availableFilterByParameterMap = $this->listPaginationBuilderConfigurator->getAvailableFilterByParameter();

        foreach ($availableFilterByParameterMap as $parameterName => $filter) {
            if (isset($parameters[$parameterName])) {
                $filter->bindValues($parameters[$parameterName]);
                $this->filters[] = $filter;
            }
        }

        return $this;
    }

    protected function configureSorting($parameters)
    {
        $availableSortingList = $this->listPaginationBuilderConfigurator->getAvailableSorting();

        foreach ($availableSortingList as $sorting) {
            $this->sortUsing($sorting, $parameters);
        }

        return $this;
    }
}
