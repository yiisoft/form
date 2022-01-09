<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Forms\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\PersonalForm;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Html;

final class DefaultValuesTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testgetAriaDescribedByDefaultValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" aria-describedby="typeform-string-help">
        <div id="typeform-string-help">Hint text</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'ariaDescribedBy' => true,
                            'hint' => 'Hint text',
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
    public function testgetAriaDescribedByWidgetValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <div>Hint text</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->ariaDescribedBy(false)
                ->defaultValues(
                    [
                        'text' => [
                            'ariaDescribedBy' => true,
                            'hint' => 'Hint text',
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
    public function testAttributesDefaultValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="text-primary" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'attributes' => ['class' => 'text-primary'],
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
    public function testAttributesWidgetValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="text-success" name="TypeForm[string]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'attributes' => ['class' => 'text-primary'],
                        ],
                    ],
                )
                ->attributes(['class' => 'text-success', 'autofocus' => true])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsAttributesDefaultValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'submit' => [
                            'attributes' => ['value' => 'Submit'],
                        ],
                    ],
                )
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsAttributesWidgetValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Ok">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->attributes(['value' => 'Ok'])
                ->defaultValues(
                    [
                        'submit' => [
                            'attributes' => ['value' => 'Submit'],
                        ],
                    ],
                )
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsContainerAttributesDefaultValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div class="btn btn-group btn-group-lg btn-success">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'buttons' => [
                            'containerAttributes' => ['class' => 'btn btn-group btn-group-lg btn-success'],
                        ],
                    ],
                )
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsContainerAttributesWidgetValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div class="btn btn-group btn-group-lg btn-danger">
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->containerAttributes(['class' => 'btn btn-group btn-group-lg btn-danger'])
                ->defaultValues(
                    [
                        'buttons' => [
                            'containerAttributes' => ['class' => 'btn btn-group btn-group-lg btn-success'],
                        ],
                    ],
                )
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsWithoutContainerDefaultValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="submit" id="w1-submit" name="w1-submit">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'buttons' => [
                            'container' => false,
                        ],
                    ],
                )
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsWithoutContainerWidgetValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->container(true)
                ->defaultValues(
                    [
                        'buttons' => [
                            'container' => false,
                        ],
                    ],
                )
                ->submitButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsGroupAttributesDefaultValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Submit"><input type="reset" id="w2-reset" name="w2-reset" value="Reseteable">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'submit' => [
                            'attributes' => ['value' => 'Submit'],
                        ],
                        'reset' => [
                            'attributes' => ['value' => 'Reseteable'],
                        ],
                    ],
                )
                ->submitButton()
                ->resetButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsGroupAttributesWidgetValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit" value="Ok"><input type="reset" id="w2-reset" name="w2-reset" value="Ok">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->attributes(['value' => 'Ok'])
                ->defaultValues(
                    [
                        'submit' => [
                            'attributes' => ['value' => 'Submit'],
                        ],
                        'reset' => [
                            'attributes' => ['value' => 'Reseteable'],
                        ],
                    ],
                )
                ->submitButton()
                ->resetButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsGroupContainerAttributesDefaultValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div class="btn btn-group btn-group-lg btn-success">
        <input type="submit" id="w1-submit" name="w1-submit"><input type="reset" id="w2-reset" name="w2-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'buttons' => [
                            'containerAttributes' => ['class' => 'btn btn-group btn-group-lg btn-success'],
                        ],
                    ],
                )
                ->submitButton()
                ->resetButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsGroupContainerAttributesWidgetValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div class="btn btn-group btn-group-lg btn-danger">
        <input type="submit" id="w1-submit" name="w1-submit"><input type="reset" id="w2-reset" name="w2-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->containerAttributes(['class' => 'btn btn-group btn-group-lg btn-danger'])
                ->defaultValues(
                    [
                        'buttons' => [
                            'containerAttributes' => ['class' => 'btn btn-group btn-group-lg btn-success'],
                        ],
                    ],
                )
                ->submitButton()
                ->resetButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsGroupContainerClassDefaultValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div class="btn btn-group btn-group-lg btn-success">
        <input type="submit" id="w1-submit" name="w1-submit"><input type="reset" id="w2-reset" name="w2-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'buttons' => [
                            'containerClass' => 'btn btn-group btn-group-lg btn-success',
                        ],
                    ],
                )
                ->submitButton()
                ->resetButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsGroupContainerClassWidgetValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div class="btn btn-group btn-group-lg btn-danger">
        <input type="submit" id="w1-submit" name="w1-submit"><input type="reset" id="w2-reset" name="w2-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->containerClass('btn btn-group btn-group-lg btn-danger')
                ->defaultValues(
                    [
                        'buttons' => [
                            'containerClass' => 'btn btn-group btn-group-lg btn-success',
                        ],
                    ],
                )
                ->submitButton()
                ->resetButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsGroupWithoutContainerDefaultValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <input type="submit" id="w1-submit" name="w1-submit"><input type="reset" id="w2-reset" name="w2-reset">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'buttons' => [
                            'container' => false,
                        ],
                    ],
                )
                ->submitButton()
                ->resetButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testButtonsGroupWithoutContainerWidgetValue(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);

        $expected = <<<HTML
        <div>
        <input type="submit" id="w1-submit" name="w1-submit"><input type="reset" id="w2-reset" name="w2-reset">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->container(true)
                ->defaultValues(
                    [
                        'buttons' => [
                            'container' => false,
                        ],
                    ],
                )
                ->submitButton()
                ->resetButton()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerAttributesDefaultValue(): void
    {
        $expected = <<<HTML
        <div class="text-left" style="color: red">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'containerAttributes' => ['class' => 'text-left', 'style' => 'color: red'],
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
    public function testContainerAttributesWidgetValue(): void
    {
        $expected = <<<HTML
        <div class="text-right" style="color: black">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'containerAttributes' => ['class' => 'text-left', 'style' => 'color: red'],
                        ],
                    ],
                )
                ->containerAttributes(['class' => 'text-right', 'style' => 'color: black'])
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerClassDefaultValue(): void
    {
        $expected = <<<HTML
        <div class="text-left">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'containerClass' => 'text-left',
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
    public function testContainerClassWidgetValue(): void
    {
        $expected = <<<HTML
        <div class="text-right">
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->containerClass('text-right')
                ->defaultValues(
                    [
                        'text' => [
                            'containerClass' => 'text-left',
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
    public function testErrorMessageDefaultValue(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $validator = $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" minlength="4" required>
        <div>Write your first name.</div>
        <span class="text-danger is-invalid">error-text</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'error' => 'error-text',
                            'errorAttributes' => ['class' => 'text-danger'],
                            'errorClass' => 'is-invalid',
                            'errorTag' => 'span',
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
    public function testErrorMessageWidgetValue(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $validator = $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" minlength="4" required>
        <div>Write your first name.</div>
        <p class="error-widget-class error-widget-class-1">error-widget-text</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'error' => 'error-text',
                            'errorAttributes' => ['class' => 'text-danger'],
                            'errorClass' => 'is-invalid',
                            'errorTag' => 'span',
                        ],
                    ],
                )
                ->error('error-widget-text')
                ->errorAttributes(['class' => 'error-widget-class'])
                ->errorClass('error-widget-class-1')
                ->errorTag('p')
                ->text($formModel, 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testErrorMessageCallbackDefaultValue(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $validator = $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" minlength="4" required>
        <div>Write your first name.</div>
        <span class="text-danger is-invalid">This is custom error message.</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'errorMessageCallback' => [$formModel, 'customError'],
                            'errorAttributes' => ['class' => 'text-danger'],
                            'errorClass' => 'is-invalid',
                            'errorTag' => 'span',
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
    public function testErrorMessageCallbackWidgetValue(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $validator = $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" name="PersonalForm[name]" minlength="4" required>
        <div>Write your first name.</div>
        <p class="error-widget-class error-widget-class-1">(&amp;#10006;) This is custom error message.</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'errorMessageCallback' => [$formModel, 'customError'],
                            'errorAttributes' => ['class' => 'text-danger'],
                            'errorClass' => 'is-invalid',
                            'errorTag' => 'span',
                        ],
                    ],
                )
                ->errorMessageCallBack([$formModel, 'customErrorWithIcon'])
                ->errorAttributes(['class' => 'error-widget-class'])
                ->errorClass('error-widget-class-1')
                ->errorTag('p')
                ->text($formModel, 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHintDefaultValue(): void
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
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'hint' => 'hint-text',
                            'hintAttributes' => ['class' => 'text-primary'],
                            'hintClass' => 'hint-class',
                            'hintTag' => 'span',
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
    public function testHintWidgetValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <p class="hint-widget-class hint-widget-class-1">hint-widget-text</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'hint' => 'hint-text',
                            'hintAttributes' => ['class' => 'text-primary'],
                            'hintClass' => 'hint-class',
                            'hintTag' => 'span',
                        ],
                    ],
                )
                ->hint('hint-widget-text')
                ->hintAttributes(['class' => 'hint-widget-class'])
                ->hintClass('hint-widget-class-1')
                ->hintTag('p')
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testInputClassDefaultValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="form-control" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'inputClass' => 'form-control',
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
    public function testInputClassWidgetValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" class="form-control-group" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'inputClass' => 'form-control',
                        ],
                    ],
                )
                ->inputClass('form-control-group')
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testInvalidClassErrorMessageDefaultValue(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $validator = $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="is-invalid" name="PersonalForm[name]" minlength="4" required>
        <div>Write your first name.</div>
        <div class="invalid-feedback">Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'errorClass' => 'invalid-feedback',
                            'invalidClass' => 'is-invalid',
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
    public function testInvalidClassErrorMessageWidgetValue(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => '']]);
        $validator = $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="invalid-tooltip" name="PersonalForm[name]" minlength="4" required>
        <div>Write your first name.</div>
        <div class="invalid-feedback">Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'errorClass' => 'invalid-feedback',
                            'invalidClass' => 'is-invalid',
                        ],
                    ],
                )
                ->invalidClass('invalid-tooltip')
                ->text($formModel, 'name')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelDefaultValue(): void
    {
        $expected = <<<HTML
        <div>
        <label class="text-primary label-class" for="typeform-string">label-text</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'label' => 'label-text',
                            'labelAttributes' => ['class' => 'text-primary'],
                            'labelClass' => 'label-class',
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
    public function testLabelWidgetValue(): void
    {
        $expected = <<<HTML
        <div>
        <label class="label-widget-class label-widget-class-1" for="typeform-string">label-widget-text</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'label' => 'label-text',
                            'labelAttributes' => ['class' => 'text-primary'],
                            'labelClass' => 'label-class',
                        ],
                    ],
                )
                ->label('label-widget-text')
                ->labelAttributes(['class' => 'label-widget-class'])
                ->labelClass('label-widget-class-1')
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholderDefaultValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" placeholder="placeholder-text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'placeholder' => 'placeholder-text',
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
    public function testPlaceholderWidgetValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]" placeholder="placeholder-widget-text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'placeholder' => 'placeholder-text',
                        ],
                    ],
                )
                ->placeholder('placeholder-widget-text')
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTemplateDefaultValue(): void
    {
        $expected = <<<HTML
        <div>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        <label for="typeform-string">String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'template' => "{input}\n{label}\n{hint}\n{error}",
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
    public function testTemplateWidgetValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'template' => "{input}\n{label}\n{hint}\n{error}",
                        ],
                    ],
                )
                ->template("{label}\n{input}\n{hint}\n{error}")
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValidClassErrorMessageDefaultValue(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => 'samdark']]);
        $validator = $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="is-valid" name="PersonalForm[name]" value="samdark" minlength="4" required>
        <div>Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'validClass' => 'is-valid',
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
    public function testValidClassErrorMessageWidgetValue(): void
    {
        $formModel = new PersonalForm();
        $formModel->load(['PersonalForm' => ['name' => 'samdark']]);
        $validator = $this->createValidatorMock()->validate($formModel);
        $expected = <<<HTML
        <div>
        <label for="personalform-name">Name</label>
        <input type="text" id="personalform-name" class="valid-tooltip" name="PersonalForm[name]" value="samdark" minlength="4" required>
        <div>Write your first name.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'invalidClass' => 'is-valid',
                        ],
                    ],
                )
                ->text($formModel, 'name')
                ->validClass('valid-tooltip')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutContainerDefaultValue(): void
    {
        $expected = <<<HTML
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->defaultValues(
                    [
                        'text' => [
                            'container' => false,
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
    public function testWithoutContainerWidgetValue(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <input type="text" id="typeform-string" name="TypeForm[string]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->container(true)
                ->defaultValues(
                    [
                        'text' => [
                            'container' => false,
                        ],
                    ],
                )
                ->text(new TypeForm(), 'string')
                ->render(),
        );
    }
}
