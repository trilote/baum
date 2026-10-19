<?php

namespace Baum\NestedSet\Concerns;

use Baum\NestedSet\NodeObserver;

trait HasEvents
{
    /**
     * Boot the HasEvents trait for a model.
     *
     * @return void
     */
    public static function bootHasEvents()
    {
        // Laravel 13 forbids instantiating the model while it is booting,
        // and observe() does it internally, so defer until booted when possible.
        if (method_exists(static::class, 'whenBooted')) {
            static::whenBooted(function () {
                static::observe(new NodeObserver);
            });

            return;
        }

        static::observe(new NodeObserver);
    }

    /**
     * Initialize the HasEvents trait for an instance.
     *
     * @return void
     */
    public function initializeHasEvents()
    {
        $this->addObservableEvents('moving', 'moved');
    }

    /**
     * Register a moving model event with the dispatcher.
     *
     * @param  Closure|string  $callback
     * @return void
     */
    public static function moving($callback)
    {
        static::registerModelEvent('moving', $callback);
    }

    /**
     * Register a moved model event with the dispatcher.
     *
     * @param  Closure|string  $callback
     * @return void
     */
    public static function moved($callback)
    {
        static::registerModelEvent('moved', $callback);
    }
}
