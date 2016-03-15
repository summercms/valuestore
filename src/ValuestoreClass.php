<?php

namespace Spatie\Valuestore;

use Illuminate\Contracts\Filesystem;

class ValuestoreClass
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $fileName;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $fileName
     * @return $this
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @param string$fileName
     * @return $this
     */
    public static function create($fileName)
    {
        return app(static::class)->setFileName($fileName);
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function put($name, $value)
    {
        $currentContent = $this->currentContent();

        $currentContent[$name] = $value;

        $this->setContent($currentContent);
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function get($name)
    {
        if (! array_key_exists($name, $this->currentContent())) {
            return null;
        }

        return $this->currentContent()[$name];
    }

    public function clear()
    {
        $this->setContent([]);

        return $this;
    }

    /**
     * @return array
     */
    public function currentContent()
    {
        if (! file_exists($this->fileName)) {
            return [];
        }

        return json_decode(file_get_contents($this->fileName), true);
    }

    protected function setContent(array $values)
    {
        $this->filesystem->put($this->fileName, json_encode($values));
    }
}
