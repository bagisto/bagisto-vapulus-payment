<?php

namespace Webkul\Vapulus\Repositories;

use Webkul\Core\Eloquent\Repository;

/**
 * Vapulus Reposotory
 *
 * @author Vivek Sharma <viveksh047@webkul.com> @vivek-webkul
 * @copyright 2020 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class VapulusRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Vapulus\Contracts\Vapulus';
    }
}
