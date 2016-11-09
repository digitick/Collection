<?php

namespace Digitick\Tests\Foundation\Collection;

use Digitick\Foundation\Collection\BaseList;

class BaseListTest extends \PHPUnit_Framework_TestCase
{
    protected $list;
    protected $emptyList;

    protected function setUp()
    {
      $this->list = $this->generateList(5);
      $this->emptyList = new BaseList(5);
    }

    protected function generateList($size)
    {
        $list = new BaseList($size);

        for ($i=0;$i<$size;$i++)
        {
            $list->set($i, $i+1);
        }

        return $list;
    }

/*
    public function contains($element);

    public function containsAll(InterfaceCollection $elementCollection);

    public function removeAll(InterfaceCollection $elementCollection);

    public function toArray();

    public function add($offset, $element);
    public function remove($offset);

    public function get($offset);
    public function set($offset, $element);

    public function indexOf($element);
    public function subList($fromIndex, $toIndex);

    public static function fromArray($array, $saves_indexes=true);


*/

    public function testListMustNotBeEmptyAfterAdd()
    {
        $this->emptyList->add(1,10);
        $this->assertFalse($this->emptyList->isEmpty());
    }


    public function testAddAll()
    {
        $this->emptyList->addAll($this->list);
        $this->assertTrue($this->emptyList->containsAll($this->list));
        $this->list->setSize(6);
        $this->list->add(5,6);
        $this->assertFalse($this->emptyList->containsAll($this->list));
    }

    public function testEmpty ()
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
        $this->assertFalse($this->list->contains((boolean) true));
        $this->assertFalse($this->list->contains(-1));
    }


    public function testContainsAll()
    {

    }

    public function testListMustBeEmptyAfterClear()
    {
        $this->assertFalse($this->list->isEmpty());
        $this->list->clear();
        $this->assertTrue($this->list->isEmpty());

    }


    public function testSize()
    {
        $size = 5;
        $list = new BaseList($size);
        $this->assertEquals($size, $list->size());
    }
}