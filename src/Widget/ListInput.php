<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\Exception\InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class ListInput extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;
    use Collection\ListOptions;
    use Collection\HtmlForm;

    /**
     * Generates a list of input fields.
     *
     * This method is mainly called by {@see ListBox()}, {@see RadioList()} and {@see CheckboxList()}.
     *
     * @throws InvalidArgumentException
     *
     * @return string the generated input list
     */
    public function run(): string
    {
        $this->addId();
        $this->addUnselect();
        $this->addMultiple();

        $name = ArrayHelper::remove(
            $this->options,
            'name',
            $this->getInputName($this->data, $this->attribute)
        );
        $selection = ArrayHelper::remove(
            $this->options,
            'value',
            $this->getAttributeValue($this->data, $this->attribute)
        );
        $type = $this->type;

        return Html::$type($name, $selection, $this->items, $this->options);
    }
}
