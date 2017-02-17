<?php

namespace common\models;

use Yii;
use Yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $category
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    public function listCategories()
    {
        $data = Category::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();

        return ArrayHelper::map($data, 'id', 'title');
    }

    public function getTitle($categories){
        $array = explode(',', $categories);

        foreach ($array as &$category) {
            $category = Category::findOne($category)->getAttribute('title');
        }

        unset($category);
        return implode(', ', $array);
    }
}
