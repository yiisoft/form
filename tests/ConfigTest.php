<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiiValidator\Field;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Form\Field\Hidden;
use Yiisoft\Form\Tests\Support\Form\HiddenForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $bootstrapList = $this->getBootstrapList();

        $this->assertCount(1, $bootstrapList);

        $bootstrap = array_shift($bootstrapList);

        $this->assertIsCallable($bootstrap);

        $bootstrap(new SimpleContainer());
    }

    public function testCustomParams(): void
    {
        $params = $this->getParams();
        $params['yiisoft/form']['configs'] = [
            'simple' => [
                'fieldConfigs' => [
                    Hidden::class => [
                        'inputId()' => ['TestId'],
                    ],
                ],
            ],
        ];
        $params['yiisoft/form']['defaultConfig'] = 'simple';

        $bootstrapList = $this->getBootstrapList($params);
        $bootstrap = array_shift($bootstrapList);
        $bootstrap(new SimpleContainer());

        $input = Field::hidden(new HiddenForm(), 'key');

        $this->assertSame(
            '<input type="hidden" id="TestId" name="HiddenForm[key]" value="x100">',
            $input->render()
        );
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
