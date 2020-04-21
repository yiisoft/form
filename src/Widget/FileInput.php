<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\Exception\InvalidArgumentException;
use Yiisoft\Widget\Widget;

final class FileInput extends Widget
{
    use Collection\Options;

    /**
     * Generates a file input tag for the given form attribute.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return string the generated input tag.
     */
    public function run(): string
    {
        $hiddenOptions = ['id' => false, 'value' => ''];

        if (isset($this->options['name'])) {
            $hiddenOptions['name'] = $this->options['name'];
        }

        /** make sure disabled input is not sending any value */
        if (!empty($this->options['disabled'])) {
            $hiddenOptions['disabled'] = $this->options['disabled'];
        }

        $hiddenOptions = ArrayHelper::merge($hiddenOptions, ArrayHelper::remove($this->options, 'hiddenOptions', []));

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
                ->data($this->data)
                ->attribute($this->attribute)
                ->options($hiddenOptions)
                ->run() .
            Input::widget()
                ->type('file')
                ->data($this->data)
                ->attribute($this->attribute)
                ->options($this->options)
                ->run();
    }
}
