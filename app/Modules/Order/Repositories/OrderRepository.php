<?php

namespace App\Modules\Order\Repositories;

use App\Models\Order;
use App\Modules\Shared\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function __construct(private Order $model)
    {
        parent::__construct($model);
    }

}
