<?php

namespace Chat\Inject;

use \Chat\Injector;
use \Chat\Renderer;


/**
 * Provides class field that contains instance of JSON renderer
 * and can retrieve it from IoC-container.
 */
trait JSONRenderer
{
    /**
     * Injected instance of JSON renderer.
     *
     * @var Renderer
     */
    protected $JsonRenderer;


    /**
     * Retrieves instance of JSON renderer from IoC-container
     * if it is not set yet.
     *
     * @return Renderer  Initialized instance of JSON renderer.
     */
    protected function initJsonRenderer(): Renderer
    {
        if (!isset($this->JsonRenderer)) {
            $this->JsonRenderer = Injector::make('JsonRenderer');
        }

        return $this->JsonRenderer;
    }
}
