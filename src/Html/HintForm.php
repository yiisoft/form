<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

final class HintForm
{
    /**
     * Generates a hint tag for the given form attribute.
     *
     * The hint text is the hint associated with the attribute, obtained via {@see Form::getAttributeHint()}.
     *
     * If no hint content can be obtained, method will return an empty string.
     *
     * @param FormInterface $form the form object
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for the format about
     * attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see encode()}.
     *
     * If a value is null, the corresponding attribute will not be rendered.
     * The following options are specially handled:
     *
     * - hint: this specifies the hint to be displayed. Note that this will NOT be {@see encode()|encoded}.
     * If this is not set, {@see Form::getAttributeHint()} will be called to get the hint for display (without
     * encoding).
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @return string the generated hint tag.
     */
    public static function create(FormInterface $form, string $attribute, array $options = []): string
    {
        $attribute = BaseForm::getAttributeName($attribute);
        $hint = $options['hint'] ?? $form->getAttributeHint($attribute);

        if (empty($hint)) {
            return '';
        }

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        unset($options['hint']);

        return Html::tag($tag, $hint, $options);
    }
}
