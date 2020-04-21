<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

use function array_key_exists;

final class BooleanInput extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;
    use Collection\HtmlForm;
    use Collection\BooleanOptions;

    /**
     * Generates a boolean input.
     *
     * This method is mainly called by {@see CheckboxForm} and {@see RadioForm}.
     *
     * @return string the generated input element.
     */
    public function run(): string
    {
        $this->addId();
        $this->addLabel();
        $this->addUncheck();

        $name = $this->addName();
        $value = $this->addValue();
        $type = $this->type;

        return Html::$type($name, $value, $this->options);
    }

    private function addLabel(): void
    {
        if ($this->label) {
            $this->options['label'] = Html::encode(
                $this->data->getAttributeLabel(
                    $this->getAttributeName($this->attribute)
                )
            );
        }
    }

    private function addValue(): bool
    {
        $value = $this->getAttributeValue($this->data, $this->attribute);

        if (!array_key_exists('value', $this->options)) {
            $this->options['value'] = '1';
        }

        return (bool) $value;
    }
}
