<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\CheckboxForm;
use Yiisoft\Form\Tests\Support\Form\CheckboxListForm;
use Yiisoft\Form\Tests\Support\Form\DateForm;
use Yiisoft\Form\Tests\Support\Form\DateTimeForm;
use Yiisoft\Form\Tests\Support\Form\DateTimeLocalForm;
use Yiisoft\Form\Tests\Support\Form\EmailForm;
use Yiisoft\Form\Tests\Support\Form\HiddenForm;
use Yiisoft\Form\Tests\Support\Form\NumberForm;
use Yiisoft\Form\Tests\Support\Form\PasswordForm;
use Yiisoft\Form\Tests\Support\Form\RangeForm;
use Yiisoft\Form\Tests\Support\Form\SelectForm;
use Yiisoft\Form\Tests\Support\Form\TelephoneForm;
use Yiisoft\Form\Tests\Support\Form\TextareaForm;
use Yiisoft\Form\Tests\Support\Form\TextForm;
use Yiisoft\Form\Tests\Support\Form\UrlForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testButton(): void
    {
        $result = Field::button()
            ->content('Show info')
            ->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="button">Show info</button>
            </div>
            HTML,
            $result
        );
    }

    public function testCheckbox(): void
    {
        $result = Field::checkbox(new CheckboxForm(), 'blue')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <input type="hidden" name="CheckboxForm[blue]" value="0"><label><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> Blue color</label>
            </div>
            HTML,
            $result
        );
    }

    public function testCheckboxList(): void
    {
        $result = Field::checkboxList(new CheckboxListForm(), 'color')
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->render();

        $expected = <<<'HTML'
        <div>
        <label>Select one or more colors</label>
        <div>
        <label><input type="checkbox" name="CheckboxListForm[color][]" value="red"> Red</label>
        <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue"> Blue</label>
        </div>
        <div>Color of box.</div>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testDate(): void
    {
        $result = Field::date(new DateForm(), 'birthday')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="dateform-birthday">Your birthday</label>
            <input type="date" id="dateform-birthday" name="DateForm[birthday]" value="1996-12-19">
            <div>Birthday date.</div>
            </div>
            HTML,
            $result
        );
    }

    public function testDateTime(): void
    {
        $result = Field::dateTime(new DateTimeForm(), 'partyDate')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="datetimeform-partydate">Date of party</label>
            <input type="datetime" id="datetimeform-partydate" name="DateTimeForm[partyDate]" value="2017-06-01T08:30">
            <div>Party date.</div>
            </div>
            HTML,
            $result
        );
    }

    public function testDateTimeLocal(): void
    {
        $result = Field::dateTimeLocal(new DateTimeLocalForm(), 'partyDate')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="datetimelocalform-partydate">Date of party</label>
            <input type="datetime-local" id="datetimelocalform-partydate" name="DateTimeLocalForm[partyDate]" value="2017-06-01T08:30">
            <div>Party date.</div>
            </div>
            HTML,
            $result
        );
    }

    public function testEmail(): void
    {
        $result = Field::email(new EmailForm(), 'main')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="emailform-main">Main email</label>
            <input type="email" id="emailform-main" name="EmailForm[main]" value>
            <div>Email for notifications.</div>
            </div>
            HTML,
            $result
        );
    }

    public function testHidden(): void
    {
        $result = Field::hidden(new HiddenForm(), 'key')->render();
        $this->assertSame(
            '<input type="hidden" id="hiddenform-key" name="HiddenForm[key]" value="x100">',
            $result
        );
    }

    public function testImage(): void
    {
        $result = Field::image()
            ->src('btn.png')
            ->alt('Go')
            ->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <input type="image" src="btn.png" alt="Go">
            </div>
            HTML,
            $result
        );
    }

    public function testNumber(): void
    {
        $result = Field::number(new NumberForm(), 'age')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="numberform-age">Your age</label>
            <input type="number" id="numberform-age" name="NumberForm[age]" value="42">
            <div>Full years.</div>
            </div>
            HTML,
            $result
        );
    }

    public function testPassword(): void
    {
        $result = Field::password(new PasswordForm(), 'old')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="passwordform-old">Old password</label>
            <input type="password" id="passwordform-old" name="PasswordForm[old]" value>
            <div>Enter your old password.</div>
            </div>
            HTML,
            $result
        );
    }

    public function testRange(): void
    {
        $result = Field::range(new RangeForm(), 'volume')
            ->min(1)
            ->max(100)
            ->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="rangeform-volume">Volume level</label>
            <input type="range" id="rangeform-volume" name="RangeForm[volume]" value="23" min="1" max="100">
            </div>
            HTML,
            $result
        );
    }

    public function testResetButton(): void
    {
        $result = Field::resetButton()
            ->content('Reset form')
            ->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="reset">Reset form</button>
            </div>
            HTML,
            $result
        );
    }

    public function testSelect(): void
    {
        $result = Field::select(new SelectForm(), 'number')
            ->optionsData([
                1 => 'One',
                2 => 'Two',
            ])
            ->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="selectform-number">Select number</label>
            <select name="SelectForm[number]">
            <option value="1">One</option>
            <option value="2">Two</option>
            </select>
            </div>
            HTML,
            $result
        );
    }

    public function testSubmitButton(): void
    {
        $result = Field::submitButton()
            ->content('Go!')
            ->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="submit">Go!</button>
            </div>
            HTML,
            $result
        );
    }

    public function testTelephone(): void
    {
        $result = Field::telephone(new TelephoneForm(), 'number')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="telephoneform-number">Phone</label>
            <input type="tel" id="telephoneform-number" name="TelephoneForm[number]" value>
            <div>Enter your phone.</div>
            </div>
            HTML,
            $result
        );
    }

    public function testText(): void
    {
        $result = Field::text(new TextForm(), 'job')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="textform-job">Job</label>
            <input type="text" id="textform-job" name="TextForm[job]" value>
            </div>
            HTML,
            $result
        );
    }

    public function testTextarea(): void
    {
        $result = Field::textarea(new TextareaForm(), 'desc')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="textareaform-desc">Description</label>
            <textarea id="textareaform-desc" name="TextareaForm[desc]"></textarea>
            </div>
            HTML,
            $result
        );
    }

    public function testUrl(): void
    {
        $result = Field::url(new UrlForm(), 'site')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="urlform-site">Your site</label>
            <input type="url" id="urlform-site" name="UrlForm[site]" value>
            <div>Enter your site URL.</div>
            </div>
            HTML,
            $result
        );
    }

    public function testLabel(): void
    {
        $result = Field::label(new TextForm(), 'job')->render();
        $this->assertSame('<label for="textform-job">Job</label>', $result);
    }

    public function testHint(): void
    {
        $result = Field::hint(TextForm::validated(), 'name')->render();
        $this->assertSame('<div>Input your full name.</div>', $result);
    }

    public function testError(): void
    {
        $result = Field::error(TextForm::validated(), 'name')->render();
        $this->assertSame('<div>Value cannot be blank.</div>', $result);
    }
}
