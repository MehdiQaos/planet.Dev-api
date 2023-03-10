<?php

namespace App\Filters;

use App\Http\Requests;

class ArticleFilter extends ApiFilter
{
    protected $safeParams = [
        'userId' => ['eq'],
        'categoryId' => ['eq']
    ];

    protected $columnMap = [
        'userId' => 'user_id',
        'categoryId' => 'category_id'
    ];
}