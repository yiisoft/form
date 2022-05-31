<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Hidden;

final class HiddenTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="hidden" name="TypeForm[string]">',
            Hidden::widget()
                ->for(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `1`.
        $this->assertSame(
            '<input type="hidden" name="TypeForm[string]" value="1">',
            Hidden::widget()
                ->for(new TypeForm(), 'string')
                ->value('1')
                ->render(),
        );

        // Value integer 1.
        $this->assertSame(
            '<input type="hidden" name="TypeForm[int]" value="1">',
            Hidden::widget()
                ->for(new TypeForm(), 'int')
                ->value(1)
                ->render(),
        );

        // Value null.
        $this->assertSame(
            '<input type="hidden" name="TypeForm[string]">',
            Hidden::widget()
                ->for(new TypeForm(), 'string')
                ->value(null)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hidden widget requires a string, numeric or null value.');
        Hidden::widget()
            ->for(new TypeForm(), 'array')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithForm(): void
    {
        $formModel = new TypeForm();

        // Value string `1`.
        $formModel->setAttribute('string', '1');
        $this->assertSame(
            '<input type="hidden" name="TypeForm[string]" value="1">',
            Hidden::widget()
                ->for($formModel, 'string')
                ->render(),
        );

        // Value integer 1.
        $formModel->setAttribute('int', 1);
        $this->assertSame(
            '<input type="hidden" name="TypeForm[int]" value="1">',
            Hidden::widget()
                ->for($formModel, 'int')
                ->render(),
        );

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<input type="hidden" name="TypeForm[string]">',
            Hidden::widget()
                ->for($formModel, 'string')
                ->render(),
        );
    }
}
