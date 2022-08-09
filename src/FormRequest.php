<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Validator\ValidatorInterface;

/**
 * The abstraction for common case when using a form in a controller
 */
abstract class FormRequest
{
    private ?string $formName = null;
    private bool $isHandled = false;

    public function __construct(
        protected ServerRequestInterface $serverRequest,
        protected ValidatorInterface $validator,
        protected FormModel $formModel
    ) {
    }

    public function isValid(): bool
    {
        if (!$this->isHandled) {
            $this->handle();
        }
        return !$this->formModel()->getFormErrors()->hasErrors();
    }

    public function formModel(): FormModel
    {
        if (!$this->isHandled) {
            $this->handle();
        }
        return $this->formModel;
    }

    public function serverRequest(): ServerRequestInterface
    {
        return $this->serverRequest;
    }

    public function withFormName(string $formName): FormRequest
    {
        $new = clone $this;
        $new->formName = $formName;
        return $new;
    }

    private function handle(): void
    {
        if ($this->formModel->handleRequest($this->serverRequest, $this->formName)) {
            $this->validator->validate($this->formModel);
        }
        $this->isHandled = true;
    }
}

