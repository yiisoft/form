<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use RuntimeException;

use function array_key_exists;

final class ThemeContainer
{
    private const INITIAL_CONFIGS = ['default' => []];
    private const INITIAL_DEFAULT_CONFIG = 'default';

    /**
     * @psalm-var array<string,array>
     */
    private static array $configs = self::INITIAL_CONFIGS;

    private static string $defaultConfig = self::INITIAL_DEFAULT_CONFIG;

    /**
     * @psalm-var array<string,Theme>
     */
    private static array $themes = [];

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
     * @param string $defaultConfig Configuration name that will be used for create fields by default. If value is
     * not "default", then `$configs` must contain configuration with this name.
     */
    public static function initialize(array $configs = [], string $defaultConfig = self::INITIAL_DEFAULT_CONFIG): void
    {
        self::$configs = array_merge(self::INITIAL_CONFIGS, $configs);
        self::$defaultConfig = $defaultConfig;
        self::$themes = [];
    }

    public static function getTheme(?string $name = null): Theme
    {
        $name ??= self::$defaultConfig;

        if (!array_key_exists($name, self::$themes)) {
            if (!array_key_exists($name, self::$configs)) {
                throw new RuntimeException(
                    sprintf('Theme with name "%s" not found.', $name)
                );
            }

            /** @psalm-suppress MixedArgument */
            self::$themes[$name] = new Theme(...self::$configs[$name]);
        }

        return self::$themes[$name];
    }
}
