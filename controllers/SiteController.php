<?php

namespace app\controllers;

use app\models\ProxyCheck;
use app\models\ProxyLoadForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        /**
         * @var $model ProxyLoadForm
         */
        $model = new ProxyLoadForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->proxiesFile = UploadedFile::getInstance($model, 'proxiesFile');

            if ($model->upload()) {
                //File
                $proxies = $model->getProxiesFromFile();
            } else {
                //Text
                $proxies = $model->getProxiesFromText();
            }

            if (empty($proxies)) return false;

            /**
             * Добавляем прокси в общую базу
             * @var $ProxyCheck ProxyCheck
             */
            $ProxyCheck = Yii::$app->proxyService->addProxies($proxies);
//            echo '<pre>';
//            print_r($ProxyCheck);
//            print_r($ProxyCheck->getProxyCheckResults()->all());

            Yii::$app->session->setFlash('LoadFormSubmitted');

            return $this->redirect(['proxy-check/index','ProxyCheckResultSearch[check_id]'=>$ProxyCheck->id]);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
