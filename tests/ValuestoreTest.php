<?php

namespace Spatie\Valuestore\Test;

use Spatie\Valuestore\Valuestore;

class ValuestoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Valuestore
     */
    protected $valuestore;

    public function setUp()
    {
        parent::setUp();

        $storageFile = __DIR__.'/temp/storage.json';

        if (file_exists($storageFile)) {
            unlink($storageFile);
        }

        $this->valuestore = Valuestore::make($storageFile);
    }

    /** @test */
    public function it_can_store_a_key_value_pair()
    {
        $this->valuestore->put('key', 'value');

        $this->assertSame('value', $this->valuestore->get('key'));
    }

    /** @test */
    public function it_will_return_null_for_a_non_existing_value()
    {
        $this->assertNull($this->valuestore->get('non existing key'));
    }

    /** @test */
    public function it_can_overwrite_a_value()
    {
        $this->valuestore->put('key', 'value');

        $this->valuestore->put('key', 'otherValue');

        $this->assertSame('otherValue', $this->valuestore->get('key'));
    }

    /** @test */
    public function it_can_fetch_all_values_at_once()
    {
        $this->valuestore->put('key', 'value');

        $this->valuestore->put('otherKey', 'otherValue');

        $this->assertSame([
            'key' => 'value',
            'otherKey' => 'otherValue',
        ], $this->valuestore->all());
    }

    /** @test */
    public function it_can_store_multiple_value_pairs_in_one_go()
    {
        $values = [
            'key' => 'value',
            'otherKey' => 'otherValue',
        ];

        $this->valuestore->put($values);

        $this->assertSame('value', $this->valuestore->get('key'));

        $this->assertSame($values, $this->valuestore->all());
    }

    /** @test */
    public function it_can_clear_all_values()
    {
        $this->valuestore->put('key', 'value');

        $this->valuestore->put('otherKey', 'otherValue');

        $this->valuestore->clear();

        $this->assertNull($this->valuestore->get('key'));

        $this->assertNull($this->valuestore->get('otherKey'));
    }

    /** @test */
    public function it_can_fetch_all_values_starting_with_a_certain_value()
    {
        $this->valuestore->put([
            'group1Key1' => 'valueGroup1Key1',
            'group1Key2' => 'valueGroup1Key2',
            'group2Key1' => 'valueGroup2Key1',
            'group2Key2' => 'valueGroup2Key2',
        ]);

        $expectedArray = [
            'group1Key1' => 'valueGroup1Key1',
            'group1Key2' => 'valueGroup1Key2',
        ];

        $this->assertSame($expectedArray, $this->valuestore->all('group1'));
    }

    /** @test */
    public function it_will_return_an_empty_array_when_getting_all_content()
    {
        $this->assertSame([], $this->valuestore->all());
    }
}
