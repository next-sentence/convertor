<?php

namespace AppBundle\Adapter;

use AppBundle\Term\TermBuilder;

class SQLAdapter
{
    /**
     * @var TermBuilder
     */
    protected $termBuilder;

    /**
     * SQLAdapter constructor.
     * @param TermBuilder $termBuilder
     */
    public function __construct(TermBuilder $termBuilder)
    {
        $this->termBuilder = $termBuilder;
    }

    /**
     * @param array $criteria
     * @return string
     */
    public function find(array $criteria): string
    {
        $query = 'SELECT * FROM my_table WHERE ' .  $this->termBuilder->buildTerms($criteria);

        return $query;
    }

}