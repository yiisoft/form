<?php

declare(strict_types=1);

namespace Yiisoft\Form;

/**
 * FormModelInterface model represents an HTML form: its data, validation and presentation.
 */
interface FormMetadataInterface
{
    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given an attribute `firstName`, we can
     * declare a label `First Name` which is more user-friendly and can be displayed to end users.
     *
     * By default an attribute label is generated automatically. This method allows you to
     * explicitly specify attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to merge the parent labels
     * with child labels using functions such as `array_merge()`.
     *
     * @return array attribute labels (name => label)
     *
     * {@see getAttributeLabel()}
     */
    public function getAttributeLabels(): array;

    /**
     * Returns the text hint for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute hint.
     *
     * {@see getAttributeHint()}
     */
    public function getAttributeHint(string $attribute): string;

    /**
     * Returns the text placeholder for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute placeholder.
     *
     * {@see getAttributePlaceholder()}
     */
    public function getAttributePlaceHolder(string $attribute): string;
}
