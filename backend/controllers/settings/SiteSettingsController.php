<?php

namespace backend\controllers\settings;

use common\rbac\Roles;
use core\forms\settings\CoinbaseSettingsForm;
use core\forms\settings\EnotSettingsForm;
use core\forms\settings\FreekassaSettingsForm;
use core\forms\settings\LavaSettingsForm;
use core\forms\settings\MainSettingsForm;
use core\forms\settings\QiwiInvoiceForm;
use core\forms\settings\WebMoneySettingsForm;
use core\forms\settings\PayeerSettingsForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use core\settings\SettingsAction;
use core\settings\SettingsStorage;

class SiteSettingsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMINISTRATOR],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'qiwi-invoice' => [
                'class' => SettingsAction::class,
                'modelClass' => QiwiInvoiceForm::class,
                'view' => 'qiwi-invoice',
                'section' => SettingsStorage::GROUP_QIWI_INVOICE,
            ],
            'web-money' => [
                'class' => SettingsAction::class,
                'modelClass' => WebMoneySettingsForm::class,
                'view' => 'web-money',
                'section' => SettingsStorage::GROUP_WEB_MONEY,
            ],
            'enot' => [
                'class' => SettingsAction::class,
                'modelClass' => EnotSettingsForm::class,
                'view' => 'enot',
                'section' => SettingsStorage::GROUP_ENOT,
            ],
            'freekassa' => [
                'class' => SettingsAction::class,
                'modelClass' => FreekassaSettingsForm::class,
                'view' => 'freekassa',
                'section' => SettingsStorage::GROUP_FREEKASSA,
            ],
            'coinbase' => [
                'class' => SettingsAction::class,
                'modelClass' => CoinbaseSettingsForm::class,
                'view' => 'coinbase',
                'section' => SettingsStorage::GROUP_COINBASE,
            ],
            'payeer' => [
                'class' => SettingsAction::class,
                'modelClass' => PayeerSettingsForm::class,
                'view' => 'payeer',
                'section' => SettingsStorage::GROUP_PAYEER,
            ],
            'lava' => [
                'class' => SettingsAction::class,
                'modelClass' => LavaSettingsForm::class,
                'view' => 'lava',
                'section' => SettingsStorage::GROUP_LAVA,
            ],
            'main' => [
                'class' => SettingsAction::class,
                'modelClass' => MainSettingsForm::class,
                'view' => 'main',
                'section' => SettingsStorage::GROUP_MAIN
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}