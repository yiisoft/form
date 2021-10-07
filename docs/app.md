# Creating our application in yii3 basic concepts: 

1.- We define the routes of our controller.

```php
<?php

declare(strict_types=1);

use App\Controller\SiteController;
use Yiisoft\Router\Route;

return [
    // home page route
    Route::get('/')->action([SiteController::class, 'index'])->name('home'),
    // example page route
    Route::methods(['GET', 'POST'], '/widgets')->name('widgets')->action([SiteController::class, 'widgets']),
];
```

2.- We define the controller here we have an example of how to do it [SiteController](SiteController.php).
