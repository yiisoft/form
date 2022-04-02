<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\Text;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;

trait FieldTrait
{
    public static function inputText(FormModelInterface $formModel, string $attribute, array $config = []): Text
    {
        return self::widget(Text::class, $formModel, $attribute, $config);
    }

    public static function label(FormModelInterface $formModel, string $attribute, array $config = []): Label
    {
        return FieldStaticFactory::factory()->label($formModel, $attribute, $config);
    }

    public static function hint(FormModelInterface $formModel, string $attribute, array $config = []): Hint
    {
        return FieldStaticFactory::factory()->hint($formModel, $attribute, $config);
    }

    public static function error(FormModelInterface $formModel, string $attribute, array $config = []): Error
    {
        return FieldStaticFactory::factory()->error($formModel, $attribute, $config);
    }

    /**
     * @psalm-template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     */
    public static function widget(
        string $class,
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): object {
        return FieldStaticFactory::factory()->widget($class, $formModel, $attribute, $config);
    }
}
