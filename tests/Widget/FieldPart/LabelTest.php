<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\FieldPart;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Exception\FormModelNotSetException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\FieldPart\Label;

final class LabelTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testForId(): void
    {
        $this->assertSame(
            '<label for="test-id">String</label>',
            Label::widget()->for(new TypeForm(), 'string')->forId('test-id')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetFormModelException(): void
    {
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod(Label::widget(), 'getFormModel');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $label = Label::widget();
        $this->assertNotSame($label, $label->attributes([]));
        $this->assertNotSame($label, $label->encode(false));
        $this->assertNotSame($label, $label->for(new TypeForm(), 'string'));
        $this->assertNotSame($label, $label->forId(''));
        $this->assertNotSame($label, $label->label(''));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabel(): void
    {
        $this->assertSame(
            '<label for="typeform-string">Label:</label>',
            Label::widget()->for(new TypeForm(), 'string')->label('Label:')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<label for="typeform-string">String</label>',
            Label::widget()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @link https://github.com/yiisoft/form/issues/85
     */
    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<label for="typeform-string">My&nbsp;Field</label>',
            Label::widget()->for(new TypeForm(), 'string')->encode(false)->label('My&nbsp;Field')->render(),
        );
    }
}
