<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Html;

final class FieldSubmitButtonTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->autofocus()
            ->submitButton()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->disabled()
            ->submitButton()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testForm(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" form="form-register">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->submitButton(['form()' => ['form-register']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="test-id" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->id('test-id')
            ->submitButton()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w1-submit" name="test-name">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->name('test-name')
            ->submitButton()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->submitButton()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->submitButton()
            ->tabindex(1)
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Save">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->submitButton()
            ->value('Save')
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->id(null)
            ->submitButton()
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <input type="submit" id="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->name(null)
            ->submitButton()
            ->render());
    }
}
