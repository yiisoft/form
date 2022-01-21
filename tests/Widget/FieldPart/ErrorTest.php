<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\FieldPart;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Exception\FormModelNotSetException;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\FieldPart\Error;

final class ErrorTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetFormModelException(): void
    {
        $this->expectException(FormModelNotSetException::class);
        $this->expectExceptionMessage('Failed to create widget because form model is not set.');
        $this->invokeMethod(Error::widget(), 'getFormModel');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $error = Error::widget();
        $this->assertNotSame($error, $error->attributes([]));
        $this->assertNotSame($error, $error->encode(false));
        $this->assertNotSame($error, $error->for(new PersonalForm(), 'name'));
        $this->assertNotSame($error, $error->message(''));
        $this->assertNotSame($error, $error->messageCallback([]));
        $this->assertNotSame($error, $error->tag('div'));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMessage(): void
    {
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::widget()->for($this->validation(), 'name')->message('This is custom error message.')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMessageCallback(): void
    {
        $this->assertSame(
            '<div>This is custom error message.</div>',
            Error::widget()
                ->for($this->validation(), 'name')
                ->messageCallback([new PersonalForm(), 'customError'])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMessageCallbackWithNoEncode(): void
    {
        $this->assertSame(
            '<div>(&#10006;) This is custom error message.</div>',
            Error::widget()
                ->for($this->validation(), 'name')
                ->encode(false)
                ->messageCallback([new PersonalForm(), 'customErrorWithIcon'])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<div>Value cannot be blank.</div>',
            Error::widget()->for($this->validation(), 'name')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTag(): void
    {
        $this->assertSame(
            'Value cannot be blank.',
            Error::widget()->for($this->validation(), 'name')->tag('')->render(),
        );
        $this->assertSame(
            '<span>Value cannot be blank.</span>',
            Error::widget()->for($this->validation(), 'name')->tag('span')->render(),
        );
    }

    private function validation(): PersonalForm
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $this->createValidatorMock()->validate($formModel);
        return $formModel;
    }
}
