<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\PropertyTypeForm;

final class FormCollectorTest extends TestCase
{
    public function testGetAttributes(): void
    {
        $formmodel = new PropertyTypeForm();
        $this->assertSame(
            [
                'array' => 'array',
                'bool' => 'bool',
                'float' => 'float',
                'int' => 'int',
                'nullable' => 'int',
                'object' => 'object',
                'string' => 'string',
            ],
            $formmodel->getFormCollector()->attributes()
        );
    }

    public function testPhpTypeCast(): void
    {
        $formmodel = new PropertyTypeForm();
        $this->assertSame('1.1', $formmodel->getFormCollector()->phpTypeCast('string', 1.1));
        $this->assertSame(1.1, $formmodel->getFormCollector()->phpTypeCast('float', '1.1'));
    }

    public function testPhpTypeCastAttributeNoExist(): void
    {
        $formmodel = new PropertyTypeForm();
        $this->assertSame(null, $formmodel->getFormCollector()->phpTypeCast('noExist', 1));
    }

    public function testPropertyStringable(): void
    {
        $formmodel = new PropertyTypeForm();
        $objectStringable = new class () {
            public function __toString(): string
            {
                return 'joe doe';
            }
        };

        $formmodel->setAttribute('string', $objectStringable);
        $this->assertSame('joe doe', $formmodel->getAttributeValue('string'));
    }

    public function testSetValue(): void
    {
        $formmodel = new PropertyTypeForm();

        // value is array
        $formmodel->setAttribute('array', []);
        $this->assertSame([], $formmodel->getAttributeValue('array'));

        // value is string
        $formmodel->setAttribute('string', 'string');
        $this->assertSame('string', $formmodel->getAttributeValue('string'));

        // value is int
        $formmodel->setAttribute('int', 1);
        $this->assertSame(1, $formmodel->getAttributeValue('int'));

        // value is bool
        $formmodel->setAttribute('bool', true);
        $this->assertSame(true, $formmodel->getAttributeValue('bool'));

        // value is null
        $formmodel->setAttribute('object', null);
        $this->assertNull($formmodel->getAttributeValue('object'));

        // value is null
        $formmodel->setAttribute('nullable', null);
        $this->assertNull($formmodel->getAttributeValue('nullable'));

        // value is int
        $formmodel->setAttribute('nullable', 1);
        $this->assertSame(1, $formmodel->getAttributeValue('nullable'));
    }

    public function testSetAttributeException(): void
    {
        $formmodel = new PropertyTypeForm();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value is not of type "string".');
        $formmodel->setAttribute('string', []);
    }
}
