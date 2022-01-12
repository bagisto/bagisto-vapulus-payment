<?php

namespace Webkul\Vapulus\Providers;

use Webkul\Core\Providers\CoreModuleServiceProvider;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        \Webkul\Vapulus\Models\Vapulus::class,
    ];
}