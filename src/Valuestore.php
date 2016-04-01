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
     * @param string $name
     *
     * @return $this
     */
    public function clear(string $name = null)
    {
        $newContent = [];

        if(!is_null($name)){
            $newContent = $this->filteredValues($this->all(), $name, false);
        }

        return $this->setContent($newContent);

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
            return $this->filteredValues($this->all(), $name, true);
        }

        return $values;
    }

    protected function filteredValues($values, $name, $returnEquals)
    {
        return array_filter($values, function($key) use ($name, $returnEquals){

            $isEqual = (substr($key, 0, strlen($name)) === $name);
            return $returnEquals ? $isEqual : !$isEqual;

        }, ARRAY_FILTER_USE_KEY);
    }

    protected function setContent(array $values)
    {
        file_put_contents($this->fileName, json_encode($values));
    }

}
