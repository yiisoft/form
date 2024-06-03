<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Hidden;
use Yiisoft\Form\PureField;
use Yiisoft\Form\Theme\ThemeContainer;

final class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $bootstrapList = $this->getBootstrapList();

        $this->assertCount(1, $bootstrapList);

        $bootstrap = array_shift($bootstrapList);

        $this->assertIsCallable($bootstrap);

        $bootstrap();
    }

    public function testCustomParams(): void
    {
        $params = $this->getParams();
        $params['yiisoft/form']['themes'] = [
            'simple' => [
                'fieldConfigs' => [
                    Hidden::class => [
                        'inputId()' => ['TestId'],
                    ],
                ],
            ],
        ];
        $params['yiisoft/form']['defaultTheme'] = 'simple';

        $bootstrapList = $this->getBootstrapList($params);
        $bootstrap = array_shift($bootstrapList);
        $bootstrap();

        $input = PureField::hidden('key', 'x100');

        $this->assertSame(
            '<input type="hidden" id="TestId" name="key" value="x100">',
            $input->render()
        );
    }

    public static function dataTheme(): array
    {
        $configDir = dirname(__DIR__) . '/config';
        return [
            [$configDir . '/theme-bootstrap5-horizontal.php'],
            [$configDir . '/theme-bootstrap5-vertical.php'],
        ];
    }

    #[DataProvider('dataTheme')]
    public function testTheme(string $theme): void
    {
        $result = require $theme;

        $this->assertIsArray($result);
    }

    private function getBootstrapList(?array $params = null): array
    {
        if ($params === null) {
            $params = $this->getParams();
        }
        return require dirname(__DIR__) . '/config/bootstrap.php';
    }

    private function getParams(): array
    {
        return require dirname(__DIR__) . '/config/params.php';
    }
}
