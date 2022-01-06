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
use Yiisoft\Form\Widget\Radio;

final class RadioTest extends TestCase
{
    use TestTrait;

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" autofocus> Int</label>',
            Radio::widget()->autofocus()->for(new TypeForm(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" disabled> Int</label>',
            Radio::widget()->disabled()->for(new TypeForm(), 'int')->value(1)->render(),
        );
    }

    public function testEnClosedByLabelWithFalse(): void
    {
        $this->assertSame(
            '<input type="radio" id="typeform-int" name="TypeForm[int]" value="1">',
            Radio::widget()->for(new TypeForm(), 'int')->enclosedByLabel(false)->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="id-test" name="TypeForm[int]" value="1"> Int</label>',
            Radio::widget()->for(new TypeForm(), 'int')->id('id-test')->value(1)->render(),
        );
    }

    public function testImmutability(): void
    {
        $radio = Radio::widget();
        $this->assertNotSame($radio, $radio->enclosedByLabel(false));
        $this->assertNotSame($radio, $radio->label(''));
        $this->assertNotSame($radio, $radio->labelAttributes());
        $this->assertNotSame($radio, $radio->uncheckValue(0));
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<HTML
        <label class="test-class"><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Label:</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget()
                ->for(new TypeForm(), 'int')
                ->label('Label:')
                ->labelAttributes(['class' => 'test-class'])
                ->value(1)
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="name-test" value="1"> Int</label>',
            Radio::widget()->for(new TypeForm(), 'int')->name('name-test')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" required> Int</label>',
            Radio::widget()->for(new TypeForm(), 'int')->required()->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>',
            Radio::widget()->for(new TypeForm(), 'int')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTabIndex(): void
    {
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" tabindex="1"> Int</label>',
            Radio::widget()->for(new TypeForm(), 'int')->tabindex(1)->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget()->for(new TypeForm(), 'int')->uncheckValue(0)->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        // Value bool `false`.
        $this->assertSame(
            '<label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>',
            Radio::widget()->for(new TypeForm(), 'bool')->value(false)->render(),
        );

        // Value bool `true`.
        $this->assertSame(
            '<label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>',
            Radio::widget()->checked()->for(new TypeForm(), 'bool')->value(true)->render(),
        );

        // Value int `0`.
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>',
            Radio::widget()->for(new TypeForm(), 'int')->value(0)->render(),
        );

        // Value int `1`.
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>',
            Radio::widget()->checked()->for(new TypeForm(), 'int')->value(1)->render(),
        );

        // Value string `inactive`.
        $this->assertSame(
            '<label><input type="radio" id="typeform-string" name="TypeForm[string]" value="inactive"> String</label>',
            Radio::widget()->for(new TypeForm(), 'string')->value('inactive')->render(),
        );

        // Value string `active`.
        $expected = <<<HTML
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        HTML;
        $this->assertSame(
            $expected,
            Radio::widget()->checked()->for(new TypeForm(), 'string')->value('active')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]"> Int</label>',
            Radio::widget()->for(new TypeForm(), 'int')->value(null)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Radio widget value can not be an iterable or an object.');
        Radio::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value bool `true`.
        $formModel->setAttribute('bool', true);

        $this->assertSame(
            '<label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>',
            Radio::widget()->for($formModel, 'bool')->value(false)->render(),
        );
        $this->assertSame(
            '<label><input type="radio" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>',
            Radio::widget()->for($formModel, 'bool')->value(true)->render(),
        );

        // Value int `1`.
        $formModel->setAttribute('int', 1);

        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>',
            Radio::widget()->for($formModel, 'int')->value(0)->render(),
        );
        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>',
            Radio::widget()->for($formModel, 'int')->value(1)->render(),
        );

        // Value string `active`.
        $formModel->setAttribute('string', 'active');

        $this->assertSame(
            '<label><input type="radio" id="typeform-string" name="TypeForm[string]" value="inactive"> String</label>',
            Radio::widget()->for($formModel, 'string')->value('inactive')->render()
        );

        $expected = <<<HTML
        <label><input type="radio" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        HTML;
        $this->assertSame($expected, Radio::widget()->for($formModel, 'string')->value('active')->render());

        // Value `null`.
        $formModel->setAttribute('int', 'null');

        $this->assertSame(
            '<label><input type="radio" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>',
            Radio::widget()->for($formModel, 'int')->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $this->assertEqualsWithoutLE(
            '<label><input type="radio" name="TypeForm[int]" value="1"> Int</label>',
            Radio::widget()->for(new TypeForm(), 'int')->id(null)->value(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $this->assertEqualsWithoutLE(
            '<label><input type="radio" id="typeform-int" value="1"> Int</label>',
            Radio::widget()->for(new TypeForm(), 'int')->name(null)->value(1)->render(),
        );
    }
}
