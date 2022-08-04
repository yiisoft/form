<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use ArrayAccess;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Psr\Http\Message\UploadedFileInterface;
use Yiisoft\Arrays\ArrayAccessTrait;

/**
 * The collection of upload files
 */
final class Files implements Countable, IteratorAggregate, ArrayAccess
{
    use ArrayAccessTrait;

    /**
     * @var UploadedFileInterface[]
     */
    public array $data;

    public function __construct(mixed $data)
    {
        if ($data instanceof UploadedFileInterface) {
            $this->data = [$data];
        } elseif (!is_array($data)) {
            throw new InvalidArgumentException('Data should contain array of uploaded files');
        } else {
            foreach ($data as $file) {
                if (!$file instanceof UploadedFileInterface) {
                    throw new InvalidArgumentException('Data should contain UploadedFileInterface objects only');
                }
            }
            /** @var UploadedFileInterface[] $data */
            $this->data = $data;
        }
    }
}
