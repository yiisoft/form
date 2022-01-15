<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Widget\Attribute\ButtonAttributes;
use Yiisoft\Form\Widget\Field;

final class ButtonAttributesTest extends TestCase
{
    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $buttonAttributes = $this->createWidget();
        $this->assertNotSame($buttonAttributes, $buttonAttributes->form(''));
    }

    private function createWidget(): ButtonAttributes
    {
        return new class () extends ButtonAttributes {
            protected function run(): string
            {
                return '';
            }
        };
    }
}
