<?php

declare(strict_types=1);

namespace Yiisoft\Form\Helper;

use Yiisoft\Form\FormModelInterface;

/**
 * HtmlFormErrors renders a list of errors for the specified model attribute.
 */
final class HtmlFormErrors
{
    /**
     * Returns the errors for all attributes.
     *
     * @param FormModelInterface $formModel the form object.
     *
     * @return array the error messages.
     */
    public static function getAllErrors(FormModelInterface $formModel): array
    {
        return $formModel->getFormErrors()->getAllErrors();
    }

    /**
     * Returns the errors for single attribute.
     *
     * @param FormModelInterface $formModel the form object.
     * @param string $attribute attribute name. Use null to retrieve errors for all attributes.
     */
    public static function getErrors(FormModelInterface $formModel, string $attribute): array
    {
        return $formModel->getFormErrors()->getErrors($attribute);
    }

    /**
     * Returns first errors for all attributes as a one-dimensional array.
     *
     * @param FormModelInterface $formModel the form object.
     *
     * @return array errors for all attributes as a one-dimensional array. Empty array is returned if no error.
     */
    public static function getErrorSummaryFirstErrors(FormModelInterface $formModel): array
    {
        return $formModel->getFormErrors()->getErrorSummaryFirstErrors();
    }

    /**
     * Returns the errors for all attributes as a one-dimensional array.
     *
     * @param FormModelInterface $formModel the form object.
     * @param array $onlyAttributes list of attributes whose errors should be returned.
     *
     * @return array errors for all attributes as a one-dimensional array. Empty array is returned if no error.
     */
    public static function getErrorSummary(FormModelInterface $formModel, array $onlyAttributes = []): array
    {
        return $formModel->getFormErrors()->getErrorSummary($onlyAttributes);
    }

    /**
     * Return the attribute first error message.
     *
     * @param FormModelInterface $formModel the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @return string the error message. `null` returned if there is no error.
     */
    public static function getFirstError(FormModelInterface $formModel, string $attribute): ?string
    {
        return $formModel->getFormErrors()->getFirstError(HtmlForm::getAttributeName($formModel, $attribute));
    }

    /**
     * Returns the first error of every attribute in the model.
     *
     * @param FormModelInterface $formModel the form object.
     *
     * @return array The first error message for each attribute in a model. Empty array is returned if there is no
     * error.
     */
    public static function getFirstErrors(FormModelInterface $formModel): array
    {
        return $formModel->getFormErrors()->getFirstErrors();
    }

    /**
     * Returns a value indicating whether there is any validation error.
     *
     * @param FormModelInterface $formModel the form object.
     * @param string|null $attribute attribute name. Use null to check all attributes.
     *
     * @return bool whether there is any error.
     */
    public static function hasErrors(FormModelInterface $formModel, ?string $attribute = null): bool
    {
        return $formModel->getFormErrors()->hasErrors($attribute);
    }
}
