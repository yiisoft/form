<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class ListInput extends Widget
{
    use Options\Common;
    use Options\Input;

    private array $items = [];
    private string $type;

    /**
     * Generates a list of input fields.
     *
     * This method is mainly called by {@see ListBox()}, {@see RadioList()} and {@see CheckboxList()}.
     *
     * @return string the generated input list
     */
    public function run(): string
    {
        $new = clone $this;

        if (!empty($new->getId())) {
            $new->options['id'] = $new->getId();
        }

        $type = $new->type;

        return Html::$type($new->getNameAndRemoveItFromOptions(), $new->getValueAndRemoveItFromOptions(), $new->items, $new->options);
    }

    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    public function type(string $value): self
    {
        $new = clone $this;
        $new->type = $value;
        return $new;
    }
}
