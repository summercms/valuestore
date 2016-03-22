<?php

namespace Spatie\Valuestore\Test;

use Spatie\Valuestore\Valuestore;

class ValuestoreTest extends \PHPUnit_Framework_TestCase
{
    protected $file;
    protected $valuestore;

    public function setUp()
    {
        parent::setUp();

        $this->file = $this->getTempDirectory().'test';
        $this->valuestore = new Valuestore();
        $this->valuestore->make($this->file);
    }

    /** @test */
    public function it_can_store_some_data_in_json_format_in_the_file()
    {
        $this->valuestore->put('test', 'TEST');
        $content = file_get_contents($this->file);

        $this->assertJson($content);
    }

    /** @test */
    public function it_can_add_lines_of_data_to_the_existing_file_without_overwriting_the_data_in_the_file()
    {
        $content = file_get_contents($this->file);
        $this->valuestore->put('additional data', 'adding more data');
        $newContent = file_get_contents($this->file);

        $this->assertNotEquals($newContent, $content);
    }

    /** @test */
    public function it_can_get_data()
    {
        $content = $this->valuestore->get('test');

        $this->assertNotEmpty($content);

        $this->assertEquals('TEST', $content);
    }

    /** @test */
    public function it_can_clear_data()
    {
        $content = file_get_contents($this->file);
        $this->valuestore->clear();
        $newContent = file_get_contents($this->file);

        $this->assertNotContains($content, $newContent);
    }

    /**
     * @return string
     */
    protected function getTempDirectory() : string
    {
        return __DIR__.'/temp/';
    }
}
