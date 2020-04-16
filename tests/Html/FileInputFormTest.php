<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\FileInputForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class FileInputFormTest extends TestCase
{
    public function testFileInputForm(): void
    {
        $form = new StubForm();

        $form->fieldFile('testme.doc');
        $expected = '<input type="hidden" name="foo" value=""><input type="file" id="stubform-fieldfile" name="foo" value="testme.doc">';
        $actual = FileInputForm::create($form, 'fieldFile', ['name' => 'foo']);
        $this->assertEqualsWithoutLE($expected, $actual);

        $form->fieldFile('testme.png');
        $expected = '<input type="hidden" name="foo" value="" disabled><input type="file" id="stubform-fieldfile" name="foo" value="testme.png" disabled>';
        $actual = FileInputForm::create($form, 'fieldFile', ['name' => 'foo', 'disabled' => true]);
        $this->assertEqualsWithoutLE($expected, $actual);

        $form->fieldFile('testme.jpg');
        $expected = '<input type="hidden" id="specific-id" name="foo" value=""><input type="file" id="stubform-fieldfile" name="foo" value="testme.jpg">';
        $actual = FileInputForm::create($form, 'fieldFile', ['name' => 'foo', 'hiddenOptions' => ['id' => 'specific-id']]);
        $this->assertEqualsWithoutLE($expected, $actual);

        $form->fieldFile('testme.bak');
        $expected = '<input type="hidden" id="specific-id" name="StubForm[fieldFile]" value=""><input type="file" id="stubform-fieldfile" name="StubForm[fieldFile]" value="testme.bak">';
        $actual = FileInputForm::create($form, 'fieldFile', ['hiddenOptions' => ['id' => 'specific-id']]);
        $this->assertEqualsWithoutLE($expected, $actual);

        $form->fieldFile('1.jpg');
        $expected = '<input type="hidden" name="StubForm[fieldFile]" value=""><input type="file" id="stubform-fieldfile" name="StubForm[fieldFile]" value="1.jpg">';
        $actual = FileInputForm::create($form, 'fieldFile', ['hiddenOptions' => []]);
        $this->assertEqualsWithoutLE($expected, $actual);

        $form->fieldFile('21.png');
        $expected = '<input type="hidden" name="foo" value=""><input type="file" id="stubform-fieldfile" name="foo" value="21.png">';
        $actual = FileInputForm::create($form, 'fieldFile', ['name' => 'foo', 'hiddenOptions' => []]);
        $this->assertEqualsWithoutLE($expected, $actual);
    }
}
