<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class FileInput extends Widget
{
    use Options\Common;

    /**
     * Generates a file input tag for the given form attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated input tag.
     */
    public function run(): string
    {
        $new = clone $this;

        $hiddenOptions = ['id' => false, 'value' => ''];

        if (isset($new->options['name'])) {
            $hiddenOptions['name'] = $new->options['name'];
        }

        /** make sure disabled input is not sending any value */
        if (!empty($new->options['disabled'])) {
            $hiddenOptions['disabled'] = $new->options['disabled'];
        }

        $hiddenOptions = ArrayHelper::merge($hiddenOptions, ArrayHelper::remove($new->options, 'hiddenOptions', []));

        /**
         * Add a hidden field so that if a form only has a file field, we can still use isset($body[$formClass]) to
         * detect if the input is submitted.
         * The hidden input will be assigned its own set of html options via `$hiddenOptions`.
         * This provides the possibility to interact with the hidden field via client script.
         *
         * Note: For file-field-only form with `disabled` option set to `true` input submitting detection won't work.
         */
        return
            HiddenInput::widget()
                ->config($new->data, $new->attribute, $hiddenOptions)
                ->run() .
            Input::widget()
                ->type('file')
                ->config($new->data, $new->attribute, $new->options)
                ->run();
    }
}
