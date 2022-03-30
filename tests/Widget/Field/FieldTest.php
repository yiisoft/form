<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Html\Tag\Span;

final class FieldTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributes(): void
    {
        $expected = <<<HTML
        <div id="id-test" class="test-class">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->containerId('id-test')
                ->containerAttributes(['class' => 'test-class'])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerId(): void
    {
        $expected = <<<HTML
        <div id="id-test">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->containerId('id-test')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerName(): void
    {
        $expected = <<<HTML
        <div name="name-test">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->containerName('name-test')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDefaultTokens(): void
    {
        $expected = <<<HTML
        <div class="input-group mb-3">
        <span class="input-group-text">.00</span>
        <input type="text" id="typeform-string" class="form-control" name="TypeForm[string]" aria-describedby="typeform-string-help" aria-label="Amount (to the nearest dollar)">
        <span class="input-group-text">$</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->ariaDescribedBy(true)
                ->ariaLabel('Amount (to the nearest dollar)')
                ->containerClass('input-group mb-3')
                ->defaultTokens(
                    [
                        '{after}' => Span::tag()->class('input-group-text')->content('$'),
                        '{before}' => Span::tag()->class('input-group-text')->content('.00'),
                    ]
                )
                ->inputClass('form-control')
                ->template("{before}\n{input}\n{after}\n{hint}\n{error}")
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDefaultTokensWithOverrideToken(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="color" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultTokens(
                    [
                        '{input}' => Input::tag()->id('typeform-string')->name('TypeForm[string]')->type('color'),
                    ]
                )
                ->template("{label}\n{input}\n{hint}\n{error}")
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/forms/input-group/
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDefaultTokensWithDefaultValues(): void
    {
        $factoryConfig = [
            'defaultValues()' => [
                [
                    'text' => [
                        'defaultTokens' => [
                            '{after}' => Span::tag()->class('input-group-text')->content('$'),
                            '{before}' => Span::tag()->class('input-group-text')->content('.00'),
                        ],
                        'template' => "{before}\n{input}\n{after}\n{error}",
                    ],
                    'textArea' => [
                        'defaultTokens' => [
                            '{before}' => Span::tag()->class('input-group-text')->content('With textarea'),
                        ],
                        'template' => "{before}\n{input}\n{error}",
                    ],
                ],
            ],
        ];

        $field = Field::widget($factoryConfig);

        $expected = <<<HTML
        <div class="input-group mb-3">
        <span class="input-group-text">.00</span>
        <input type="text" id="typeform-string" class="form-control" name="TypeForm[string]" aria-describedby="typeform-string-help" aria-label="Amount (to the nearest dollar)">
        <span class="input-group-text">$</span>
        </div>
        <div class="input-group">
        <span class="input-group-text">With textarea</span>
        <textarea id="typeform-string" name="TypeForm[string]"></textarea>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            $field
                ->ariaDescribedBy(true)
                ->ariaLabel('Amount (to the nearest dollar)')
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->text(new TypeForm(), 'string')
                ->render() . PHP_EOL .
            $field
                ->containerClass('input-group')
                ->textArea(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelFor(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->labelFor('id-test')->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReplaceIndividualToken(): void
    {
        $factoryConfig = [
            'defaultTokens()' => [
                [
                    '{after}' => Span::tag()->class('input-group-text')->content('$'),
                    '{before}' => Span::tag()->class('input-group-text')->content('.00'),
                ],
            ],
        ];

        $expected = <<<HTML
        <div class="input-group mb-3">
        <span class="input-group-text">.00</span>
        <input type="text" id="typeform-string" class="form-control" name="TypeForm[string]" aria-describedby="typeform-string-help" aria-label="Amount (to the nearest dollar)">
        <span class="input-group-text">€</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($factoryConfig)
                ->ariaDescribedBy(true)
                ->ariaLabel('Amount (to the nearest dollar)')
                ->containerClass('input-group mb-3')
                ->inputClass('form-control')
                ->replaceIndividualToken('{after}', Span::tag()->class('input-group-text')->content('€'))
                ->template("{before}\n{input}\n{after}\n{hint}\n{error}")
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }
}
