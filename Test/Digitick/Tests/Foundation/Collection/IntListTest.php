<?php

namespace Digitick\Tests\Foundation\Collection;

use Digitick\Foundation\Collection\IntList;

class IntListTest extends \PHPUnit_Framework_TestCase
{
    /** @var  IntList */
    protected $emptyList;
    /** @var  IntList */
    protected $list;

    // Add
    public function testAddInt() {
        $this->emptyList->add(1, 10);
        $this->assertEquals(10, $this->emptyList->get(1));
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\UnexpectedTypeException
     */
    public function testAddNonInt () {
        $list = new IntList (10);
        $list->add(1, "String");
    }

    public function testSetInt () {
        $this->emptyList->set(1, 10);
        $this->assertEquals(10, $this->emptyList->get(1));
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\UnexpectedTypeException
     */
    public function testSetNonInt () {
        $this->emptyList->set(1, "String");
    }

    public function testSetIntArrayMode () {
        $this->emptyList [1] = 10;
        $this->assertEquals(10, $this->emptyList [1]);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\UnexpectedTypeException
     */
    public function testSetNonIntArrayMode () {
        $this->emptyList [1] = "String";
    }

    public function testIndexOf () {
        $this->emptyList [2] = 3;
        $this->emptyList [1] = 4;

        $this->assertEquals(2, $this->emptyList->indexOf(3));
        $this->assertEquals(1, $this->emptyList->indexOf(4));
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\UnexpectedTypeException
     */
    public function testIndexOfNonInt () {
        $this->emptyList->indexOf("String");
    }

    public function testFromArraySaveIndexes () {
        $array = [
            1 => 5,
            2 => 4,
            3 => 3,
            4 => 2,
            5 => 1
        ];

        $list = IntList::fromArray($array, true);

        $this->assertEquals(6, $list->count());
        foreach ($array as $key => $val) {
            $this->assertEquals($val, $list [$key]);
        }
    }

    public function testFromArrayDontSaveIndexes () {
        $array = [
            1 => 5,
            2 => 4,
            3 => 3,
            4 => 2,
            5 => 1
        ];

        $list = IntList::fromArray($array, false);

        $this->assertEquals(5, $list->count());

        foreach ($array as $key => $val) {
            $this->assertEquals($val, $list [$key-1]);
        }
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