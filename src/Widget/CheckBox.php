<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class CheckBox extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;

    /**
     * Generates a checkbox tag together with a label for the given form attribute.
     *
     * This method will generate the "checked" tag attribute according to the form attribute value.
     *
     * @return string the generated checkbox tag.
     */
    public function run(): string
    {
        $new = clone $this;

        if (!empty($new->addId())) {
            $new->options['id'] = $new->addId();
        }

        return Html::checkBox($new->addName(), $new->addBooleanValue(), $new->options);
    }
}
