<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use PHPUnit\Framework\Constraint\IsIdentical;
use PHPUnit\Framework\Constraint\StringContains;
use PHPUnit\Framework\ExpectationFailedException;

trait AssertTrait
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function assertStringContainsStringIgnoringLineEndings(
        string $needle,
        string $haystack,
        string $message = ''
    ): void {
        $needle = $this->normalizeLineEndings($needle);
        $haystack = $this->normalizeLineEndings($haystack);

        static::assertThat($haystack, new StringContains($needle, false), $message);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function assertStringEqualsStringIgnoringLineEndings(
        string $needle,
        string $haystack,
        string $message = ''
    ): void {
        $needle = $this->normalizeLineEndings($needle);
        $haystack = $this->normalizeLineEndings($haystack);

        static::assertThat($haystack, new IsIdentical($needle), $message);
    }

    private function normalizeLineEndings(string $value): string
    {
        return strtr($value, [
            "\r\n" => "\n",
            "\r" => "\n",
        ]);
    }
}
