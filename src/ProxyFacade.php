<?php

namespace SecureMyApp\Proxy;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SecureMyApp\Proxy\Skeleton\SkeletonClass
 */
class ProxyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'proxy';
    }
}
