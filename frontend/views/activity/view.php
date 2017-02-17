<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Category;
use common\models\Activity;

/* @var $this yii\web\View */
/* @var $model common\models\Activity */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => $model->user->username,
            ],
            'title',
            [
                'attribute' => 'type',
                'value' => Activity::getSingleType($model->type),
            ],
            'description:ntext',
            [
                'attribute' => 'category',
                'value' => Category::getTitle($model->category),
            ],
            [
                'attribute' => 'image',
                'value' => '/uploads/' . $model->image,
                'format' => 'image',
            ],
        ],
    ]) ?>

</div>
