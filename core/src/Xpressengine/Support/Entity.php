<?php
namespace Xpressengine\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;

abstract class Entity extends Fluent
{
    /**
     * The entity attribute's original state.
     *
     * @var array
     */
    protected $original = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['*'];

    /**
     * Constructor
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->syncOriginal();
    }

    /**
     * Sync the original attributes with the current.
     *
     * @return $this
     */
    public function syncOriginal()
    {
        $this->original = $this->attributes;

        return $this;
    }

    /**
     * Get the entity's original attribute values.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return array
     */
    public function getOriginal($key = null, $default = null)
    {
        return Arr::get($this->original, $key, $default);
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $val) {
            if ($this->isFillable($key)) {
                $this->attributes[$key] = $val;
            }
        }

        return $this;
    }

    /**
     * Determine if the given attribute may be mass assigned.
     *
     * @param  string  $key
     * @return bool
     */
    public function isFillable($key)
    {
        if (in_array($key, $this->fillable)) {
            return true;
        }

        if ($this->isGuarded($key)) {
            return false;
        }

        return empty($this->fillable);
    }

    /**
     * Determine if the given key is guarded.
     *
     * @param  string  $key
     * @return bool
     */
    public function isGuarded($key)
    {
        return in_array($key, $this->guarded) || $this->guarded == ['*'];
    }

    /**
     * Get the attributes that have been changed since last sync.
     *
     * @return array
     */
    public function getDirty()
    {
        return array_diff_assoc($this->getAttributes(), $this->getOriginal());
    }

    /**
     * Convert the entity instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_diff_key($this->getAttributes(), array_flip($this->hidden));
    }
}
