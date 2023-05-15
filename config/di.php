<?php

declare(strict_types=1);

use Vjik\InputValidation\ValidatingHydrator;
use Yiisoft\Definitions\Reference;
use Yiisoft\Form\FormHydrator;

return [
    FormHydrator::class => [
        '__construct()' => [
            'hydrator' => Reference::to(ValidatingHydrator::class),
        ],
    ],
];
