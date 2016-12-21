<?php

namespace Digitick\Tests\Foundation\Collection;

use Digitick\Foundation\Collection\BaseObjectSet;

class BaseObjectSetTest extends \PHPUnit_Framework_TestCase
{
    /** @var  BaseObjectSet */
    protected $emptySet;
    /** @var  BaseObjectSet */
    protected $set;

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

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\UnexpectedTypeException
     */
    public function testAddNonObject() {
        $this->set->add(array ());
    }

    public function testAddExisting() {
        $item = (object) ['foo' => 'bar'];
        $res = $this->emptySet->add($item);
        $this->assertTrue($res);

        $res = $this->emptySet->add($item);
        $this->assertFalse($res);
    }

    public function testRemove () {
        $item = (object) ['foo' => 'bar'];
        $res = $this->emptySet->add($item);
        $this->assertTrue($this->emptySet->contains($item));

        $this->emptySet->remove($item);
        $this->assertFalse($this->emptySet->contains($item));
    }

    public function testToArray () {
        $set = new BaseObjectSet();
        $item1 = (object) ["foo" => "item1"];
        $item2 = (object) ["foo" => "item2"];
        $item3 = (object) ["foo" => "item3"];
        $set->add($item1);
        $set->add($item2);
        $set->add($item3);
        $array = $set->toArray();
        $this->assertEquals($set->count(), count($array));
        foreach ($array as $item) {
            $this->assertTrue($set->contains($item));
        }
    }

    public function testAssociatedData () {
        $item = (object) ['foo' => 'bar'];
        $data = "tonton";
        $this->emptySet->add($item);
        $this->emptySet->setData($item, $data);
        $this->assertEquals($data, $this->emptySet->getData($item));
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\UnexpectedValueException
     */
    public function testAssociatedGetDataSetNonExists () {
        $item = (object) ['foo' => 'bar'];
        $this->emptySet->getData($item);
    }

    /**
     * @expectedException \Digitick\Foundation\Collection\Exception\UnexpectedValueException
     */
    public function testAssociateSGetDataSetNonExists () {
        $item = (object) ['foo' => 'bar'];
        $this->emptySet->setData($item, "tonton");
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
        $this->assertEquals($size, $list->count());
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