<?php

namespace Spatie\Valuestore\Test;

use Orchestra\Testbench\TestCase;
use Spatie\Valuestore\Valuestore;

class ValuestoreTest extends TestCase
{
    protected $file;

    public function setUp()
    {
        parent::setUp();

        $this->file = $this->getTempDirectory().'test';

    }
    /** @test */
    public function it_can_store_some_data_in_json_format_in_the_file()
    {
        Valuestore::make($this->file)->put('test', 'TEST');

        $content = file_get_contents($this->file);

        $this->assertJson($content);

    }


    /** @test */
    public function it_can_add_lines_of_data_to_the_existing_file_without_overwriting_the_data_in_the_file()
    {
        $file = $this->getTempDirectory().'test2';
        $content = file_get_contents($file);
        Valuestore::make($this->file)->put('additional data', 'adding more data');
        $newContent = file_get_contents($this->file);

        $this->assertNotEquals($newContent, $content);

    }

    /** @test */
    public function it_can_get_data()
    {
        $content = Valuestore::make($this->file)->get('test');

        $this->assertNotEmpty($content);

        $this->assertEquals("TEST", $content);

    }

    /** @test */
    public function it_can_clear_data()
    {
        $content = file_get_contents($this->file);
        Valuestore::make($this->file)->clear();
        $newContent = file_get_contents($this->file);

        $this->assertNotContains($content, $newContent);
    }

    /**
     * @return string
     */
    protected function getTempDirectory()
    {
        return __DIR__.'/temp/';
    }
}
