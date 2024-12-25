<?php

namespace App;

enum OrderStatus :int
{
    case PENDING = 0;
    case COMPLETED = 1;
    case CANCELLED = 2;
    case REFUNDED = 3;


public function label():string{
    return match($this) {
        self::PENDING => 'Pending',
        self::COMPLETED => 'Completed',
        self::CANCELLED => 'Cancelled',
        self::REFUNDED => 'Refunded',
    };
}
}
