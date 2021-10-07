<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\TestForm;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Yii\View\ViewRenderer;

final class SiteController
{
    private ViewRenderer $viewRenderer;

    public function __construct(ViewRenderer $viewRenderer)
    {
        $this->viewRenderer = $viewRenderer->withControllerName('site');
    }

    public function index(): ResponseInterface
    {
        return $this->viewRenderer->render('index');
    }

    public function widgets(TestForm $formModel, ServerRequestInterface $serverRequest): ResponseInterface
    {
        /** @var array $body */
        $body = $serverRequest->getParsedBody();
        $method = $serverRequest->getMethod();

        if ($method === 'POST' && $formModel->load($body)) {
            var_dump($formModel->active); // show value of active field.
        }

        return $this->viewRenderer->render('widgets', ['data' => $formModel]);
    }
}
