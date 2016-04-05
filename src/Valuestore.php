<?php

namespace Spatie\Valuestore;

class Valuestore
{
    /** @var string */
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
     * Set the filename where all values will be stored.
     *
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
     * Put a value in the store.
     *
     * @param string|array    $name
     * @param string|int|null $value
     *
     * @return $this
     */
    public function put($name, $value = null)
    {
        $newValues = $name;

        if (!is_array($name)) {
            $newValues = [$name => $value];
        }

        $newContent = array_merge($this->all(), $newValues);

        $this->setContent($newContent);

        return $this;
    }

    /**
     * Get a value from the store.
     *
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
     * Get all values from the store.
     *
     * @param string $startingWith
     *
     * @return array
     */
    public function all(string $startingWith = '') : array
    {
        if (!file_exists($this->fileName)) {
            return [];
        }

        $values = json_decode(file_get_contents($this->fileName), true);

        if ($startingWith !== '') {
            return $this->filterKeysStartingWith($this->all(), $startingWith);
        }

        return $values;
    }

    /**
     * Forget a value from the store.
     *
     * @param string $key
     *
     * @return $this
     */
    public function forget(string $key)
    {
        $newContent = $this->all();

        unset($newContent[$key]);

        $this->setContent($newContent);

        return $this;
    }

    /**
     * Flush all values from the store.
     *
     * @param string $startingWith
     *
     * @return $this
     */
    public function flush(string $startingWith = '')
    {
        $newContent = [];

        if ($startingWith !== '') {
            $newContent = $this->filterKeysNotStartingWith($this->all(), $startingWith);
        }

        return $this->setContent($newContent);
    }

    /**
     * Get and forget a value from the store.
     *
     * @param string $name
     *
     * @return null|string
     */
    public function pull(string $name)
    {
        $value = $this->get($name);

        $this->forget($name);

        return $value;
    }

    /**
     * Increment a value from the store.
     *
     * @param string $name
     * @param int    $by
     *
     * @return int|null|string
     */
    public function increment(string $name, int $by = 1)
    {
        $currentValue = $this->get($name) ?? 0;

        $newValue = $currentValue + $by;

        $this->put($name, $newValue);

        return $newValue;
    }

    /**
     * Decrement a value from the store.
     *
     * @param string $name
     * @param int    $by
     *
     * @return int|null|string
     */
    public function decrement(string $name, int $by = 1)
    {
        return $this->increment($name, $by * -1);
    }

    protected function filterKeysStartingWith(array $values, string $startsWith) : array
    {
        return array_filter($values, function ($key) use ($startsWith) {

            return $this->startsWith($key, $startsWith);

        }, ARRAY_FILTER_USE_KEY);
    }

    protected function filterKeysNotStartingWith(array $values, string $startsWith) : array
    {
        return array_filter($values, function ($key) use ($startsWith) {

            return !$this->startsWith($key, $startsWith);

        }, ARRAY_FILTER_USE_KEY);
    }

    protected function startsWith(string $haystack, string $needle) : bool
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    protected function setContent(array $values)
    {
        file_put_contents($this->fileName, json_encode($values));

        return $this;
    }
}
