<?php

namespace App\Enum;

enum SubscriptionType: string
{
    case Free = 'free';
    case Premium = 'premium';

    public function label(): string
    {
        return match($this) {
            self::Free => 'Free',
            self::Premium => 'Premium',
        };
    }
}
