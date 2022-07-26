<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\FieldContentTrait;

final class StubFieldContentTrait
{
    use FieldContentTrait;

    public function getContent(): string
    {
        return $this->renderContent();
    }
}
