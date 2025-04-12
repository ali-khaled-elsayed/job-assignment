<?php

namespace App\Modules\Order\Repositories;

use App\Models\Product;
use App\Modules\Shared\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function __construct(private Product $model)
    {
        parent::__construct($model);
    }

}
