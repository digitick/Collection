# Collection
Collection management classes

## Diagramme de classes

![alt tag](https://raw.githubusercontent.com/digitick/Collection/master/doc/class-diagram.png)

## Usage

### List collections

A list collection store a set of items in an ordered way. 

#### Basic list

A list that accept any type of items.

```php
$size = 4;
$list = new BaseList($size);
$list->set (0, "First item"); // Setter style
$list[1] = 123; // Array style


foreach ($list as $item) {
    echo $item;
}
```

#### Typed list

You can define a list which will only contains items of the class you want. The collection ensure type checking.

```php
<?php

require __DIR__ . "/vendor/autoload.php";

// The class you want to be in your list collection
class MyItem {
    public $value;

    /**
     * MyItem constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return MyItem
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

}

// Declare your list collection for class MyItem
class MyItemList extends \Digitick\Foundation\Collection\AbstractTypedList
{
    /**
     * @var string
     */
    protected static $CLASSORTYPENAME = "MyItem"; // Ensure that the list will only contains items of class MyItem
}

// You must give the size of your list
$myList = new MyItemList (3);

// You can access to your list like standard PHP array
$myList [0] = new MyItem(1);
$myList [1] = new MyItem(2);
$myList [2] = new MyItem(3);
// Except for this syntax : new values can not be pushed at the end of the list;
//$myList [] = new MyItem(3); // Throw exception

// You can iterate over your list with foreach syntax
/** @var MyItem $item */
foreach ($myList as $item) {
    echo "Item : " . $item->getValue() . "\n";
}
```

#### Integer list

Predefined typed list for integers.

```php
$list = new IntList($size);
$list->set (0, 123); // Setter style
$list[1] = 123; // Array style
$list[2] = "foo"; // throw exception
```

#### String List

Predefined typed list for strings.

```php
$names = new \Digitick\Foundation\Collection\StringList(2);
$names [0] = "Emilio Bradshaw";
$names [1] = "Dyler Runner";
```

### Set collection

Unlike list collection, with a set collection elements are not ordered.

```php
$lottery = new \Digitick\Foundation\Collection\IntScalarSet(10);
for ($i = 0; $i < 10; $i++) {
    $randomNumber = rand (1, 10);
    echo "Add $randomNumber\n";
    $lottery->add($randomNumber);
}

if ($lottery->contains(5)) {
    echo "Number 5 exists : WIN !";
} else {
    echo "Number 5 is elsewhere: LOOSE !";
}
```
#### Typed set

Like list collection a set can be constrains to a specific type / class.

```php
class CustomType {

}

class CustomTypeSet extends \Digitick\Foundation\Collection\AbstractTypedObjectSet
{
    /**
     * @var string
     */
    protected static $CLASSORTYPENAME = 'CustomType';
}

$customSet = new CustomTypeSet();
$customSet->add (new CustomType());
```

