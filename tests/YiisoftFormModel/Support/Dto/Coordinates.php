<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\YiisoftFormModel\Support\Dto;

final class Coordinates
{
    public function __construct(
        private string $latitude = '',
        private string $longitude = '',
        private array $meta = [],
    ) {
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }
}
