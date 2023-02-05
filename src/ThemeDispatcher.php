<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use RuntimeException;

use function array_key_exists;

final class ThemeDispatcher
{
    /**
     * @psalm-var array<string,array>
     */
    private static array $themeConfigs = [
        'default' => [],
    ];

    private static string $defaultThemeName = 'default';

    /**
     * @psalm-var array<string,Theme>
     */
    private static array $themes = [];

    /**
     * @param array<string,array> $themeConfigs Array of configurations with {@see Theme::__construct()}
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
     * @param string $defaultThemeName Configuration name that will be used for create fields by default. If value is
     * not "default", then `$configs` must contain configuration with this name.
     */
    public static function initialize(array $themeConfigs = [], string $defaultThemeName = 'default'): void
    {
        self::$themeConfigs = array_merge(self::$themeConfigs, $themeConfigs);
        self::$defaultThemeName = $defaultThemeName;
        self::$themes = [];
    }

    public static function getTheme(?string $name = null): Theme
    {
        $name ??= self::$defaultThemeName;

        if (!array_key_exists($name, self::$themes)) {
            if (!array_key_exists($name, self::$themeConfigs)) {
                throw new RuntimeException(
                    sprintf('Theme with name "%s" not found.', $name)
                );
            }

            /** @psalm-suppress MixedArgument */
            self::$themes[$name] = new Theme(...self::$themeConfigs[$name]);
        }

        return self::$themes[$name];
    }
}
