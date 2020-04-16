<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\Forms;
use Yiisoft\Form\Tests\TestCase;

final class FormsTest extends TestCase
{
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

    public function testBeginForm(): void
    {
        $this->assertEquals('<form action="/test" method="POST">', Forms::begin('/test'));
        $this->assertEquals('<form action="/example" method="GET">', Forms::begin('/example', 'GET'));

        $hiddens = [
            '<input type="hidden" name="id" value="1">',
            '<input type="hidden" name="title" value="&lt;">',
        ];
        $this->assertEquals(
            '<form action="/example" method="GET">' . "\n" . implode("\n", $hiddens),
            Forms::begin('/example?id=1&title=%3C', 'GET')
        );

        $expected = '<form action="/foo" method="GET">%A<input type="hidden" name="p" value="">';
        $actual = Forms::begin('/foo?p', 'GET');
        $this->assertStringMatchesFormat($expected, $actual);
    }

    /**
     * @dataProvider dataProviderBeginFormSimulateViaPost
     *
     * @param string $expected
     * @param string $method
     * @param array $options
     */
    public function testBeginFormSimulateViaPost(string $expected, string $method, array $options = []): void
    {
        $actual = Forms::begin('/foo', $method, $options);
        $this->assertStringMatchesFormat($expected, $actual);
    }

    public function testEndForm()
    {
        $this->assertEquals('</form>', Forms::end());
    }
}
