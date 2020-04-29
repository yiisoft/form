<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class ListBox extends Widget
{
    use Options\Common;
    use Options\Input;

    private array $items = [];
    private string $type;

    /**
     * Generates a list box.
     *
     * The selection of the list box is taken from the value of the model attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated list box tag.
     */
    public function run(): string
    {
        $new = clone $this;

        if (!empty($new->getId())) {
            $new->options['id'] = $new->getId();
        }

        return ListInput::Widget()
            ->type('listBox')
            ->config($new->data, $new->attribute, $new->options)
            ->items($new->items)
            ->run();
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
