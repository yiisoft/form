<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class TextArea extends Widget
{
    use Options\Common;
    use Options\Input;

    /**
     * Generates a textarea tag for the given form attribute.
     *
     * @return string the generated textarea tag.
     */
    public function run(): string
    {
        $new = clone $this;

        $new->setPlaceholderOptions();

        if (!empty($new->getId())) {
            $new->options['id'] = $new->getId();
        }

        return Html::textarea($new->getNameAndRemoveItFromOptions(), $new->getValueAndRemoveItFromOptions(), $new->options);
    }
}
