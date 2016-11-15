<?php

namespace FlyingLuscas\Correios;

use Illuminate\Support\Collection;

class Cart
{
    /**
     * Collection of items.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * Default items values.
     *
     * @var array
     */
    protected $default = [
        'width' => 0,
        'height' => 0,
        'length' => 0,
        'weight' => 0,
        'quantity' => 1,
    ];

    /**
     * Creates a new Cart instance.
     */
    public function __construct()
    {
        $this->items = new Collection;
    }

    /**
     * Get the most bigger length in the cart.
     *
     * @return int|float
     */
    public function getMaxLength()
    {
        return $this->items->max('length');
    }

    /**
     * Get the total height of all items in the cart.
     *
     * @return int|float
     */
    public function getTotalHeight()
    {
        return $this->items->sum(function ($item) {
            return $item['height'] * $item['quantity'];
        });
    }

    /**
     * Get the most bigger width in the cart
     *
     * @return int|float
     */
    public function getMaxWidth()
    {
        return $this->items->max('width');
    }

    /**
     * Fill cart with items.
     *
     * @param  array  $items
     *
     * @return self
     */
    public function fill(array $items)
    {
        foreach ($items as $item) {
            $this->push($item);
        }

        return $this;
    }

    /**
     * Add a single item to the end of the cart.
     *
     * @param  array  $item
     *
     * @return self
     */
    public function push(array $item)
    {
        $item = array_filter($item, function ($key) {
            return in_array($key, array_keys($this->default));
        }, ARRAY_FILTER_USE_KEY);

        $this->items->push(array_merge($this->default, $item));

        return $this;
    }

    /**
     * Get all items in the cart as an array.
     *
     * @return array
     */
    public function all()
    {
        return $this->items->all();
    }
}
