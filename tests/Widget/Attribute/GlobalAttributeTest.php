<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Attribute;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Widget\Attribute\GlobalAttributes;
use Yiisoft\Form\Widget\Field;

final class GlobalAttributeTest extends TestCase
{
    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $globalAttributes = $this->createWidget();
        $this->assertNotSame($globalAttributes, $globalAttributes->autofocus());
        $this->assertNotSame($globalAttributes, $globalAttributes->attributes([]));
        $this->assertNotSame($globalAttributes, $globalAttributes->class(''));
        $this->assertNotSame($globalAttributes, $globalAttributes->disabled());
        $this->assertNotSame($globalAttributes, $globalAttributes->encode(true));
        $this->assertNotSame($globalAttributes, $globalAttributes->id(null));
        $this->assertNotSame($globalAttributes, $globalAttributes->name(null));
        $this->assertNotSame($globalAttributes, $globalAttributes->tabIndex(1));
        $this->assertNotSame($globalAttributes, $globalAttributes->title(''));
        $this->assertNotSame($globalAttributes, $globalAttributes->value(null));
    }

    private function createWidget(): GlobalAttributes
    {
        return new class () extends GlobalAttributes {
            protected function run(): string
            {
                return '';
            }
        };
    }
}
