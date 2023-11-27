<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Closure;
use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\Field\Base\InputData\InputDataInterface;

use function array_key_exists;

final class ThemeContainer
{
    /**
     * @psalm-var array<string,array>
     */
    private static array $configs = [];

    private static ?string $defaultConfig = null;

    /**
     * @psalm-var array<string,Theme|null>
     */
    private static array $themes = [];

    /**
     * @psalm-var array<class-string, array<array-key,Closure>>
     */
    private static array $validationRulesEnrichmenters = [];

    /**
     * @param array<string,array> $configs Array of configurations with {@see Theme::__construct()}
     * arguments indexed by name. For example:
     * ```php
     * [
     *     'default' => [
     *         'containerClass' => 'formField',
     *     ],
     *     'bulma' => [
     *         'containerClass' => 'field',
     *         'inputClass' => 'input',
     *         'invalidClass' => 'has-background-danger',
     *         'validClass' => 'has-background-success',
     *         'template' => "{label}<div class=\"control\">\n{input}</div>\n{hint}\n{error}",
     *         'labelClass' => 'label',
     *         'errorClass' => 'has-text-danger is-italic',
     *         'hintClass' => 'help',
     *     ],
     *     'bootstrap5' => [
     *         'containerClass' => 'mb-3',
     *         'invalidClass' => 'is-invalid',
     *         'errorClass' => 'text-danger fst-italic',
     *         'hintClass' => 'form-text',
     *         'inputClass' => 'form-control',
     *         'labelClass' => 'form-label',
     *         'validClass' => 'is-valid',
     *     ],
     * ]
     * ```
     * @param string|null $defaultConfig Configuration name that will be used for create fields by default.
     * @param string[] $validationRulesEnrichmenters
     *
     * @psalm-param array<class-string, array<array-key,Closure>> $validationRulesEnrichmenters
     */
    public static function initialize(
        array $configs = [],
        ?string $defaultConfig = null,
        array $validationRulesEnrichmenters = [],
    ): void {
        self::$configs = $configs;
        self::$defaultConfig = $defaultConfig;
        self::$themes = [];

        self::$validationRulesEnrichmenters = [];
        foreach ($validationRulesEnrichmenters as $inputDataClass => $file) {
            /**
             * @psalm-suppress UnresolvableInclude
             * @psalm-suppress MixedPropertyTypeCoercion
             */
            self::$validationRulesEnrichmenters[$inputDataClass] = require $file;
        }
    }

    public static function getTheme(?string $name = null): ?Theme
    {
        $name ??= self::$defaultConfig;
        if ($name === null) {
            return null;
        }

        if (!array_key_exists($name, self::$themes)) {
            /** @psalm-suppress MixedArgument */
            self::$themes[$name] = array_key_exists($name, self::$configs)
                ? new Theme(...self::$configs[$name])
                : null;
        }

        return self::$themes[$name];
    }

    public static function enrichmentValidationRules(BaseField $field, InputDataInterface $inputData): void
    {
        $enrichmenters = self::$validationRulesEnrichmenters[$inputData::class] ?? null;
        if ($enrichmenters === null) {
            return;
        }

        foreach ($enrichmenters as $key => $closure) {
            if (is_int($key) || $key === $field::class) {
                /** @psalm-suppress PossiblyNullFunctionCall */
                $closure->bindTo($field, $field::class)($inputData->getValidationRules());
            }
        }
    }
}
