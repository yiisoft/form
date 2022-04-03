<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use RuntimeException;

use function array_key_exists;

final class FormFields
{
    /**
     * @psalm-var array<string,array>
     */
    private static array $configs = [];

    private static ?string $defaultConfigName = null;

    /**
     * @psalm-var array<string,FieldFactory>
     */
    private static array $factories = [];

    /**
     * @psalm-param array<string,array> $configs
     */
    public static function initialize(array $configs, ?string $defaultConfigName = null): void
    {
        self::$configs = $configs;
        self::$defaultConfigName = $defaultConfigName;
    }

    public static function getFactory(?string $name = null): FieldFactory
    {
        $name = $name ?? self::$defaultConfigName;
        if ($name === null) {
            if (self::$defaultConfigName === null) {
                $name = array_key_first(self::$configs);
                if ($name === null) {
                    throw new RuntimeException('Not found default configuration of fields.');
                }
            } else {
                $name = self::$defaultConfigName;
            }
        }

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
