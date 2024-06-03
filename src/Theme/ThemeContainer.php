<?php

declare(strict_types=1);

namespace Yiisoft\Form\Theme;

use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\Field\Base\InputData\InputDataInterface;
use Yiisoft\Form\ValidationRulesEnricherInterface;

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

    private static ?ValidationRulesEnricherInterface $validationRulesEnricher = null;

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
     */
    public static function initialize(
        array $configs = [],
        ?string $defaultConfig = null,
        ?ValidationRulesEnricherInterface $validationRulesEnricher = null,
    ): void {
        self::$configs = $configs;
        self::$defaultConfig = $defaultConfig;
        self::$themes = [];
        self::$validationRulesEnricher = $validationRulesEnricher;
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

    public static function getEnrichment(BaseField $field, InputDataInterface $inputData): array
    {
        return self::$validationRulesEnricher?->process($field, $inputData->getValidationRules()) ?? [];
    }
}
