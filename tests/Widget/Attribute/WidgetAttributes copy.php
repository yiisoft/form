<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\Attribute\WidgetAttributes;

final class InputAttributeTest extends TestCase
{
    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $widgetAttributes = $this->createWidget();
        $this->assertNotSame($widgetAttributes, $widgetAttributes->for(new TypeForm(), 'attribute'));
    }

    private function createWidget(): WidgetAttributes
    {
        return new class () extends WidgetAttributes {
            protected function run(): string
            {
                return '';
            }
        };
    }
}
