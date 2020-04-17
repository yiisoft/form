<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\Forms;

final class FormsTest extends TestCase
{
    public function testBeginForm(): void
    {
        $expected = '<form action="/test" method="POST">';
        $created = Forms::begin()
            ->action('/test')
            ->start();
        $this->assertEquals($expected, $created);

        $expected = '<form action="/example" method="GET">';
        $created = Forms::begin()
            ->action('/example')
            ->method('GET')
            ->start();
        $this->assertEquals($expected, $created);

        $hiddens = [
            '<input type="hidden" name="id" value="1">',
            '<input type="hidden" name="title" value="&lt;">',
        ];
        $this->assertEquals(
            '<form action="/example" method="GET">' . "\n" . implode("\n", $hiddens),
            Forms::begin()->action('/example?id=1&title=%3C')->method('GET')->start()
        );

        $expected = '<form action="/foo" method="GET">%A<input type="hidden" name="p" value="">';
        $actual = Forms::begin()
            ->action('/foo?p')
            ->method('GET')
            ->start();
        $this->assertStringMatchesFormat($expected, $actual);
    }

    /**
     * Data provider for {@see testBeginFormSimulateViaPost()}.
     *
     * @return array test data
     */
    public function dataProviderBeginFormSimulateViaPost(): array
    {
        return [
            ['<form action="/foo" method="GET" _csrf="tokenCsrf">', 'GET',  ['_csrf' => 'tokenCsrf']],
            ['<form action="/foo" method="POST" _csrf="tokenCsrf">', 'POST', ['_csrf' => 'tokenCsrf']],
        ];
    }

    /**
     * @dataProvider dataProviderBeginFormSimulateViaPost
     *
     * @param string $expected
     * @param string $method
     * @param array $options
     *
     * @throws InvalidConfigException
     */
    public function testBeginFormSimulateViaPost(string $expected, string $method, array $options = []): void
    {
        $actual = Forms::begin()
            ->action('/foo')
            ->method($method)
            ->options($options)
            ->start();
        $this->assertStringMatchesFormat($expected, $actual);
    }

    public function testEndForm(): void
    {
        $this->assertEquals('</form>', Forms::end());
    }
}
