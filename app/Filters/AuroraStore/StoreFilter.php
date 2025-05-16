<?php

namespace App\Filters\AuroraStore;

use Essa\APIToolKit\Filters\QueryFilters;

class StoreFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [];
}
