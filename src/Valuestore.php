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
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @param string $fileName
     *
     * @return $this
     */
    public function make(string $fileName)
    {
        return $this->setFileName($fileName);
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function put(string $name, string $value)
    {
        $currentContent = $this->currentContent();

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
        if (!array_key_exists($name, $this->currentContent())) {
            return;
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
    public function currentContent() : array
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
