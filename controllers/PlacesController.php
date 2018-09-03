<?php

namespace app\controllers;

use app\models\Distance;
use phpDocumentor\Reflection\Types\Self_;
use Yii;
use app\models\Place;
use app\models\SearchPlace;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlacesController implements the CRUD actions for Place model.
 */
class PlacesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPlace();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//	    if($place = $searchModel::findOne(Yii::$app->request->get('SearchPlace')['id'])){
//	    	$place->createMultipleDistances();
//		    $this->redirect(\Yii::$app->urlManager->createUrl(['distance/index', 'SearchDistance[from_id]'=> $place->id]));
//	    }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	/**
	 * Lists all Place models.
	 * @return mixed
	 */
	public function actionCalculate()
	{
		$searchModel = new SearchPlace();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	    if($place = $searchModel::findOne(Yii::$app->request->get('id'))){
	    	$place->createMultipleDistances();
		    $this->redirect(\Yii::$app->urlManager->createUrl(['distance/index', 'SearchDistance[from_id]'=> $place->id]));
	    }

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

    /**
     * Displays a single Place model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Place model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Place();
	    if ($model->load(Yii::$app->request->post()) && $model->save()) {
		    $model->createSingleDistance();
		    return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Place model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Place model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Place model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Place the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Place::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
