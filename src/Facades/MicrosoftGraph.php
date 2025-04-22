<?php

namespace SanSanLabs\MicrosoftGraph\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SanSanLabs\MicrosoftGraph\MicrosoftGraph
 */
class MicrosoftGraph extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SanSanLabs\MicrosoftGraph\MicrosoftGraph::class;
    }
}
