<?php

namespace Digitick\Tests\Foundation\Collection;

use Digitick\Foundation\Collection\BaseScalarSet;

class BaseScalarSetTest extends \PHPUnit_Framework_TestCase
{
    protected $set;
    protected $emptySet;

    public function testListMustNotBeEmptyAfterAdd()
    {
        $this->emptySet->add(10);
        $this->assertFalse($this->emptySet->isEmpty());
    }

    public function testAddAll()
    {
        $this->emptySet->addAll($this->set);
        $this->assertTrue($this->emptySet->containsAll($this->set));
        $this->set->add(6);
        $this->assertFalse($this->emptySet->containsAll($this->set));
    }

    public function testEmpty()
    {
        $this->assertTrue($this->emptySet->isEmpty());
        $this->assertFalse($this->set->isEmpty());
    }

    public function testContains()
    {
        $this->assertFalse($this->set->contains(0));
        $this->assertTrue($this->set->contains(2));
        $this->assertFalse($this->set->contains(6));
        $this->assertFalse($this->set->contains("text"));
        $this->assertFalse($this->set->contains((boolean)true));
        $this->assertFalse($this->set->contains(-1));
    }

    public function testContainsAll()
    {

    }

    public function testListMustBeEmptyAfterClear()
    {
        $this->assertFalse($this->set->isEmpty());
        $this->set->clear();
        $this->assertTrue($this->set->isEmpty());

    }

    public function testSize()
    {
        $size = 5;
        $list = new BaseScalarSet($size);
        $this->assertEquals($size, $list->size());
    }

    protected function setUp()
    {
        $this->set = $this->generateList(5);
        $this->emptySet = new BaseScalarSet(5);
    }

    protected function generateList($size)
    {
        $list = new BaseScalarSet($size);

        for ($i = 0; $i < $size; $i++) {
            $list->add($i + 1);
        }
        return $list;
    }
}