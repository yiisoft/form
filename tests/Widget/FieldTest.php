<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\AttributesValidatorForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Tests\TestSupport\Validator\ValidatorMock;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Widget\WidgetFactory;

final class FieldTest extends TestCase
{
    use TestTrait;

    private array $fieldConfig = [
        'errorClass()' => ['hasError'],
        'invalidClass()' => ['is-invalid'],
        'validClass()' => ['is-valid'],
    ];
    private AttributesValidatorForm $attributeValidatorForm;

    public function testAddAttributesEmailValidator(): void
    {
        // Validation error value.
        $this->formModel->setAttribute('email', '');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-email">Email</label>
        <input type="email" id="attributesvalidatorform-email" class="is-invalid" name="AttributesValidatorForm[email]" value maxlength="20" minlength="8" required>
        <div class="hasError">Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'email')->email()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('email', 'a.com');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-email">Email</label>
        <input type="email" id="attributesvalidatorform-email" class="is-invalid" name="AttributesValidatorForm[email]" value="a.com" maxlength="20" minlength="8" required>
        <div class="hasError">This value is not a valid email address.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'email')->email()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('email', 'a@a.com');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-email">Email</label>
        <input type="email" id="attributesvalidatorform-email" class="is-invalid" name="AttributesValidatorForm[email]" value="a@a.com" maxlength="20" minlength="8" required>
        <div class="hasError">Is too short.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'email')->email()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('email', 'awesomexample@example.com');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-email">Email</label>
        <input type="email" id="attributesvalidatorform-email" class="is-invalid" name="AttributesValidatorForm[email]" value="awesomexample@example.com" maxlength="20" minlength="8" required>
        <div class="hasError">Is too long.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'email')->email()->render(),
        );

        // Validation success value.
        $this->formModel->setAttribute('email', 'test@example.com');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-email">Email</label>
        <input type="email" id="attributesvalidatorform-email" class="is-valid" name="AttributesValidatorForm[email]" value="test@example.com" maxlength="20" minlength="8" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'email')->email()->render(),
        );
    }

    public function testAddAttributesNumberValidator(): void
    {
        // Validation error value.
        $this->formModel->setAttribute('number', '1');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-number">Number</label>
        <input type="number" id="attributesvalidatorform-number" class="is-invalid" name="AttributesValidatorForm[number]" value="1" required max="5" min="3">
        <div class="hasError">Is too small.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'number')->number()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('number', '6');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-number">Number</label>
        <input type="number" id="attributesvalidatorform-number" class="is-invalid" name="AttributesValidatorForm[number]" value="6" required max="5" min="3">
        <div class="hasError">Is too big.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'number')->number()->render(),
        );

        // Validation success value.
        $this->formModel->setAttribute('number', '4');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-number">Number</label>
        <input type="number" id="attributesvalidatorform-number" class="is-valid" name="AttributesValidatorForm[number]" value="4" required max="5" min="3">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'number')->number()->render(),
        );
    }

    public function testAddAttributesPasswordValidator(): void
    {
        // Validation error value.
        $this->formModel->setAttribute('password', '');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-password">Password</label>
        <input type="password" class="is-invalid" name="attributesvalidatorform-password" value maxlength="8" minlength="4" required pattern="^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{4,8}$">
        <div class="hasError">Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'password')->password()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('password', 't');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-password">Password</label>
        <input type="password" class="is-invalid" name="attributesvalidatorform-password" value="t" maxlength="8" minlength="4" required pattern="^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{4,8}$">
        <div class="hasError">Is too short.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'password')->password()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('password', '012345678');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-password">Password</label>
        <input type="password" class="is-invalid" name="attributesvalidatorform-password" value="012345678" maxlength="8" minlength="4" required pattern="^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{4,8}$">
        <div class="hasError">Is too long.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'password')->password()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('password', '12345');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-password">Password</label>
        <input type="password" class="is-invalid" name="attributesvalidatorform-password" value="12345" maxlength="8" minlength="4" required pattern="^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{4,8}$">
        <div class="hasError">Value is invalid.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'password')->password()->render(),
        );

        // Validation success value.
        $this->formModel->setAttribute('password', 'test1234');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-password">Password</label>
        <input type="password" class="is-valid" name="attributesvalidatorform-password" value="test1234" maxlength="8" minlength="4" required pattern="^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{4,8}$">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'password')->password()->render(),
        );
    }

    public function testAddAttributesTelephoneValidator(): void
    {
        // Validation error value.
        $this->formModel->setAttribute('telephone', '');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-telephone">Telephone</label>
        <input type="tel" id="attributesvalidatorform-telephone" class="is-invalid" name="AttributesValidatorForm[telephone]" value maxlength="16" minlength="8" required pattern="[^0-9+\(\)-]">
        <div class="hasError">Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'telephone')->telephone()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('telephone', '+56');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-telephone">Telephone</label>
        <input type="tel" id="attributesvalidatorform-telephone" class="is-invalid" name="AttributesValidatorForm[telephone]" value="+56" maxlength="16" minlength="8" required pattern="[^0-9+\(\)-]">
        <div class="hasError">Is too short.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'telephone')->telephone()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('telephone', '+56(999-999-99999)');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-telephone">Telephone</label>
        <input type="tel" id="attributesvalidatorform-telephone" class="is-invalid" name="AttributesValidatorForm[telephone]" value="+56(999-999-99999)" maxlength="16" minlength="8" required pattern="[^0-9+\(\)-]">
        <div class="hasError">Is too long.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'telephone')->telephone()->render(),
        );

        // Validation success value.
        $this->formModel->setAttribute('telephone', '+1 (999-999-999)');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-telephone">Telephone</label>
        <input type="tel" id="attributesvalidatorform-telephone" class="is-valid" name="AttributesValidatorForm[telephone]" value="+1 (999-999-999)" maxlength="16" minlength="8" required pattern="[^0-9+\(\)-]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'telephone')->telephone()->render(),
        );
    }

    public function testAddAttributesTextValidator(): void
    {
        // Validation error value.
        $this->formModel->setAttribute('text', '');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-text">Text</label>
        <input type="text" id="attributesvalidatorform-text" class="is-invalid" name="AttributesValidatorForm[text]" value maxlength="6" minlength="3" required>
        <div class="hasError">Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'text')->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('text', 'a');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-text">Text</label>
        <input type="text" id="attributesvalidatorform-text" class="is-invalid" name="AttributesValidatorForm[text]" value="a" maxlength="6" minlength="3" required>
        <div class="hasError">Is too short.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'text')->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('text', 'testsme');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-text">Text</label>
        <input type="text" id="attributesvalidatorform-text" class="is-invalid" name="AttributesValidatorForm[text]" value="testsme" maxlength="6" minlength="3" required>
        <div class="hasError">Is too long.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'text')->render(),
        );

        // Validation success value.
        $this->formModel->setAttribute('text', 'tests');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-text">Text</label>
        <input type="text" id="attributesvalidatorform-text" class="is-valid" name="AttributesValidatorForm[text]" value="tests" maxlength="6" minlength="3" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'text')->render(),
        );
    }

    public function testAddAttributesUrlValidator(): void
    {
        // Validation error value.
        $this->formModel->setAttribute('url', '');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-url">Url</label>
        <input type="url" id="attributesvalidatorform-url" class="is-invalid" name="AttributesValidatorForm[url]" value maxlength="20" minlength="15" required pattern="^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])">
        <div class="hasError">Value cannot be blank.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'url')->url()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('url', 'http://a.com');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-url">Url</label>
        <input type="url" id="attributesvalidatorform-url" class="is-invalid" name="AttributesValidatorForm[url]" value="http://a.com" maxlength="20" minlength="15" required pattern="^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])">
        <div class="hasError">Is too short.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'url')->url()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('url', 'http://awesomexample.com');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-url">Url</label>
        <input type="url" id="attributesvalidatorform-url" class="is-invalid" name="AttributesValidatorForm[url]" value="http://awesomexample.com" maxlength="20" minlength="15" required pattern="^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])">
        <div class="hasError">Is too long.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'url')->url()->render(),
        );

        // Validation error value.
        $this->formModel->setAttribute('url', 'awesomexample.com');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-url">Url</label>
        <input type="url" id="attributesvalidatorform-url" class="is-invalid" name="AttributesValidatorForm[url]" value="awesomexample.com" maxlength="20" minlength="15" required pattern="^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])">
        <div class="hasError">This value is not a valid URL.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'url')->url()->render(),
        );

        // Validation success value.
        $this->formModel->setAttribute('url', 'http://example.com');
        $validator = $this->createValidatorMock();
        $validator->validate($this->formModel);
        $expected = <<<'HTML'
        <div>
        <label for="attributesvalidatorform-url">Url</label>
        <input type="url" id="attributesvalidatorform-url" class="is-valid" name="AttributesValidatorForm[url]" value="http://example.com" maxlength="20" minlength="15" required pattern="^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget($this->fieldConfig)->config($this->formModel, 'url')->url()->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new AttributesValidatorForm();
    }

    private function createValidatorMock(): ValidatorInterface
    {
        return new ValidatorMock();
    }
}
