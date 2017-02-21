<?php

namespace common\models;

use Yii;
use Yii\helpers\ArrayHelper;

/**
 * This is the model class for table "activity".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property integer $type
 * @property string $description
 * @property integer $category
 *
 * @property User $user
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'type', 'description'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['description', 'category'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'title' => 'Title',
            'type' => 'Type',
            'description' => 'Description',
            'category' => 'Category',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTypes()
    {
        $data = [
            ['id' => 0, 'title' => 'Active'],
            ['id' => 1, 'title' => 'Relaxed'],
            ['id' => 2, 'title' => 'Intensive'],
            ['id' => 3, 'title' => 'Thought'],
        ];

        return ArrayHelper::map($data, 'id', 'title');
    }

    public function getSingleType($type)
    {
        $array = Activity::getTypes();

        return $array[$type];
    }

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('activity_category', ['category_id' => 'id']);
    }
}
