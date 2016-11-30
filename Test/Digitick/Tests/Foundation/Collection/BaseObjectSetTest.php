<?php

namespace Digitick\Tests\Foundation\Collection;

use Digitick\Foundation\Collection\BaseObjectSet;

class BaseScalarSetTest extends \PHPUnit_Framework_TestCase
{
    protected $set;
    protected $emptySet;

    public function testListMustNotBeEmptyAfterAdd()
    {
        $newObject = (object) ['foo' => 'bar3'];
        $this->emptySet->add($newObject);
        $this->assertFalse($this->emptySet->isEmpty());
    }

    public function testAddAll()
    {
        $this->emptySet->addAll($this->set);
        $this->assertTrue($this->emptySet->containsAll($this->set));
        $newObject = (object) ['foo' => 'bar3'];
        $this->set->add($newObject);
        $this->assertFalse($this->emptySet->containsAll($this->set));
    }

    public function testEmpty()
    {
        $this->assertTrue($this->emptySet->isEmpty());
        $this->assertFalse($this->set->isEmpty());
    }

    public function testContains()
    {
        list($object1, $object2) = $this->generateObjects();
        $newObject = (object) ['foo' => 'bar3'];
        $this->set->add($newObject);
        $this->assertFalse($this->set->contains($object1));
        $this->assertFalse($this->set->contains($object2));
        $this->assertTrue($this->set->contains($newObject));
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
        $size = 2;
        $list = new BaseObjectSet();
        list($object1, $object2) = $this->generateObjects();
        $list->add($object1);
        $list->add($object2);
        $this->assertEquals($size, $list->size());
    }

    protected function setUp()
    {
        $this->set = $this->generateList();
        $this->emptySet = new BaseObjectSet();
    }

    protected function generateList()
    {
        $list = new BaseObjectSet();
        list($object1, $object2) = $this->generateObjects();
        $list->add($object1);
        $list->add($object2);
        return $list;
    }

    protected function generateObjects()
    {
        $object1 = (object) ['foo' => 'bar'];
        $object2 = (object) ['foo' => 'bar2'];

        return [$object1, $object2];
    }
}