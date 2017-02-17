<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Activity;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Activity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
        $gridColumns = [
        [ 'class' => 'kartik\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'title',
            'pageSummary' => true,
        ], [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'user_id',
            'label' => 'User',
            'value' => function ($model, $index, $widget) {
                return $model->user->username;
            },
            'pageSummary' => true,
        ], [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'type',
            'pageSummary' => true,
            'value' => function ($model, $index, $widget) {
                return Activity::getSingleType($model->type);
            },
            'editableOptions' => [
                'header' => 'Type',
                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                'data' => Activity::getTypes(),
                'size' => 'md'
            ],
        ], [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'description',
            'pageSummary' => true,
        ], [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'category',
            'pageSummary' => true,
            'value' => function ($model, $index, $widget) {
                return Category::getTitle($model->category);
            },
        ], [
            'class' => 'kartik\grid\ActionColumn'
        ]
        ];

        echo \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
        ]);

    ?>
</div>
