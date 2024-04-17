<?php

namespace Ifedko\DoctrineDbalPagination;

use Doctrine\DBAL\Connection;
use Ifedko\DoctrineDbalPagination\Exception\ListPaginationFactoryException;

class ListPaginationFactory
{
    /**
     * @param Connection $dbConnection
     * @param string $listBuilderFullClassName
     * @param array $listParameters
     * @return \Ifedko\DoctrineDbalPagination\ListPagination
     * @throws \Exception
     */
    public static function create(Connection $dbConnection, $listBuilderFullClassName, $listParameters = [])
    {
        if (!class_exists($listBuilderFullClassName)) {
            throw new ListPaginationFactoryException(sprintf('Unknown list builder class %s', $listBuilderFullClassName));
        }

        if (in_array(ListPaginatorBuilderConfiguratorInterface::class, class_implements($listBuilderFullClassName), true)) {
            $listBuilderInterfaceImplementation = new $listBuilderFullClassName();
            $listBuilder = new ListPaginationBuilder($dbConnection, $listBuilderInterfaceImplementation);
        } else {
            $listBuilder = new $listBuilderFullClassName($dbConnection);
        }

        $listBuilder->configure($listParameters);

        return new ListPagination($listBuilder);
    }
}
