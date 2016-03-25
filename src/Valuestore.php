<?php

namespace Spatie\Valuestore;

class Valuestore
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @param string $fileName
     *
     * @return $this
     */
    public static function make(string $fileName)
    {
        return (new static)->setFileName($fileName);
    }

    protected function __construct()
    {

    }

    /**
     * @param string $fileName
     *
     * @return $this
     */
    protected function setFileName(string $fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }


    public function put(string $name, string $value)
    {
        $currentContent = $this->all();

        $currentContent[$name] = $value;

        $this->setContent($currentContent);
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    public function get(string $name)
    {
        if (!array_key_exists($name, $this->all())) {
            return;
        }

        return $this->all()[$name];
    }

    public function clear()
    {
        $this->setContent([]);

        return $this;
    }

    /**
     * @return array
     */
    public function all() : array
    {
        if (!file_exists($this->fileName)) {
            return [];
        }

        return json_decode(file_get_contents($this->fileName), true);
    }

    protected function setContent(array $values)
    {
        file_put_contents($this->fileName, json_encode($values));
    }
}
