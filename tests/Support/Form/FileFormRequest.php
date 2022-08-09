<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Form\FormRequest;
use Yiisoft\Form\Tests\TestSupport\Validator\ValidatorMock;

final class FileFormRequest extends FormRequest
{
    public function __construct(ServerRequestInterface $serverRequest)
    {
        parent::__construct(
            $serverRequest,
            new ValidatorMock(),
            new FileForm()
        );
    }
}
