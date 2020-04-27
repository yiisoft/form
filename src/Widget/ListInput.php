<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class ListInput extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;

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

        if (!empty($new->addId())) {
            $new->options['id'] = $new->addId();
        }

        $type = $new->type;

        return Html::$type($new->addName(), $new->addValue(), $new->items, $new->options);
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
