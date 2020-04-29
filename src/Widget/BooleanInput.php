<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class BooleanInput extends Widget
{
    use Options\Common;
    use Options\Input;

    private string $type;

    /**
     * Generates a boolean input.
     *
     * This method is mainly called by {@see CheckboxForm} and {@see RadioForm}.
     *
     * @return string the generated input element.
     */
    public function run(): string
    {
        $new = clone $this;
        $type = $new->type;

        if (!empty($new->getId())) {
            $new->options['id'] = $new->getId();
        }

        return Html::$type($new->getNameAndRemoveItFromOptions(), $new->getBooleanValueAndAddItToOptions(), $new->options);
    }

    public function type(string $value): self
    {
        $new = clone $this;
        $new->type = $value;
        return $new;
    }
}
