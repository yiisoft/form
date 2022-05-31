<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widge\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;

final class FieldHiddenTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="ActiveField[form_action]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->name('ActiveField[form_action]')
                ->hidden(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->hidden(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[string]" value="1">
        </div>
        HTML;
        // Value string `1`.
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->hidden(new TypeForm(), 'string')
                ->value('1')
                ->render(),
        );

        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="1">
        </div>
        HTML;
        // Value integer 1.
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->hidden(new TypeForm(), 'int')
                ->value(1)
                ->render(),
        );

        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[string]">
        </div>
        HTML;
        // Value null.
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->hidden(new TypeForm(), 'string')
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
        Field::widget()
            ->hidden(new TypeForm(), 'array')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value string `1`.
        $formModel->setAttribute('string', '1');
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[string]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->hidden($formModel, 'string')
                ->render(),
        );

        // Value integer 1.
        $formModel->setAttribute('int', 1);
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->hidden($formModel, 'int')
                ->render(),
        );

        // Value `null`.
        $formModel->setAttribute('string', null);
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->hidden($formModel, 'string')
                ->render(),
        );
    }
}
