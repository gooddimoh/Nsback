<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $model \core\entities\user\User */


$this->title = $model->getEncodedUsername();
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div>

        <div class="dropdown d-inline-block">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                Редактировать
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><?= Html::a('Логин/E-Mail', ['update', 'id' => $model->id]) ?></li>
                <li><?= Html::a('Пароль', ['change-password', 'id' => $model->id]) ?></li>
            </ul>
        </div>

        <div class="dropdown d-inline-block">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                Управление балансом
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><?= Html::a('Начислить', ['add-balance', 'id' => $model->id]) ?></li>
                <li><?= Html::a('Снять', ['write-off-balance', 'id' => $model->id]) ?></li>
            </ul>
        </div>
    </div>

    <div style="margin-top: 20px;">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'email',
                'balance',
                'created_at:dateTime',
                'updated_at:dateTime',
                'ip',
                'email_verified:boolean',
            ],
        ]) ?>
    </div>

</div>
