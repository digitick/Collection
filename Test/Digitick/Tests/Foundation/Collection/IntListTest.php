<?php

namespace Digitick\Tests\Foundation\Collection;

use Digitick\Foundation\Collection\IntList;

class IntListTest extends \PHPUnit_Framework_TestCase
{

    protected function generateList($size)
    {
        $list = new IntList($size);

        for ($i=0;$i<$size;$i++)
        {
            $list->set($i, $i+1);
        }

        return $list;
    }

    public function emptyData () {
        $coll = $this->generateList(5);
        return array (
                      [new IntList(5), true],
                      [$coll, false]

                      );
    }

    /**
    * @dataProvider emptyData
    */
    public function testEmpty ($coll, $result)
    {
        $this->assertEquals($coll->isEmpty(), $result);
    }



    public function containsData () {
        $list = $this->generateList(5);
        return array (
                      [$list, 0, false],
                      [$list, 2, true],
                      [$list, 6, false],
                      [$list, "text", false],
                      [$list, true, false],
                      );
    }

    /**
    * @dataProvider containsData
    */
    public function testContains($list, $searched_element, $result)
    {
        $this->assertEquals($list->contains($searched_element), $result);

    }

}