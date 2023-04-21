<?php

declare(strict_types=1);

namespace Yiisoft\Form\Helper;

use Yiisoft\Form\FormModel;

use function in_array;

/**
 * HtmlFormErrors renders a list of errors for the specified model attribute.
 */
final class HtmlFormErrors
{
    /**
     * Returns the errors for all attributes.
     *
     * @param FormModel $formModel the form object.
     *
     * @return array the error messages.
     */
    public static function getAllErrors(FormModel $formModel): array
    {
        return $formModel
            ->getValidationResult()
            ->getErrorMessagesIndexedByAttribute();
    }

    /**
     * Returns the errors for single attribute.
     *
     * @param FormModel $formModel the form object.
     * @param string $attribute attribute name. Use null to retrieve errors for all attributes.
     */
    public static function getErrors(FormModel $formModel, string $attribute): array
    {
        return $formModel
            ->getValidationResult()
            ->getErrorMessagesIndexedByPath()[$attribute] ?? [];
    }

    /**
     * Returns first errors for all attributes as a one-dimensional array.
     *
     * @param FormModel $formModel the form object.
     *
     * @return array errors for all attributes as a one-dimensional array. Empty array is returned if no error.
     */
    public static function getErrorSummaryFirstErrors(FormModel $formModel): array
    {
        $result = [];
        foreach ($formModel->getValidationResult()->getErrorMessagesIndexedByPath() as $attribute => $messages) {
            if (isset($messages[0])) {
                $result[$attribute] = $messages[0];
            }
        }
        return $result;
    }

    /**
     * Returns the errors for all attributes as a one-dimensional array.
     *
     * @param FormModel $formModel the form object.
     * @param array $onlyAttributes list of attributes whose errors should be returned.
     *
     * @return array errors for all attributes as a one-dimensional array. Empty array is returned if no error.
     */
    public static function getErrorSummary(FormModel $formModel, array $onlyAttributes = []): array
    {
        if ($onlyAttributes === []) {
            return $formModel->getValidationResult()->getErrorMessages();
        }

        $result = [];
        foreach ($formModel->getValidationResult()->getErrorMessagesIndexedByPath() as $attribute => $messages) {
            if (in_array($attribute, $onlyAttributes, true)) {
                $result[] = $messages;
            }
        }

        return array_merge(...$result);
    }

    /**
     * Return the attribute first error message.
     *
     * @param FormModel $formModel the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @return string the error message. `null` returned if there is no error.
     */
    public static function getFirstError(FormModel $formModel, string $attribute): ?string
    {
        return $formModel
            ->getValidationResult()
            ->getErrorMessagesIndexedByPath()[HtmlForm::getAttributeName($formModel, $attribute)][0] ?? null;
    }

    /**
     * Returns the first error of every attribute in the model.
     *
     * @param FormModel $formModel the form object.
     *
     * @return array The first error message for each attribute in a model. Empty array is returned if there is no
     * error.
     */
    public static function getFirstErrors(FormModel $formModel): array
    {
        $result = [];
        foreach ($formModel->getValidationResult()->getErrorMessagesIndexedByPath() as $attribute => $messages) {
            if (isset($messages[0])) {
                $result[$attribute] = $messages[0];
            }
        }
        return $result;
    }

    /**
     * Returns a value indicating whether there is any validation error.
     *
     * @param FormModel $formModel the form object.
     * @param string|null $attribute attribute name. Use null to check all attributes.
     *
     * @return bool whether there is any error.
     */
    public static function hasErrors(FormModel $formModel, ?string $attribute = null): bool
    {
        return $attribute === null
            ? !$formModel->getValidationResult()->isValid()
            : !$formModel->getValidationResult()->isAttributeValid($attribute);
    }
}
