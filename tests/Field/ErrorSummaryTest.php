<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\ErrorSummary;
use Yiisoft\Form\ThemeContainer;

final class ErrorSummaryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public static function dataBase(): array
    {
        return [
            'empty' => ['', []],
            'simple' => [
                <<<HTML
                <div>
                <ul>
                <li>error1</li>
                <li>error2</li>
                <li>error3</li>
                </ul>
                </div>
                HTML,
                ['key' => ['error1'], 'name' => ['error2', 'error3'], 'age' => []],
            ],
            'unique' => [
                <<<HTML
                <div>
                <ul>
                <li>e1</li>
                <li>e2</li>
                <li>e3</li>
                </ul>
                </div>
                HTML,
                ['key' => ['e1'], 'name' => ['e1', 'e2'], 'age' => ['e3']],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expected, array $errors): void
    {
        $result = ErrorSummary::widget()->errors($errors)->render();
        $this->assertSame($expected, $result);
    }

    public function testOnlyFirst(): void
    {
        $errors = ['key' => ['error1'], 'name' => ['error2', 'error3'], 'age' => []];

        $result = ErrorSummary::widget()
            ->errors($errors)
            ->onlyFirst()
            ->render();

        $expected = <<<HTML
            <div>
            <ul>
            <li>error1</li>
            <li>error2</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testOnlyProperties(): void
    {
        $errors = ['key' => ['error1'], 'name' => ['error2', 'error3'], 'desc' => ['error4'], 'age' => []];

        $result = ErrorSummary::widget()
            ->errors($errors)
            ->onlyProperties('name', 'desc')
            ->render();

        $expected = <<<HTML
            <div>
            <ul>
            <li>error2</li>
            <li>error3</li>
            <li>error4</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testOnlyCommonErrors(): void
    {
        $errors = ['key' => ['error1'], '' => ['error2', 'error3'], 'desc' => ['error4'], 'age' => []];

        $result = ErrorSummary::widget()
            ->errors($errors)
            ->onlyCommonErrors()
            ->render();

        $expected = <<<HTML
            <div>
            <ul>
            <li>error2</li>
            <li>error3</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testHeader(): void
    {
        $errors = ['key' => ['error1', 'error2']];

        $result = ErrorSummary::widget()
            ->errors($errors)
            ->header('Hello >')
            ->headerAttributes(['class' => 'header'])
            ->render();

        $expected = <<<HTML
            <div>
            <div class="header">Hello &gt;</div>
            <ul>
            <li>error1</li>
            <li>error2</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testFooter(): void
    {
        $errors = ['key' => ['error1', 'error2']];

        $result = ErrorSummary::widget()
            ->errors($errors)
            ->footer('Hello >')
            ->footerAttributes(['class' => 'footer'])
            ->render();

        $expected = <<<HTML
            <div>
            <ul>
            <li>error1</li>
            <li>error2</li>
            </ul>
            <div class="footer">Hello &gt;</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testListAttributes(): void
    {
        $errors = ['key' => ['error1', 'error2']];

        $result = ErrorSummary::widget()
            ->errors($errors)
            ->listAttributes(['class' => 'list'])
            ->render();

        $expected = <<<HTML
            <div>
            <ul class="list">
            <li>error1</li>
            <li>error2</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testListClass(): void
    {
        $errors = ['key' => ['error1', 'error2']];

        $result = ErrorSummary::widget()
            ->errors($errors)
            ->listClass('list', 'mt-0')
            ->render();

        $expected = <<<HTML
            <div>
            <ul class="list mt-0">
            <li>error1</li>
            <li>error2</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddListClass(): void
    {
        $errors = ['key' => ['error1', 'error2']];

        $result = ErrorSummary::widget()
            ->errors($errors)
            ->listClass('list')
            ->addListClass('mt-0')
            ->render();

        $expected = <<<HTML
            <div>
            <ul class="list mt-0">
            <li>error1</li>
            <li>error2</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = ErrorSummary::widget();

        $this->assertNotSame($field, $field->errors([]));
        $this->assertNotSame($field, $field->encode(true));
        $this->assertNotSame($field, $field->onlyFirst());
        $this->assertNotSame($field, $field->onlyProperties());
        $this->assertNotSame($field, $field->onlyCommonErrors());
        $this->assertNotSame($field, $field->footer(''));
        $this->assertNotSame($field, $field->footerAttributes([]));
        $this->assertNotSame($field, $field->header(''));
        $this->assertNotSame($field, $field->headerAttributes([]));
        $this->assertNotSame($field, $field->listAttributes([]));
        $this->assertNotSame($field, $field->addListClass());
        $this->assertNotSame($field, $field->listClass());
    }
}
