<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\ExampleForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Fieldset;
use Yiisoft\Form\Widget\Form;

final class FieldsetTest extends TestCase
{
    use TestTrait;

    private array $state = [1 => 'Draft', 2 => 'In Progress', 3 => 'Done', 4 => 'Discarded'];

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame('<fieldset autofocus>', Fieldset::widget()->autofocus()->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAttributes(): void
    {
        $this->assertSame(
            '<fieldset class="test-class">',
            Fieldset::widget()->attributes(['class' => 'test-class'])->begin(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testClass(): void
    {
        $this->assertSame('<fieldset class="test-class">', Fieldset::widget()->class('test-class')->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame('<fieldset disabled>', Fieldset::widget()->disabled()->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame('<fieldset id="id-test">', Fieldset::widget()->id('id-test')->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $fieldset = Fieldset::widget();
        $this->assertNotSame($fieldset, $fieldset->attributes([]));
        $this->assertNotSame($fieldset, $fieldset->autofocus());
        $this->assertNotSame($fieldset, $fieldset->class(''));
        $this->assertNotSame($fieldset, $fieldset->disabled());
        $this->assertNotSame($fieldset, $fieldset->id(null));
        $this->assertNotSame($fieldset, $fieldset->legend(null));
        $this->assertNotSame($fieldset, $fieldset->legendAttributes([]));
        $this->assertNotSame($fieldset, $fieldset->name(null));
        $this->assertNotSame($fieldset, $fieldset->title(''));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame('<fieldset name="name-test">', Fieldset::widget()->name('name-test')->begin());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @link https://jsfiddle.net/6fz3nvLr/
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/pure-min.css" integrity="sha384-Uu6IeWbM+gzNVXJcM9XV3SohHtmWE+3VGi496jvgX1jyvDTXfdK+rfZc8C1Aehk5" crossorigin="anonymous">
        <div class="pure-g" style="position: absolute;top: 50%;left: 50%;transform:translate(-50%,-50%);">
        <div class="pure-u-5-5">
        <form class="pure-form" action="#" method="GET">
        <fieldset name="field-set-main">
        <legend>Create A Project</legend>
        <input type="text" id="exampleform-name" name="ExampleForm[name]" placeholder="name">
        <div>
        <input type="datetime-local" id="exampleform-start" name="ExampleForm[start]">
        <input type="datetime-local" id="exampleform-end" name="ExampleForm[end]">
        </div>
        </fieldset>
        <fieldset name="field-set-state">
        <legend>State</legend>
        <div>
        <div id="exampleform-state">
        <label><input type="radio" name="ExampleForm[state]" value="Draft"> Draft</label>
        <label><input type="radio" name="ExampleForm[state]" value="In Progress"> In Progress</label>
        <label><input type="radio" name="ExampleForm[state]" value="Done"> Done</label>
        <label><input type="radio" name="ExampleForm[state]" value="Discarded"> Discarded</label>
        </div>
        </div>
        </fieldset>
        <fieldset name="field-set-description">
        <legend>Description</legend>
        <textarea id="exampleform-description" name="ExampleForm[description]" rows="5" cols="50" placeholder="Write Description here.." style="width: 100%"></textarea>
        </fieldset>
        <fieldset name="field-set-control">
        <legend>Action</legend>
        <div>
        <input type="submit" id="w2-button" class="pure-button pure-button-primary" name="w2-button" value="Submit">
        <input type="submit" id="w3-button" class="pure-button pure-button-danger" name="w3-button" value="Cance;">
        </div>
        </fieldset>
        </form>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            '<link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/pure-min.css" integrity="sha384-Uu6IeWbM+gzNVXJcM9XV3SohHtmWE+3VGi496jvgX1jyvDTXfdK+rfZc8C1Aehk5" crossorigin="anonymous">' . PHP_EOL .
            '<div class="pure-g" style="position: absolute;top: 50%;left: 50%;transform:translate(-50%,-50%);">' . PHP_EOL .
            '<div class="pure-u-5-5">' . PHP_EOL .
            Form::widget()->action('#')->class('pure-form')->method('get')->begin() . PHP_EOL .
                Fieldset::widget()->legend('Create A Project')->name('field-set-main')->begin() . PHP_EOL .
                    Field::widget()
                        ->container(false)
                        ->label(null)
                        ->placeholder('name')
                        ->text(new ExampleForm(), 'name')
                        ->render() . PHP_EOL .
                    '<div>' . PHP_EOL .
                    Field::widget()
                        ->container(false)
                        ->dateTimeLocal(new ExampleForm(), 'start')
                        ->label(null)
                        ->render() . PHP_EOL .
                    Field::widget()
                        ->container(false)
                        ->dateTimeLocal(new ExampleForm(), 'end')
                        ->label(null)
                        ->render() . PHP_EOL .
                    '</div>' . PHP_EOL .
                Fieldset::end() .
                Fieldset::widget()->legend('State')->name('field-set-state')->begin() . PHP_EOL .
                    Field::widget()
                        ->label(null)
                        ->radioList(new ExampleForm(), 'state', ['itemsFromValues()' => [$this->state]])
                        ->render() . PHP_EOL .
                Fieldset::end() .
                Fieldset::widget()->legend('Description')->name('field-set-description')->begin() . PHP_EOL .
                    Field::widget()
                        ->attributes(['cols' => 50, 'rows' => 5, 'style' => 'width: 100%'])
                        ->container(false)
                        ->label(null)
                        ->placeholder('Write Description here..')
                        ->textArea(new ExampleForm(), 'description')
                        ->render() . PHP_EOL .
                Fieldset::end() .
                Fieldset::widget()->legend('Action')->name('field-set-control')->begin() . PHP_EOL .
                    Field::widget()
                        ->container(false)
                        ->buttonGroup(
                            [
                                ['label' => 'Submit', 'type' => 'submit'],
                                ['label' => 'Cance;', 'type' => 'submit'],
                            ],
                            [
                                'individualButtonAttributes()' => [
                                    [
                                        0 => ['class' => 'pure-button pure-button-primary'],
                                        1 => ['class' => 'pure-button pure-button-danger'],
                                    ],
                                ],
                            ],
                        ) . PHP_EOL .
                Fieldset::end() .
            Form::end() . PHP_EOL .
            '</div>' . PHP_EOL .
            '</div>',
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTitle(): void
    {
        $this->assertSame('<fieldset title="your title">', Fieldset::widget()->title('your title')->begin());
    }
}
