<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'change-payment-method',
        'create-business',
        'checkout',
        'get_business_account',
        'user-reset',
        'reset',
        'get_price',
        'get_end',
        'account-manager',
        'webhook',
        'webhook-response',
        'upload',
    ];
}
