<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use RuntimeException;
use Yiisoft\Form\Field\Checkbox;
use Yiisoft\Form\Field\Date;
use Yiisoft\Form\Field\DateTimeLocal;
use Yiisoft\Form\Field\Email;
use Yiisoft\Form\Field\Hidden;
use Yiisoft\Form\Field\Number;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Field\Password;
use Yiisoft\Form\Field\Range;
use Yiisoft\Form\Field\ResetButton;
use Yiisoft\Form\Field\SubmitButton;
use Yiisoft\Form\Field\Telephone;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\Field\Textarea;
use Yiisoft\Form\Field\Url;

use function array_key_exists;

final class Field
{
    /**
     * @psalm-var array<string,array>
     */
    private static array $configs = [
        'default' => [],
    ];

    private static string $defaultConfigName = 'default';

    /**
     * @psalm-var array<string,FieldFactory>
     */
    private static array $factories = [];

    /**
     * @psalm-param array<string,array> $configs
     */
    public static function initialize(array $configs = [], string $defaultConfigName = 'default'): void
    {
        self::$configs = array_merge(self::$configs, $configs);
        self::$defaultConfigName = $defaultConfigName;
    }

    public static function checkbox(FormModelInterface $formModel, string $attribute, array $config = []): Checkbox
    {
        return self::getFactory()->checkbox($formModel, $attribute, $config);
    }

    public static function date(FormModelInterface $formModel, string $attribute, array $config = []): Date
    {
        return self::getFactory()->date($formModel, $attribute, $config);
    }

    public static function dateTimeLocal(
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): DateTimeLocal {
        return self::getFactory()->dateTimeLocal($formModel, $attribute, $config);
    }

    public static function email(FormModelInterface $formModel, string $attribute, array $config = []): Email
    {
        return self::getFactory()->email($formModel, $attribute, $config);
    }

    public static function hidden(FormModelInterface $formModel, string $attribute, array $config = []): Hidden
    {
        return self::getFactory()->hidden($formModel, $attribute, $config);
    }

    public static function number(FormModelInterface $formModel, string $attribute, array $config = []): Number
    {
        return self::getFactory()->number($formModel, $attribute, $config);
    }

    public static function password(FormModelInterface $formModel, string $attribute, array $config = []): Password
    {
        return self::getFactory()->password($formModel, $attribute, $config);
    }

    public static function range(FormModelInterface $formModel, string $attribute, array $config = []): Range
    {
        return self::getFactory()->range($formModel, $attribute, $config);
    }

    public static function resetButton(array $config = []): ResetButton
    {
        return self::getFactory()->resetButton($config);
    }

    public static function submitButton(array $config = []): SubmitButton
    {
        return self::getFactory()->submitButton($config);
    }

    public static function telephone(FormModelInterface $formModel, string $attribute, array $config = []): Telephone
    {
        return self::getFactory()->telephone($formModel, $attribute, $config);
    }

    public static function text(FormModelInterface $formModel, string $attribute, array $config = []): Text
    {
        return self::getFactory()->text($formModel, $attribute, $config);
    }

    public static function textarea(FormModelInterface $formModel, string $attribute, array $config = []): Textarea
    {
        return self::getFactory()->textarea($formModel, $attribute, $config);
    }

    public static function url(FormModelInterface $formModel, string $attribute, array $config = []): Url
    {
        return self::getFactory()->url($formModel, $attribute, $config);
    }

    public static function label(FormModelInterface $formModel, string $attribute, array $config = []): Label
    {
        return self::getFactory()->label($formModel, $attribute, $config);
    }

    public static function hint(FormModelInterface $formModel, string $attribute, array $config = []): Hint
    {
        return self::getFactory()->hint($formModel, $attribute, $config);
    }

    public static function error(FormModelInterface $formModel, string $attribute, array $config = []): Error
    {
        return self::getFactory()->error($formModel, $attribute, $config);
    }

    /**
     * @psalm-template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     */
    public function input(string $class, FormModelInterface $formModel, string $attribute, array $config = []): object
    {
        return self::getFactory()->input($class, $formModel, $attribute, $config);
    }

    /**
     * @psalm-template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     */
    public function field(string $class, array $config = []): object
    {
        return self::getFactory()->field($class, $config);
    }

    public static function getFactory(?string $name = null): FieldFactory
    {
        $name = $name ?? self::$defaultConfigName;

        if (!array_key_exists($name, self::$factories)) {
            if (!array_key_exists($name, self::$configs)) {
                throw new RuntimeException(
                    sprintf('Configuration with name "%s" not found.', $name)
                );
            }

            /** @psalm-suppress MixedArgument */
            self::$factories[$name] = new FieldFactory(...self::$configs[$name]);
        }

        return self::$factories[$name];
    }
}
