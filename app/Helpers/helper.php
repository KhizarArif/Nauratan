<?php

namespace App\Helpers;

use App\Models\Category;

function getSubCategories()
{
    return Category::orderBy('id', 'desc')->where([['status', 'active'], ['showHome', 'yes']])->get();
}
