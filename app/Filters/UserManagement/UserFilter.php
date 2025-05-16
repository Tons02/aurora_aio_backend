<?php

namespace App\Filters\Usermanagement;

use Essa\APIToolKit\Filters\QueryFilters;

class UserFilter extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [
        "id_prefix",
        "id_no",
        "first_name",
        "middle_name",
        "last_name",
        "mobile_number",
        "username"
    ];
}
