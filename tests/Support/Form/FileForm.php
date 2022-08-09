<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\Files;
use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Required;

final class FileForm extends FormModel
{
    private ?string $name = null;
    private Files $avatar;
    private Files $image;
    private Files $photo;

    public function __construct()
    {
        $this->avatar = new Files([]);
        $this->image = new Files([]);
        $this->photo = new Files([]);
        parent::__construct();
    }

    public function getRules(): array
    {
        return [
            'name' => [new Required()],
            'image' => [new Required()],
            'photo' => [new Required(when: static fn () => false)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'avatar' => 'Avatar',
        ];
    }

    /**
     * @return \Yiisoft\Form\Files
     */
    public function getAvatars(): Files
    {
        return $this->avatar;
    }

    /**
     * @return \Yiisoft\Form\Files
     */
    public function getImages(): Files
    {
        return $this->image;
    }

    /**
     * @return \Yiisoft\Form\Files
     */
    public function getPhotos(): Files
    {
        return $this->photo;
    }
}
