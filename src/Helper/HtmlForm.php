<?php

declare(strict_types=1);

namespace Yiisoft\Form\Helper;

use InvalidArgumentException;
use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

final class HtmlForm
{
    /**
     * Returns the value of the specified attribute name or expression.
     *
     * For an attribute expression like `[0]dates[0]`, this method will return the value of `$form->dates[0]`.
     * See {@see getAttributeName()} for more details about attribute expression.
     *
     * If an attribute value an array of such instances, the primary value(s) of the AR instance(s) will be returned
     * instead.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string|array the corresponding attribute value.
     */
    public static function getAttributeValue(FormInterface $form, string $attribute)
    {
        if (!preg_match(Html::$attributeRegex, $attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }

        $attribute = $matches[2];

        return $form->getAttributeValue($attribute);
    }

    /**
     * Generates an appropriate input ID for the specified attribute name or expression.
     *
     * This method converts the result {@see getInputName()} into a valid input ID.
     *
     * For example, if {@see getInputName()} returns `Post[content]`, this method will return `post-content`.
     *
     * @param FormInterface $form the form object
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for explanation of
     * attribute expression.
     * @param string $charset default `UTF-8`.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string the generated input ID.
     */
    public static function getInputId(FormInterface $form, string $attribute, string $charset = 'UTF-8'): string
    {
        $name = mb_strtolower(static::getInputName($form, $attribute), $charset);

        return str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $name);
    }

    /**
     * Generates an appropriate input name for the specified attribute name or expression.
     *
     * This method generates a name that can be used as the input name to collect user input for the specified
     * attribute. The name is generated according to the of the form and the given attribute name. For example, if the
     * form name of the `Post` form is `Post`, then the input name generated for the `content` attribute would be
     * `Post[content]`.
     *
     * See {@see getAttributeName()} for explanation of attribute expression.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string the generated input name.
     */
    public static function getInputName(FormInterface $form, string $attribute): string
    {
        $formName = $form->formName();

        if (!preg_match(Html::$attributeRegex, $attribute, $matches)) {
            throw new \InvalidArgumentException('Attribute name must contain word characters only.');
        }

        [, $prefix, $attribute, $suffix] = $matches;

        if ($formName === '' && $prefix === '') {
            return $attribute . $suffix;
        }

        if ($formName !== '') {
            return $formName . $prefix . "[$attribute]" . $suffix;
        }

        throw new \InvalidArgumentException(get_class($form) . '::formName() cannot be empty for tabular inputs.');
    }

    /**
     * Generate placeholder from form attribute label.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for the format about
     * attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see encode()}.
     *
     * @return array
     */
    public static function addPlaceholders(FormInterface $form, string $attribute, $options = []): array
    {
        if (isset($options['placeholder']) && $options['placeholder'] === true) {
            $attribute = Html::getAttributeName($attribute);
            $options['placeholder'] = $form->attributeLabel($attribute);
        }

        return $options;
    }
}
