<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    if(!Yii::$app->user->isGuest) {
        $brandLabel = Yii::$app->user->identity->surname . ' ' . Yii::$app->user->identity->name . ' ' . Yii::$app->user->identity->patronymic;
    }
    else {
        $brandLabel = 'ПДАТУ';
    }

    NavBar::begin([
        'brandLabel' => $brandLabel,
        'brandUrl' => ['/site'],
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
        'innerContainerOptions'=>[
            'class'=>'container-fluid',
        ],
    ]);

    $item = [];
    if(Yii::$app->user->isGuest)
    {
        $item = [
            ['label' => 'Вхід', 'url' => ['/site/login']],
        ];
    }
    else {
        $item = [
            ['label' => 'Статистика', 'url' => ['/site/about']],
            ['label' => 'Налаштування', 'url' => ['/site/contact']],
            (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton('<b>Вийти</b>',['class' => 'btn btn-link logout'])
                . Html::endForm()
                . '</li>'
            ),
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $item,
    ]);
    NavBar::end();
    ?>

    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; TMV <?= date('Y');?></p>
        <p class="pull-right">
            <a href="<?=Url::to('https://sites.google.com/site/kafedraztdif/');?>">Кафедра фізики і загальнотехнічних дисциплін</a>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
