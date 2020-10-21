<?php

declare(strict_types=1);

namespace Yiisoft\Form\Helper;

use InvalidArgumentException;
use Yiisoft\Form\FormModelInterface;

/**
 * Form-related HTML tag generation
 */
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
     * @param FormModelInterface $form the form object.
     * @param string $attribute the attribute name or expression.
     * @return string|array the corresponding attribute value.
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     */
    public static function getAttributeValue(FormModelInterface $form, string $attribute)
    {
        return $form->getAttributeValue(
            static::getAttributeName($attribute)
        );
    }

    /**
     * Generates an appropriate input ID for the specified attribute name or expression.
     *
     * This method converts the result {@see getInputName()} into a valid input ID.
     *
     * For example, if {@see getInputName()} returns `Post[content]`, this method will return `post-content`.
     *
     * @param FormModelInterface $form the form object
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for explanation of
     * attribute expression.
     * @param string $charset default `UTF-8`.
     *
     * @return string the generated input ID.
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     */
    public static function getInputId(FormModelInterface $form, string $attribute, string $charset = 'UTF-8'): string
    {
        $name = (string) mb_strtolower(static::getInputName($form, $attribute), $charset);

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
     * @param FormModelInterface $form the form object.
     * @param string $attribute the attribute name or expression.
     * @return string the generated input name.
     * @throws InvalidArgumentException if the attribute name contains non-word characters
     * or empty form name for tabular inputs
     */
    public static function getInputName(FormModelInterface $form, string $attribute): string
    {
        $formName = $form->formName();

        $data = static::parseAttribute($attribute);

        if ($formName === '' && $data['prefix'] === '') {
            return $attribute;
        }

        if ($formName !== '') {
            return $formName . $data['prefix'] . '[' . $data['name'] . ']' . $data['suffix'];
        }

        throw new InvalidArgumentException(get_class($form) . '::formName() cannot be empty for tabular inputs.');
    }

    /**
     * Returns the real attribute name from the given attribute expression.
     * If `$attribute` has neither prefix nor suffix, it will be returned back without change.
     * @param string $attribute the attribute name or expression
     * @return string the attribute name without prefix and suffix.
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     * @see static::parseAttribute()
     */
    public static function getAttributeName(string $attribute): string
    {
        return static::parseAttribute($attribute)['name'];
    }

    /**
     * This method parses an attribute expression and returns an associative array containing
     * real attribute name, prefix and suffix.
     * For example: `['name' => 'content', 'prefix' => '', 'suffix' => '[0]']`
     *
     * An attribute expression is an attribute name prefixed and/or suffixed with array indexes. It is mainly used in
     * tabular data input and/or input of array type. Below are some examples:
     *
     * - `[0]content` is used in tabular data input to represent the "content" attribute for the first model in tabular
     *    input;
     * - `dates[0]` represents the first array element of the "dates" attribute;
     * - `[0]dates[0]` represents the first array element of the "dates" attribute for the first model in tabular
     *    input.
     *
     * @param string $attribute the attribute name or expression
     * @return array
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     */
    private static function parseAttribute(string $attribute)
    {
        if (!preg_match('/(^|.*\])([\w\.\+]+)(\[.*|$)/u', $attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }
        return [
            'name' => $matches[2],
            'prefix' => $matches[1],
            'suffix' => $matches[3],
        ];
    }
}
