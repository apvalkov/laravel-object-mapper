<?php

namespace Shureban\LaravelObjectMapper\Tests\Structs;

use Carbon\Carbon;
use DateTime;
use Shureban\LaravelObjectMapper\ObjectMapper;
use Shureban\LaravelObjectMapper\Tests\Unit\Structs\CustomTypeStrictBoxClass;
use Shureban\LaravelObjectMapper\Tests\Unit\Structs\CustomTypeStrictClass;
use Shureban\LaravelObjectMapper\Tests\Unit\Structs\CustomTypeStrictCustomClass;
use Shureban\LaravelObjectMapper\Tests\Unit\Structs\CustomTypeStrictSimpleClass;
use Tests\TestCase;

class CustomTypeTest extends TestCase
{
    public function test_StrictTypes()
    {
        $simpleClass             = new CustomTypeStrictSimpleClass();
        $simpleClass->int        = 10;
        $simpleClass->float      = 10.10;
        $simpleClass->string     = "10";
        $simpleClass->bool       = true;
        $simpleClass->array      = [1, 2, 3];
        $simpleClass->object     = (object)['key' => 'value'];
        $boxClass                = new CustomTypeStrictBoxClass();
        $boxClass->dateTime      = new DateTime('2022-02-10 00:01:02');
        $boxClass->carbon        = new Carbon('2022-02-10 00:01:02');
        $boxClass->collection    = collect([1, 2, 3]);
        $customClass             = new CustomTypeStrictCustomClass();
        $customClass->key        = 'value';
        $testObject              = new CustomTypeStrictClass();
        $testObject->simpleClass = $simpleClass;
        $testObject->boxClass    = $boxClass;
        $testObject->customClass = $customClass;

        $this->assertEquals($testObject, (new ObjectMapper(new CustomTypeStrictClass()))->mapFromJson('{"simpleClass":{"int":10,"float":10.1,"string":"10","bool":true,"array":[1,2,3],"object":{"key":"value"}},"boxClass":{"dateTime":"2022-02-10 00:01:02","carbon":"2022-02-10 00:01:02","collection":[1,2,3]},"customClass":{"key":"value"}}'));
        $this->assertEquals($testObject, (new ObjectMapper(new CustomTypeStrictClass()))->mapFromArray([
            'simpleClass' => [
                'int'    => 10,
                'float'  => 10.10,
                'string' => "10",
                'bool'   => true,
                'array'  => [1, 2, 3],
                'object' => ['key' => 'value'],
            ],
            'boxClass'    => [
                'dateTime'   => '2022-02-10 00:01:02',
                'carbon'     => '2022-02-10 00:01:02',
                'collection' => [1, 2, 3],
            ],
            'customClass' => [
                'key' => 'value',
            ],
        ]));
    }

    //    public function test_PhpDocTypes()
    //    {
    //        $this->assertEquals(new DateTime('2022-01-01'), (new ObjectMapper(new CustomTypeStrictClass()))->mapFromJson('{"dateTime": "2022-01-01"}')->dateTime);
    //        $this->assertEquals(new DateTime('2022-01-01 10:20:30'), (new ObjectMapper(new CustomTypeStrictClass()))->mapFromJson('{"dateTime": "2022-01-01 10:20:30"}')->dateTime);
    //        $this->assertEquals(new DateTime('2022-01-01'), (new ObjectMapper(new CustomTypeStrictClass()))->mapFromArray(['dateTime' => '2022-01-01'])->dateTime);
    //        $this->assertEquals(new DateTime('2022-01-01 10:20:30'), (new ObjectMapper(new CustomTypeStrictClass()))->mapFromArray(['dateTime' => '2022-01-01 10:20:30'])->dateTime);
    //    }
}
