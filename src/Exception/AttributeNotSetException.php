<?php

declare(strict_types=1);

namespace Yiisoft\Form\Exception;

use InvalidArgumentException;
use Yiisoft\FriendlyException\FriendlyExceptionInterface;

final class AttributeNotSetException extends InvalidArgumentException implements FriendlyExceptionInterface
{
    public function __construct()
    {
        parent::__construct($this->getName());
    }

    public function getName(): string
    {
        return 'Failed to create widget because "attribute" is not set.';
    }

    public function getSolution(): ?string
    {
        return <<<SOLUTION
            You can configure the `attribute` in two ways. The first way is through the widgets using the `for()`
        method `Text::widget()->for(FormModel::class, attribute)`, where the second argument is the `attribute`.
        The second way is through the `Field::class` where in each field type the second argument is the
        `attribute`, `Field::widget->text(FormModel::class, attribute)`.
        SOLUTION;
    }
}
