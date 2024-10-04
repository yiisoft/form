<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

/**
 * Placement of label in {@see Checkbox}.
 */
enum CheckboxLabelPlacement
{
    /**
     * Output label according to the template.
     */
    case DEFAULT;

    /**
     * Wrap checkbox into label tag
     */
    case WRAP;

    /**
     * Output label side on side of checkbox.
     */
    case SIDE;
}
