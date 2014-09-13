<?php

namespace Ben\UserBundle\Stats;

use Doctrine\ORM\EntityManager;
use Ben\UserBundle\Stats\StatsQuery;

class StatsHandler
{
    private $em;

    private $table;
    private $timeColumn;
    private $dataColumn;
    private $dateRange;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function processData() {
        $qb = new StatsQuery($this->dateRange);
        $query = $qb->get($this->dataColumn);
        return $this->fetch($query);
    }

    /* setters */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }
    public function setTimeColumn($timeColumn)
    {
        $this->timeColumn = $timeColumn;
        return $this;
    }
    public function setDataColumn($dataColumn)
    {
        $this->dataColumn = $dataColumn;
        return $this;
    }
    public function setDateRange($dateRange)
    {
        $this->dateRange = $dateRange;
        return $this;
    }
    
    private function fetch($query)
    {
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        return  $stmt->fetchAll();
    }
}