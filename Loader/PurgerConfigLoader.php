<?php


namespace Doctrine\Bundle\FixturesBundle\Loader;


class PurgerConfigLoader
{
    private $excludeTables = [];

    public function addExcludedTable($table)
    {
        $this->excludeTables[] = $table;
    }

    public function getExcludedTables()
    {
        return array_unique($this->excludeTables);
    }
}