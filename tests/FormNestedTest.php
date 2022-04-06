<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use InvalidArgumentException;
use Yiisoft\Form\Tests\TestSupport\Form\Nested\DataSearchForm;
use PHPUnit\Framework\TestCase;

final class FormNestedTest extends TestCase
{
    public function loadDataProvider(): array
    {
        return [
            [
                'data' => [
                   'area' => [100, 200],
                   'price' => ['1000'],
                   'address' => [
                       'type_id' => 1,
                       'fiases' => [
                           'a2b487e8-b4db-11ec-b909-0242ac120002',
                           '21950189-d579-40c1-8768-010844f4e88d',
                        ],
                        'pageData' => [
                            'ids' => [1, 2, 5],
                            'page' => [
                                'source_ids' => 10
                            ]
                        ]
                    ],
                    'address.query' => 'some street name',
                    'address.pageData.fiases' => '2198a8fb-2dcb-4009-8b55-9799df9c6385',
                    'address.numbers.numbers' => [10, 40, 400],
                ],
                'expected' => [
                    'area' => [100, 200],
                    'price' => ['1000'],
                    'address.type_id' => 1,
                    'address.fiases' => [
                        'a2b487e8-b4db-11ec-b909-0242ac120002',
                        '21950189-d579-40c1-8768-010844f4e88d',
                    ],
                    'address.query' => 'some street name',
                    'address.pageData.ids' => [1, 2, 5],
                    'address.pageData.fiases' => [
                        '2198a8fb-2dcb-4009-8b55-9799df9c6385',
                    ],
                    'address.numbers.numbers' => [10, 40, 400],
                    'address.pageData.page.source_ids' => [10],
                ],
            ],
        ];
    }

    public function testGetAttributeHint(): void
    {
        $form = new DataSearchForm();

        //main
        $this->assertSame('ID of auction type', $form->getAttributeHint('auction_type_id'));

        //2st level
        $this->assertSame('ID of address type', $form->getAttributeHint('address', 'type_id'));
        $this->assertSame('Address name starts with...', $form->getAttributeHint('address', 'query'));
        $this->assertSame('ID of address type', $form->getAttributeHint('address.type_id'));
        $this->assertSame('Address name starts with...', $form->getAttributeHint('address.query'));

        //4th level
        $this->assertSame('IDs of sources', $form->getAttributeHint('address', 'pageData', 'page', 'source_ids'));
        $this->assertSame('IDs of urls', $form->getAttributeHint('address', 'pageData', 'page', 'url_ids'));
        $this->assertSame('IDs of sources', $form->getAttributeHint('address.pageData.page.source_ids'));
        $this->assertSame('IDs of urls', $form->getAttributeHint('address.pageData.page.url_ids'));
    }

    public function testGetAttributeLabel(): void
    {
        $form = new DataSearchForm();

        //main
        $this->assertSame('Auction type', $form->getAttributeLabel('auction_type_id'));
        $this->assertSame('Sources', $form->getAttributeLabel('source_ids'));

        //2th level
        $this->assertSame('FIAS numbers', $form->getAttributeLabel('address', 'fiases'));
        $this->assertSame('FIAS numbers', $form->getAttributeLabel('address.fiases'));

        //3th level
        $this->assertSame('Data ID', $form->getAttributeLabel('address', 'pageData', 'ids'));
        $this->assertSame('Data ID', $form->getAttributeLabel('address.pageData.ids'));

        //4th level
        $this->assertSame('Sources', $form->getAttributeLabel('address', 'pageData', 'page', 'source_ids'));
        $this->assertSame('Sources', $form->getAttributeLabel('address.pageData.page.source_ids'));
        $this->assertSame('URLs', $form->getAttributeLabel('address', 'pageData', 'page', 'url_ids'));
        $this->assertSame('URLs', $form->getAttributeLabel('address.pageData.page.url_ids'));
    }

    public function testGetAttributePlaceHolder(): void
    {
        $form = new DataSearchForm();

        //2th level
        $this->assertSame('Start typing FIAS number', $form->getAttributePlaceholder('address', 'fiases'));
        $this->assertSame('Start typing FIAS number', $form->getAttributePlaceholder('address.fiases'));

        //3th level
        $this->assertSame('Start typing number', $form->getAttributePlaceholder('address', 'numbers', 'numbers'));
        $this->assertSame('Start typing number', $form->getAttributePlaceholder('address.numbers.numbers'));

        //4th level
        $this->assertSame('Start typing source name', $form->getAttributePlaceholder('address', 'pageData', 'page', 'source_ids'));
        $this->assertSame('Start typing source name', $form->getAttributePlaceholder('address.pageData.page.source_ids'));
    }

    public function testGetAttributeValue(): void
    {
        $form = new DataSearchForm();

        //2th level
        $form->setAttribute('address.type_id', 10);
        $this->assertSame(10, $form->getAttributeValue('address', 'type_id'));
        $this->assertSame(10, $form->getAttributeValue('address.type_id'));

        //3th level
        $form->setAttribute('address.pageData.fiases', '123e4567-e89b-12d3-a456-426655440000');
        $this->assertSame(['123e4567-e89b-12d3-a456-426655440000'], $form->getAttributeValue('address', 'pageData', 'fiases'));
        $this->assertSame(['123e4567-e89b-12d3-a456-426655440000'], $form->getAttributeValue('address.pageData.fiases'));

        //4th level
        $form->setAttribute('address.pageData.page.source_ids', ['100', 200]);
        $this->assertSame([100, 200], $form->getAttributeValue('address', 'pageData', 'page', 'source_ids'));
        $this->assertSame([100, 200], $form->getAttributeValue('address.pageData.page.source_ids'));
    }

    public function testGetAttributeValueException(): void
    {
        $form = new DataSearchForm();
        $this->expectException(InvalidArgumentException::class);
        $form->getAttributeValue('noExist');
        $form->getAttributeValue('address', 'noExist');
        $form->getAttributeValue('address', 'pageData', 'noExist');
    }

    public function testHasAttribute(): void
    {
        $form = new DataSearchForm();

        $this->assertTrue($form->hasAttribute('address.pageData.fiases'));
        $this->assertTrue($form->hasAttribute('address', 'pageData', 'fiases'));
        $this->assertFalse($form->hasAttribute('address.pageData.notExists'));
        $this->assertFalse($form->hasAttribute('address', 'pageData', 'notExists'));
    }

    /**
     * @dataProvider loadDataProvider
     */
    public function testLoad(array $data, array $expected): void
    {
        $form = new DataSearchForm();
        $this->assertTrue($form->load($data, ''));

        foreach ($expected as $name => $value) {
            $this->assertSame($value, $form->getAttributeValue($name));
        }
    }
}
