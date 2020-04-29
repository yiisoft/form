<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Http\Method;
use Yiisoft\Widget\Widget;

use function explode;
use function implode;
use function strcasecmp;
use function strpos;
use function substr;
use function urldecode;

final class Form extends Widget
{
    private string $action;
    private string $method = Method::POST;
    private array $options = [];

    /**
     * Generates a form start tag.
     *
     * @return string the generated form start tag.
     *
     * {@see end())}
     */
    public function start(): string
    {
        $hiddenInputs = [];

        $csrf = ArrayHelper::remove($this->options, 'csrf', false);

        if ($csrf && strcasecmp($this->method, Method::POST) === 0) {
            $hiddenInputs[] = Html::hiddenInput('_csrf', $csrf);
        }

        if (!strcasecmp($this->method, 'get') && ($pos = strpos($this->action, '?')) !== false) {
            /**
             * Query parameters in the action are ignored for GET method we use hidden fields to add them back.
             */
            foreach (explode('&', substr($this->action, $pos + 1)) as $pair) {
                if (($pos1 = strpos($pair, '=')) !== false) {
                    $hiddenInputs[] = Html::hiddenInput(
                        urldecode(substr($pair, 0, $pos1)),
                        urldecode(substr($pair, $pos1 + 1))
                    );
                } else {
                    $hiddenInputs[] = Html::hiddenInput(urldecode($pair), '');
                }
            }

            $this->action = substr($this->action, 0, $pos);
        }

        $this->options['action'] = $this->action;
        $this->options['method'] = $this->method;

        $form = Html::beginTag('form', $this->options);

        if (!empty($hiddenInputs)) {
            $form .= "\n" . implode("\n", $hiddenInputs);
        }

        return $form;
    }

    /**
     * Generates a form end tag.
     *
     * @return string the generated tag.
     *
     * {@see beginForm()}
     */
    public function run(): string
    {
        return '</form>';
    }

    public function action(string $value): self
    {
        $new = clone $this;
        $new->action = $value;
        return $new;
    }

    public function method(string $value): self
    {
        $new = clone $this;
        $new->method = $value;
        return $new;
    }

    public function options(array $value = []): self
    {
        $new = clone $this;
        $new->options = $value;
        return $new;
    }
}
