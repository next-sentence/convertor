<?php

namespace Tests\AppBundle\Adapter;

use AppBundle\Adapter\SQLAdapter;
use AppBundle\Term\TermBuilder;
use PHPUnit\Framework\TestCase;

class SQLAdapterTest extends TestCase
{

    public function testFindEqual()
    {
        $adapter = new SQLAdapter(new TermBuilder());

        $eq = $adapter->find(['test' => 'value']);

        $this->assertContains('SELECT * FROM my_table WHERE (test = value)', $eq);
    }

    public function testFindGt()
    {
        $adapter = new SQLAdapter(new TermBuilder());

        $gt = $adapter->find(["grades_score" => ['gt' => 30]]);

        $this->assertContains('SELECT * FROM my_table WHERE (grades_score > 30)', $gt);
    }

    public function testFindLt()
    {
        $adapter = new SQLAdapter(new TermBuilder());

        $gt = $adapter->find(["grades_score" => ['lt' => 10]]);

        $this->assertContains('SELECT * FROM my_table WHERE (grades_score < 10)', $gt);
    }


    public function testFindOr()
    {
        $adapter = new SQLAdapter(new TermBuilder());

        $or = $adapter->find(["or" => ["cuisine" => "Italian", "zipcode" => "10075"]]);

        $this->assertContains('SELECT * FROM my_table WHERE ((cuisine = Italian) OR (zipcode = 10075))', $or);
    }

    public function testFindAnd()
    {
        $adapter = new SQLAdapter(new TermBuilder());

        $and = $adapter->find(["cuisine" => "Italian", "zipcode" => "10075"]);

        $this->assertContains('SELECT * FROM my_table WHERE (cuisine = Italian) AND (zipcode = 10075)', $and);
    }

    public function testFindAndOr()
    {
        $adapter = new SQLAdapter(new TermBuilder());

        $and = $adapter->find(["cuisine" => "Italian", "or" => ["cuisine" => "asd", "zipcode" => "1213"]]);

        $this->assertContains('SELECT * FROM my_table WHERE (cuisine = Italian) AND ((cuisine = asd) OR (zipcode = 1213))', $and);
    }


    public function testFindOrAnd()
    {
        $adapter = new SQLAdapter(new TermBuilder());

        $and = $adapter->find(["or" => [["cuisine" => "Italian", "zipcode" => "10075"], ["cuisine" => "Spaniol", "zipcode" => "12443"]]]);

        $this->assertContains('SELECT * FROM my_table WHERE (((cuisine = Italian) AND (zipcode = 10075)) OR ((cuisine = Spaniol) AND (zipcode = 12443)))', $and);
    }
}