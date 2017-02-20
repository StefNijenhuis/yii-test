<?php

namespace frontend\controllers;

use Yii;
use common\models\Activity;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\rbac\Rule;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ], [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['viewOwnActivity'],
                    ], [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['createActivity'],
                    ], [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['updateOwnActivity'],
                    ], [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteOwnActivity'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('manageActivity')) {
            $query = Activity::find()->indexBy('id');
        } else {
            $query = Activity::find()->where(['user_id' => Yii::$app->user->id])->indexBy('id');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Update in index
        if (Yii::$app->request->post('hasEditable')) {

            $activityId = Yii::$app->request->post('editableKey');
            $model = Activity::findOne($activityId);

            $out = Json::encode(['output' => '', 'message' =>'']);

            $posted = current($_POST['Activity']);
            $post = ['Activity' => $posted];

            if ($model->load($post)) {
                $model->save();
            }

            $output = '';

            if (isset($posted['type'])) {
                $output = Yii::$app->formatter->asDecimal($model->type, 2);
            }

            $out = Json::encode(['output' => $output, 'message' => '']);

            echo $out;
            return;
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Activity model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewOwnActivity') && $this->findModel($id)->user_id === Yii::$app->user->id) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            print_r("pech"); die();
        }
    }

    /**
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activity();

        // Get current user_id
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {

            // Convert checkboxList array into string to store in the DB
            $model->category = implode(', ', $model->category);

            // Get instance of the image
            $image = UploadedFile::getInstance($model, 'image');

            // Change the file name
            $model->image = $image->baseName . '_' . Yii::$app->security->generateRandomString() . '.' . $image->extension;

            if ($model->save()) {

                // Save image
                $image->saveAs('uploads/'. $model->image);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                print_r($model->getErrors()); die();
            }

        } else {

            // Convert string into array for the checkboxList
            $model->category = explode(',', $model->category);
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            // Convert checkboxList array into string to store in the DB
            $model->category = implode(', ', $model->category);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                print_r($model->getErrors()); die();
            }
        } else {

            // Convert string into array for the checkboxList
            $model->category = explode(',', $model->category);
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
