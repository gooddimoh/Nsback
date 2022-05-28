<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= Html::encode($this->title) ?></title>
    <style type="text/css">
        html,
        body {padding: 0; margin: 0; line-height: 1.34; font-size:14px; font-family:'Arial', 'sans-serif';}
        table {line-height: 1.34; font-size:14px; font-family:'Arial', 'sans-serif';}
        @media all and (max-width: 600px){
            .mail-header,
            .mail-header > tbody,
            .mail-header > tbody > tr,
            .mail-header > tbody > tr > td {
                width: 100%; display: block; padding:0 !important; margin: 0; box-sizing: border-box;
            }
            .mail-header > tbody > tr > td.mail-header_logo {padding: 20px 10px 25px 10px !important; border-top: 5px solid #2b354e !important;}


            .mail-buttons,
            .mail-buttons > tbody,
            .mail-buttons > tbody > tr,
            .mail-buttons > tbody > tr > td {
                width: 100%; display: block; padding:0 !important; margin: 0; box-sizing: border-box;
            }
            .mail-buttons > tbody > tr {text-align: center;}
            .mail-buttons > tbody > tr > td {width: auto; display: inline-block; vertical-align: top; margin: 0 0 10px 0;}


            .mail-product_section {background-position: right bottom !important;}
            .mail-product,
            .mail-product > tbody,
            .mail-product > tbody > tr,
            .mail-product > tbody > tr > td {
                width: 100%; display: block; padding:0 !important; margin: 0; box-sizing: border-box;
            }
            .mail-product > tbody > tr > td {margin-bottom: 20px !important;}

            .mail-reivewbonus,
            .mail-reivewbonus > tbody,
            .mail-reivewbonus > tbody > tr,
            .mail-reivewbonus > tbody > tr > td {
                width: 100%; display: block; padding:0 !important; margin: 10px 0; text-align: center !important; box-sizing: border-box;
            }
            .mail-reivewbonus table td {text-align: center !important;}
            .mail-reivewbonus_image {text-align: center !important; margin: 20px auto 0 auto !important;}

            .mail-footer,
            .mail-footer > tbody,
            .mail-footer > tbody > tr,
            .mail-footer > tbody > tr > td {
                width: 100%; display: block; padding:0; margin: 10px 0; text-align: center !important; box-sizing: border-box;
            }
        }
    </style>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" style="width:100%;margin:0;padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top;font-size:14px;font-family:'Arial', 'sans-serif';">
        <tbody>
        <tr>
            <td border="0" cellpadding="0" cellspacing="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top;background:#e3e8fb;">
                <!-- CONTAINER -->
                <table width="1200" border="0" cellpadding="0" cellspacing="0" valign="top" style="width:100%;max-width:1200px;margin:0;margin-left:auto;margin-right:auto;padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top;">
                    <tbody>
                    <!-- HEADER -->
                    <tr>
                        <td border="0" cellpadding="0" cellspacing="0" valign="top" bgcolor="#2e3851" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top; background:#2e3851;color:#fff;">
                            <!-- HEADER INNER -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" style="width:100%;margin:0;margin-left:auto;margin-right:auto;padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top;" class="mail-header">
                                <tbody>
                                <tr>
                                    <td width="50%" border="0" cellpadding="0" cellspacing="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top;">
                                        <img width="100%" style="width: 100%; height:auto; vertical-align:top;display: block;" alt="" src="https://<?= Yii::$app->params['domain.value'] ?>/content/mail/1/bgs_header.jpg">
                                    </td>
                                    <td width="50%" border="0" cellpadding="0" cellspacing="0" valign="middle" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:middle;" class="mail-header_logo">
                                        <div style="width:290px;max-width:100%; margin:0 auto; text-align: left;">
                                            <img width="240" height="40" style="width: 240px; height: 40px; vertical-align: top;" alt="" src="https://<?= Yii::$app->params['domain.value'] ?>/content/mail/1/logo-white.png">
                                            <p style="margin:10px 0 0 0;color:#fff;">Спасибо, за Ваше доверие!</p>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- END - HEADER INNER -->
                        </td>
                    </tr>

                    <?= $content ?>

                    <!-- CONTENT TRHEE -->
                    <tr>
                        <td border="0" cellpadding="0" cellspacing="0" valign="top" style="padding:66px 0 70px 0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top;background:#ffffff;">

                            <table width="920" border="0" cellpadding="0" style="width:100%;max-width:920px;margin:0;margin-left:auto;margin-right:auto;padding:0;border:0;border-collapse:collapse;border-spacing:0;" class="mail-reivewbonus">
                                <tbody>
                                <tr>
                                    <td border="0" cellpadding="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top; padding-left: 10px; padding-right: 10px;">

                                        <h2 style="margin:0;font-weight:bold;font-size:32px;color:#000;">До 100 рублей за отзыв о магазине!</h2>
                                        <p style="margin:14px 0 0 0;font-size:16px;color:#000;">Оставь отзыв о нашем магазине и получи 100₽ на любой<br> из Ваших кошельков!</p>

                                        <table width="100%" border="0" cellpadding="0" style="width:100%;margin:0;margin-left:auto;margin-right:auto;padding:0;border:0;border-collapse:collapse;border-spacing:0;">
                                            <tbody>
                                            <tr>
                                                <td border="0" cellpadding="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top; text-align: left; padding-top: 40px; font-size: 18px;">
                                                    <a style="font-size:18px;color:#5374ff;text-decoration:none;" href="https://<?= Yii::$app->params['domain.value'] ?>/page/bonusy-za-otzyv">Оставить отзыв</a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                    <td width="225" border="0" cellpadding="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top; width: 225px; text-align: right;" class="mail-reivewbonus_image">
                                        <img width="225" height="176" style="width: 225px;height: 176px;" alt="" src="https://<?= Yii::$app->params['domain.value'] ?>/content/mail/1/review-money.png">
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>


                    <!-- FOOTER -->
                    <tr>
                        <td border="0" cellpadding="0" cellspacing="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top; padding-top:40px; padding-bottom:40px; background: #e3e8fb;text-align: center;">
                            <p style="margin: 0 0 30px 0; font-size: 16px;">Скидочный купон на 5% уже в нашем Telegram-канале</p>

                            <table border="0" cellpadding="0" style="width:auto;margin:0;margin-left:auto;margin-right:auto;padding:0;border:0;border-collapse:collapse;border-spacing:0;" class="mail-buttons">
                                <tbody>
                                <tr>
                                    <td border="0" cellpadding="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top;padding: 0 11px;">
                                        <a style="width:298px;height:72px;display:block;color:#fff;text-decoration:none;text-align: left;background:#5374ff;border-radius:12px;" href="<?= Yii::$app->params['content.telegram.channel'] ?>">
                                            <table width="298" height="72" border="0" cellpadding="0" style="width:298px;height:72px;margin:0;margin-left:auto;margin-right:auto;padding:0;border:0;border-collapse:collapse;border-spacing:0; background:#5374ff;border-radius:12px;">
                                                <tbody>
                                                <tr>
                                                    <td width="98" height="72" border="0" cellpadding="0" valign="middle" style="height:72px;padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:middle; width: 98px; text-align: center;">
                                                        <img width="50" height="42" style="width:50px;height:42px;" alt="" src="https://<?= Yii::$app->params['domain.value'] ?>/content/mail/1/icon-telegram.png">
                                                    </td>
                                                    <td height="72" border="0" cellpadding="0" valign="middle" style="height:72px;padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:middle;">
                                                        <div style="font-weight:bold;font-size:20px;color:#fff;">Канал в Telegram</div>
                                                        <div style="margin:5px 0 0 0; font-size:16px;color:#fff;">Скидки и акции</div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </a>
                                    </td>
                                    <td border="0" cellpadding="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top;padding: 0 11px;">
                                        <a style="width:298px;height:72px;display:block;color:#fff;text-decoration:none;text-align: left;background:#5374ff;border-radius:12px;" href="<?= Yii::$app->params['content.telegram.support'] ?>">
                                            <table width="298" height="72" border="0" cellpadding="0" style="width:298px;height:72px;margin:0;margin-left:auto;margin-right:auto;padding:0;border:0;border-collapse:collapse;border-spacing:0; background:#5374ff;border-radius:12px;">
                                                <tbody>
                                                <tr>
                                                    <td width="98" height="72" border="0" cellpadding="0" valign="middle" style="height:72px;padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:middle; width: 98px; text-align: center;">
                                                        <img width="50" height="42" style="width:50px;height:42px;" alt="" src="https://<?= Yii::$app->params['domain.value'] ?>/content/mail/1/icon-telegram.png">
                                                    </td>
                                                    <td height="72" border="0" cellpadding="0" valign="middle" style="height:72px;padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:middle;">
                                                        <div style="font-weight:bold;font-size:20px;color:#fff;">Поддержка</div>
                                                        <div style="margin:5px 0 0 0; font-size:16px;color:#fff;">Написать нам!</div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table width="100%" border="0" cellpadding="0" style="width:100%;margin:0;margin-left:auto;margin-right:auto;padding:0;border:0;border-collapse:collapse;border-spacing:0;">
                                <tbody>
                                <tr>
                                    <td border="0" cellpadding="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top; text-align: center; padding-top: 30px; font-size: 18px;">
                                        <a style="font-size:18px;color:#5374ff;text-decoration:none;" href="https://<?= Yii::$app->params['domain.value'] ?>/page/replacement">Замена</a>   |
                                        <a style="font-size:18px;color:#5374ff;text-decoration:none;" href="https://<?= Yii::$app->params['domain.value'] ?>/page/item-not-issued">Товар не выдан</a>   |
                                        <a style="font-size:18px;color:#5374ff;text-decoration:none;" href="https://<?= Yii::$app->params['domain.value'] ?>/page/rules">Правила магазина</a>   |
                                        <a style="font-size:18px;color:#5374ff;text-decoration:none;" href="https://<?= Yii::$app->params['domain.value'] ?>/page/support">Задать вопрос</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td border="0" cellpadding="0" cellspacing="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top; padding-top:20px; padding-bottom:20px;background:#ffffff;">
                            <table width="100%" border="0" cellpadding="0" style="width:100%;max-width:920px;margin:0;margin-left:auto;margin-right:auto;padding:0;border:0;border-collapse:collapse;border-spacing:0;" class="mail-footer">
                                <tbody>
                                <tr>
                                    <td border="0" cellpadding="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top;">
                                        <p style="margin:0;font-size:12px;color:#b0bbd5;">Письмо создано автоматически и не требует ответа</p>
                                        <p style="margin:5px 0 0 0;font-size:12px;color:#b0bbd5;">Будем рады видеть Вас снова в магазине <?= Yii::$app->params['domain.value'] ?></p>
                                    </td>
                                    <td border="0" cellpadding="0" valign="top" style="padding:0;border:0;border-collapse:collapse;border-spacing:0;vertical-align:top; text-align: right;">
                                        <img width="164" height="38" style="width: 164px; height: 38px; vertical-align: top;" alt="" src="https://<?= Yii::$app->params['domain.value'] ?>/content/mail/1/logo.png">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- END - CONTAINER -->

            </td>
        </tr>
        </tbody>
    </table>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
