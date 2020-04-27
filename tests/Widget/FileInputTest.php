<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\FileInput;

final class FileInputTest extends TestCase
{
    public function testFileInput(): void
    {
        $form = new StubForm();

        $form->fieldFile('testme.doc');
        $expected = '<input type="hidden" name="foo" value=""><input type="file" id="stubform-fieldfile" name="foo" value="testme.doc">';
        $created = FileInput::widget()
            ->config($form, 'fieldFile', ['name' => 'foo'])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $form->fieldFile('testme.png');
        $expected = '<input type="hidden" name="foo" value="" disabled><input type="file" id="stubform-fieldfile" name="foo" value="testme.png" disabled>';
        $created = FileInput::widget()
            ->config($form, 'fieldFile', ['name' => 'foo', 'disabled' => true])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $form->fieldFile('testme.jpg');
        $expected = '<input type="hidden" id="specific-id" name="foo" value=""><input type="file" id="stubform-fieldfile" name="foo" value="testme.jpg">';
        $created = FileInput::widget()
            ->config($form, 'fieldFile', ['name' => 'foo', 'hiddenOptions' => ['id' => 'specific-id']])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $form->fieldFile('testme.bak');
        $expected = '<input type="hidden" id="specific-id" name="StubForm[fieldFile]" value=""><input type="file" id="stubform-fieldfile" name="StubForm[fieldFile]" value="testme.bak">';
        $created = FileInput::widget()
            ->config($form, 'fieldFile', ['hiddenOptions' => ['id' => 'specific-id']])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $form->fieldFile('1.jpg');
        $expected = '<input type="hidden" name="StubForm[fieldFile]" value=""><input type="file" id="stubform-fieldfile" name="StubForm[fieldFile]" value="1.jpg">';
        $created = FileInput::widget()
            ->config($form, 'fieldFile', ['hiddenOptions' => []])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);

        $form->fieldFile('21.png');
        $expected = '<input type="hidden" name="foo" value=""><input type="file" id="stubform-fieldfile" name="foo" value="21.png">';
        $created = FileInput::widget()
            ->config($form, 'fieldFile', ['name' => 'foo', 'hiddenOptions' => []])
            ->run();
        $this->assertEqualsWithoutLE($expected, $created);
    }
}
