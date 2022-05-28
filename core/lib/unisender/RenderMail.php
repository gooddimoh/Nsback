<?php

namespace core\lib\unisender;

use Yii;

class RenderMail
{
    public static string $layout = "@mail/layouts/html.php";
    public static string $folder = "@mail/";

    public static function render($layout, array $params = [])
    {
        return Yii::$app->view->render(self::$layout, [
            'content' => Yii::$app->view->render(self::$folder . $layout, $params),
        ]);
    }

}