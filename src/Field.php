<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\InputText;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;

final class Field
{
    public static function inputText(FormModelInterface $formModel, string $attribute): InputText
    {
        return FieldStaticFactory::factory()->inputText($formModel, $attribute);
    }

    public static function label(FormModelInterface $formModel, string $attribute): Label
    {
        return FieldStaticFactory::factory()->label($formModel, $attribute);
    }

    public static function hint(FormModelInterface $formModel, string $attribute): Hint
    {
        return FieldStaticFactory::factory()->hint($formModel, $attribute);
    }

    public static function error(FormModelInterface $formModel, string $attribute): Error
    {
        return FieldStaticFactory::factory()->error($formModel, $attribute);
    }
}
