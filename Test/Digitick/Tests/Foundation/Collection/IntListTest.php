<?php

namespace Digitick\Tests\Foundation\Collection;

use Digitick\Foundation\Collection\IntList;

class IntListTest extends \PHPUnit_Framework_TestCase
{
    protected $list;
    protected $emptyList;

    public function testAdd()
    {
        $this->emptyList->add(1, 10);
        $this->assertFalse($this->emptyList->isEmpty());
    }

    public function testContainsAll()
    {
        $this->assertTrue($this->list->containsAll($this->list));
    }

    public function testAddAll()
    {
        $this->emptyList->addAll($this->list);
        $this->assertTrue($this->emptyList->containsAll($this->list));
        $this->list->setSize(6);
        $this->list->add(5, 6);
        $this->assertFalse($this->emptyList->containsAll($this->list));
    }

    public function testEmpty()
    {
        $this->assertTrue($this->emptyList->isEmpty());
        $this->assertFalse($this->list->isEmpty());
    }

    public function testContains()
    {
        $this->assertFalse($this->list->contains(0));
        $this->assertTrue($this->list->contains(2));
        $this->assertFalse($this->list->contains(6));
        $this->assertFalse($this->list->contains("text"));
        $this->assertFalse($this->list->contains((boolean)true));
        $this->assertFalse($this->list->contains(-1));
    }

    protected function setUp()
    {
        $this->list = $this->generateList(5);
        $this->emptyList = new IntList(5);
    }

    protected function generateList($size)
    {
        $list = new IntList($size);

        for ($i = 0; $i < $size; $i++) {
            $list->set($i, $i + 1);
        }

        return $list;
    }

}