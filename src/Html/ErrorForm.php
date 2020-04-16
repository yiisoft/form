<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

final class ErrorForm
{
    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * Note that even if there is no validation error, this method will still return an empty error tag.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for the format about
     * attribute expression.
     * @param array $options the tag options in terms of name-value pairs. The values will be HTML-encoded using
     * {@see encode()}. If a value is null, the corresponding attribute will not be rendered.
     *
     * The following options are specially handled:
     *
     * - tag: this specifies the tag name. If not set, "div" will be used. See also {@see tag()}.
     * - encode: boolean, if set to false then the error message won't be encoded.
     * - errorSource: \Closure|callable, callback that will be called to obtain an error message.
     * The signature of the callback must be: `function ($form, $attribute)` and return a string.
     * When not set, the `$form->getFirstError()` method will be called.
     *
     * See {@see renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @return string the generated label tag
     */
    public static function create(FormInterface $form, string $attribute, array $options = []): string
    {
        $attribute = BaseForm::getAttributeName($attribute);
        $errorSource = ArrayHelper::remove($options, 'errorSource');

        if ($errorSource !== null) {
            $error = $errorSource($form, $attribute);
        } else {
            $error = $form->getFirstError($attribute);
        }

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $encode = ArrayHelper::remove($options, 'encode', true);

        return Html::tag($tag, $encode ? Html::encode($error) : $error, $options);
    }
}
