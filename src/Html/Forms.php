<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Http\Method;

final class Forms
{
    /**
     * Generates a form start tag.
     *
     * @param string $action the form action URL. This parameter will be processed.
     * @param string $method the form submission method, such as "post", "get", "put", "delete" (case-insensitive).
     * Since most browsers only support "post" and "get", if other methods are given, they will be simulated using
     * "post", and a hidden input will be added which contains the actual method type.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * If a value is null, the corresponding attribute will not be rendered.
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Special options:
     *
     *  - `csrf`: whether to generate the CSRF hidden input. Defaults to true.
     *
     * @return string the generated form start tag.
     *
     * {@see end())}
     */
    public static function begin(string $action = '', string $method = Method::POST, array $options = []): string
    {
        $hiddenInputs = [];

        $csrf = ArrayHelper::remove($options, 'csrf', false);

        if ($csrf && strcasecmp($method, Method::POST) === 0) {
            $hiddenInputs[] = Html::hiddenInput('_csrf', $csrf);
        }

        if (!strcasecmp($method, 'get') && ($pos = strpos($action, '?')) !== false) {
            /**
             * Query parameters in the action are ignored for GET method we use hidden fields to add them back.
             */
            foreach (explode('&', substr($action, $pos + 1)) as $pair) {
                if (($pos1 = strpos($pair, '=')) !== false) {
                    $hiddenInputs[] = Html::hiddenInput(
                        urldecode(substr($pair, 0, $pos1)),
                        urldecode(substr($pair, $pos1 + 1))
                    );
                } else {
                    $hiddenInputs[] = Html::hiddenInput(urldecode($pair), '');
                }
            }
            $action = substr($action, 0, $pos);
        }

        $options['action'] = $action;
        $options['method'] = $method;

        $form = Html::beginTag('form', $options);

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
    public static function end(): string
    {
        return '</form>';
    }
}
