<?php

namespace Digitick\Tests\Foundation\Collection;

use Digitick\Foundation\Collection\BaseList;

class BaseListTest extends \PHPUnit_Framework_TestCase
{
    const INITIAL_SIZE = 5;
    /** @var  BaseList */
    protected $emptyList;
    /** @var  BaseList */
    protected $zeroList;
    /** @var  BaseList */
    protected $list;

    protected function setUp()
    {
        $this->list = $this->generateList(self::INITIAL_SIZE);
        $this->emptyList = new BaseList(self::INITIAL_SIZE);
        $this->zeroList = new BaseList();
    }

    protected function generateList($size)
    {
        $list = new BaseList($size);

        for ($i = 0; $i < $size; $i++) {
            $list->set($i, $i + 1);
        }

        return $list;
    }

    // Size tests

    public function testInitialSize () {
        $this->assertEquals(self::INITIAL_SIZE, $this->emptyList->count());
        $this->assertEquals(0, $this->zeroList->count());
    }

    public function testSizeAfterAdd() {
        $this->emptyList->add(2, "tonton");
        $this->assertEquals(self::INITIAL_SIZE, $this->emptyList->count());
    }

    // Empty tests

    public function testEmpty()
    {
        $this->assertTrue($this->emptyList->isEmpty());
        $this->assertFalse($this->list->isEmpty());
    }


    public function testListMustNotBeEmptyAfterAdd()
    {
        $this->emptyList->add(1, 10);
        $this->assertFalse($this->emptyList->isEmpty());
    }

    public function testListMustBeEmptyAfterClear()
    {
        $this->assertFalse($this->list->isEmpty());
        $this->list->clear();
        $this->assertTrue($this->list->isEmpty());
    }

    // Tests add

    public function testAdd () {
        $this->emptyList->add(1, "tonton");
        $this->assertTrue($this->emptyList->contains("tonton"));
        $this->assertEquals(1, $this->emptyList->indexOf("tonton"));
        $this->assertEquals("tonton", $this->emptyList->get(1));
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testSetOutOfBound () {
        $this->list->set(self::INITIAL_SIZE, "tonton");
    }

    /**
     * @expectedException  \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testSetOutOfBoundNegative () {
        $this->list->set(-1, "tonton");
    }

    public function testSetArrayMode () {
        $this->emptyList [2] = "tonton";
        $this->assertEquals("tonton", $this->emptyList [2]);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testSetArrayModeOutboundNegative () {
        $this->emptyList [-1] = "tonton";
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testSetArrayModeOutbound () {
        $this->emptyList [self::INITIAL_SIZE] = "tonton";
    }

    public function testAddAll()
    {
        $this->emptyList->addAll($this->list);
        $this->assertTrue($this->emptyList->containsAll($this->list));
        $this->list->setSize(6);
        $this->list->add(5, 6);
        $this->assertFalse($this->emptyList->containsAll($this->list));
    }

    public function testAddAllEmpty ()
    {
        $this->list->addAll($this->emptyList);
        $this->assertTrue($this->list->containsAll($this->emptyList));
        $this->assertTrue($this->list->containsAll($this->list));
    }

    public function testAddAllWithEmpty () {
        $this->list->addAll($this->emptyList);
    }

    // Tests remove
    public function testRemove ()
    {
        $this->list->remove(1);
        $this->assertEquals(null, $this->list->get(1));
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testRemoveOutOfBound () {
        $this->list->remove(self::INITIAL_SIZE + 1);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testRemoveOutOfBoundWithNegative () {
        $this->list->remove(-1);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\NotImplementedException
     */
    public function testRemoveAll()
    {
        $this->emptyList->removeAll($this->list);
    }

    // Test get

    public function testGet ()
    {
        $this->emptyList->set (1, "tonton");
        $this->assertEquals("tonton", $this->emptyList->get(1));
        $this->emptyList->set (2, 123);
        $this->assertEquals(123, $this->emptyList->get(2));
    }

    public function testGetArrayMode ()
    {
        $this->emptyList->set (1, "tonton");
        $this->assertEquals("tonton", $this->emptyList [1]);
        $this->emptyList->set (2, 123);
        $this->assertEquals(123, $this->emptyList [2]);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testGetOutOfBound() {
        $this->emptyList->get($this->emptyList->count() + 1);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testGetOutOfBoundArrayMode () {
        $this->emptyList [$this->emptyList->count() + 1];
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testGetOutOfBoundNegative() {
        $this->emptyList->get(-1);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testGetOutOfBoundNegativeArrayMode () {
        $this->emptyList [-1];
    }

    // Test Sublist

    public function testSubList () {
        $subList = $this->list->subList(1, 3);
        $this->assertInstanceOf(get_class($this->list), $subList);
        $this->assertTrue($this->list->containsAll($subList));
        $this->assertEquals(2, $subList [0]);
        $this->assertEquals(3, $subList [1]);
        $this->assertEquals(4, $subList [2]);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\InvalidArgumentException
     */
    public function testSubListInvalid () {
        $subList = $this->list->subList(2, 1);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testSubListOverlapUp () {
        $subList = $this->list->subList(2, self::INITIAL_SIZE + 1);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\OutOfBoundException
     */
    public function testSubListOverlapDown () {
        $subList = $this->list->subList(-1, 1);
    }

    // Test contains

    public function testContains()
    {
        $this->assertFalse($this->list->contains(0));
        $this->assertTrue($this->list->contains(2));
        $this->assertFalse($this->list->contains(6));
        $this->assertFalse($this->list->contains("text"));
        $this->assertFalse($this->list->contains((boolean)true));
        $this->assertFalse($this->list->contains(-1));
    }

    public function testContainsAll()
    {
        $this->assertTrue($this->list->containsAll($this->emptyList));
        $this->assertTrue($this->list->containsAll($this->list));
        $this->assertTrue($this->emptyList->containsAll($this->emptyList));
    }

}