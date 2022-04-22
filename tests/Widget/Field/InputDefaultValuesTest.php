<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;

final class InputDefaultValuesTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAriaDescribedByDefinitions(): void
    {
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]">
        <div>Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['ariaDescribedBy()' => [false]])->text(new PersonalForm(), 'name')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAriaDescribedByDefaultValues(): void
    {
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" aria-describedby="personalform-name-help">
        <div id="personalform-name-help">Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['ariaDescribedBy()' => [false]])
                ->defaultValues(['text' => ['ariaDescribedBy' => true]])
                ->text(new PersonalForm(), 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAttributesDefinitions(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="class-definitions" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['attributes()' => [['class' => 'class-definitions']]])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAttributesDefaultValues(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="class-widget" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['attributes()' => [['class' => 'class-definitions']]])
                ->defaultValues(['text' => ['attributes' => ['class' => 'class-widget']]])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributesDefinitions(): void
    {
        $expected = <<<HTML
        <div class="text-left" style="color: red">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerAttributes()' => [['class' => 'text-left', 'style' => 'color: red']]])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributesDefaultValues(): void
    {
        $expected = <<<HTML
        <div class="text-right" style="color: black">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerAttributes()' => [['class' => 'text-left', 'style' => 'color: red']]])
                ->defaultValues(
                    [
                        'text' => [
                            'containerAttributes' => ['class' => 'text-right', 'style' => 'color: black'],
                        ],
                    ],
                )
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerClassDefinitions(): void
    {
        $expected = <<<HTML
        <div class="container-class-definition">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerClass()' => ['container-class-definition']])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerClassDefaultValues(): void
    {
        $expected = <<<HTML
        <div class="container-class-widget">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['containerClass()' => ['container-class-definition']])
                ->defaultValues(['text' => ['containerClass' => 'container-class-widget']])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testErrorMessageDefinitions(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]">
        <div>Write your first name.</div>
        <span class="text-danger is-invalid">error-text</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
                [
                    'error()' => ['error-text'],
                    'errorAttributes()' => [['class' => 'text-danger']],
                    'errorClass()' => ['is-invalid'],
                    'errorTag()' => ['span'],
                ]
            )
                ->text($formModel, 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testErrorMessageDefaultValues(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]">
        <div>Write your first name.</div>
        <p class="text-warning invalid-feedback">error-text-widget</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
                [
                    'error()' => ['error-text'],
                    'errorAttributes()' => [['class' => 'text-danger']],
                    'errorClass()' => ['is-invalid'],
                    'errorTag()' => ['span'],
                ]
            )
                ->defaultValues(
                    [
                        'text' => [
                            'error' => 'error-text-widget',
                            'errorAttributes' => ['class' => 'text-warning'],
                            'errorClass' => 'invalid-feedback',
                            'errorTag' => 'p',
                        ],
                    ],
                )
                ->text($formModel, 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testErrorMessageCallbackDefinitions(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]">
        <div>Write your first name.</div>
        <span class="text-danger is-invalid">This is custom error message.</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
                [
                    'errorMessageCallback()' => [[$formModel, 'customError']],
                    'errorAttributes()' => [['class' => 'text-danger']],
                    'errorClass()' => ['is-invalid'],
                    'errorTag()' => ['span'],
                ]
            )
                ->text($formModel, 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testErrorMessageCallbackDefaultValues(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]">
        <div>Write your first name.</div>
        <p class="text-warning invalid-feedback">(&amp;#10006;) This is custom error message.</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
                [
                    'errorMessageCallback()' => [[$formModel, 'customError']],
                    'errorAttributes()' => [['class' => 'text-danger']],
                    'errorClass()' => ['is-invalid'],
                    'errorTag()' => ['span'],
                ]
            )
                ->defaultValues(
                    [
                        'text' => [
                            'errorMessageCallback' => [$formModel, 'customErrorWithIcon'],
                            'errorAttributes' => ['class' => 'text-warning'],
                            'errorClass' => 'invalid-feedback',
                            'errorTag' => 'p',
                        ],
                    ],
                )
                ->text($formModel, 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHintDefinitions(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <span class="text-primary hint-class">hint-text</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
                [
                    'hint()' => ['hint-text'],
                    'hintAttributes()' => [['class' => 'text-primary']],
                    'hintClass()' => ['hint-class'],
                    'hintTag()' => ['span'],
                ]
            )
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHintDefaultValues(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <p class="text-warning hint-widget-class">hint-text-widget</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
                [
                    'hint()' => ['hint-text'],
                    'hintAttributes()' => [['class' => 'text-primary']],
                    'hintClass()' => ['hint-class'],
                    'hintTag()' => ['span'],
                ]
            )
                ->defaultValues(
                    [
                        'text' => [
                            'hint' => 'hint-text-widget',
                            'hintAttributes' => ['class' => 'text-warning'],
                            'hintClass' => 'hint-widget-class',
                            'hintTag' => 'p',
                        ],
                    ],
                )
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testInputClassDefinitions(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="form-control" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['inputClass()' => ['form-control']])->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testInputClassDefaultValues(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="form-control-group" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['inputClass()' => ['form-control']])
                ->defaultValues(['text' => ['inputClass' => 'form-control-group']])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testInvalidClassDefinitions(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="is-invalid" name="PersonalForm[name]">
        <div>Write your first name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['invalidClass()' => ['is-invalid']])->text($formModel, 'name')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testInvalidClassDefaultValues(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="invalid-tooltip" name="PersonalForm[name]">
        <div>Write your first name.</div>
        <div>Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['invalidClass()' => ['is-invalid']])
                ->defaultValues(['text' => ['invalidClass' => 'invalid-tooltip']])
                ->text($formModel, 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelDefinitions(): void
    {
        $expected = <<<HTML
        <div>
        <label class="text-primary label-class" for="typeform-string">label-text</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
                [
                    'label()' => ['label-text'],
                    'labelAttributes()' => [['class' => 'text-primary']],
                    'labelClass()' => ['label-class'],
                ]
            )
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelDefaultValues(): void
    {
        $expected = <<<HTML
        <div>
        <label class="text-warning label-class-widget" for="typeform-string">label-text-widget</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(
                [
                    'label()' => ['label-text'],
                    'labelAttributes()' => [['class' => 'text-primary']],
                    'labelClass()' => ['label-class'],
                ]
            )
                ->defaultValues(
                    [
                        'text' => [
                            'label' => 'label-text-widget',
                            'labelAttributes' => ['class' => 'text-warning'],
                            'labelClass' => 'label-class-widget',
                        ],
                    ],
                )
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholderDefinitions(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" placeholder="placeholder-text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['placeholder()' => ['placeholder-text']])->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholderDefaultValues(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" placeholder="placeholder-widget-text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['placeholder()' => ['placeholder-text']])
                ->defaultValues(['text' => ['placeholder' => 'placeholder-widget-text']])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTemplateDefinitions(): void
    {
        $expected = <<<HTML
        <div>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <label for="typeform-string">String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['template()' => ["{input}\n{label}\n{hint}\n{error}"]])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTemplateDefaultValues(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['template()' => ["{input}\n{label}\n{hint}\n{error}"]])
                ->defaultValues(['text' => ['template' => "{label}\n{input}\n{hint}\n{error}"]])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValidClassDefinitions(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => 'samdark']]);
        $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="is-valid" name="PersonalForm[name]" value="samdark">
        <div>Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['validClass()' => ['is-valid']])->text($formModel, 'name')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValidClassDefaultValues(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => 'samdark']]);
        $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="valid-tooltip" name="PersonalForm[name]" value="samdark">
        <div>Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['validClass()' => ['is-valid']])
                ->defaultValues(['text' => ['validClass' => 'valid-tooltip']])
                ->text($formModel, 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutContainerDefinitions(): void
    {
        $expected = <<<HTML
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['container()' => [false]])->text(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutContainerDefaultValues(): void
    {
        $expected = <<<HTML
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget(['container()' => [true]])
                ->defaultValues(['text' => ['container' => false]])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }
}
