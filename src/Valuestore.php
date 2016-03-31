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
        return (new static())->setFileName($fileName);
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

    /**
     * @param string|array $name
     * @param string|null $value
     */
    public function put($name, string $value = null)
    {
        $newValues = $name;

        if (! is_array($name)) {
            $newValues = [$name => $value];
        }

        $currentContent = array_merge($this->all(), $newValues);

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

    /**
     * @return $this
     */
    public function clear()
    {
        $this->setContent([]);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function all(string $name = null) : array
    {
        if (!file_exists($this->fileName)) {
            return [];
        }

        $values = json_decode(file_get_contents($this->fileName), true);

        if (!is_null($name)) {
            return $this->filteredValues($values, $name);
        }

        return $values;
    }

    protected function filteredValues($values, $name)
    {
        $filteredValues = [];

        foreach ($values as $key => $value) {
            if (strpos($key, $name) !== false) {
                $filteredValues[$key] = $value;
            }
        }

        return $filteredValues;
    }

    protected function setContent(array $values)
    {
        file_put_contents($this->fileName, json_encode($values));
    }
}
