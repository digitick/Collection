<?php

namespace Digitick\Tests\Foundation\Collection;

use Digitick\Foundation\Collection\BaseScalarSet;

/*
 *
 */

class BaseScalarSetTest extends \PHPUnit_Framework_TestCase
{
    /** @var  BaseScalarSet */
    protected $emptySet;
    /** @var  BaseScalarSet */
    protected $set;
    const SET_SIZE = 5;

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
        $this->assertEquals(0, $this->set->count());
    }

    public function testSize()
    {
        $this->assertEquals(self::SET_SIZE, $this->set->count());
    }

    public function testRemove () {
        $this->emptySet->add ("tonton");
        $this->assertTrue($this->emptySet->contains("tonton"));
        $this->assertTrue($this->emptySet->remove("tonton"));
        $this->assertFalse($this->emptySet->contains("tonton"));
    }

    public function testRemoveNonExists() {
        $this->assertFalse($this->emptySet->remove("tonton"));
    }

    public function testToArray () {
        $array = $this->set->toArray();
        foreach ($array as $item) {
            $this->assertTrue($this->set->contains($item));
        }
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\UnexpectedTypeException
     */
    public function testAddNonScalar () {
        $this->emptySet->add(new BaseScalarSet());
    }

    public function testAddNonExists () {
        $this->assertTrue($this->emptySet->add("tonton"));
    }

    public function testAddExists () {
        $this->emptySet->add("tonton");
        $this->assertFalse($this->emptySet->add("tonton"));
    }



    protected function setUp()
    {
        $this->set = $this->generateList(self::SET_SIZE);
        $this->emptySet = new BaseScalarSet(self::SET_SIZE);
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