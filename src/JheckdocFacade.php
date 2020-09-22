<?php

namespace JheckDoc\JheckDocLaravel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jheckdoc\Jheckdoc\Skeleton\SkeletonClass
 */
class JheckdocFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jheckdoc';
    }
}
