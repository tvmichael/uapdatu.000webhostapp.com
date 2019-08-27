<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
                        'class' => AccessControl::className(),
                        //'only' => ['index', 'view'], // До яких дій застосувати правила доступу - 'rules'
                        'rules' => [
                            [
                                'allow' => true,
                                'roles' => ['admin'],
                            ],
                            /*[
                                'allow' => true,
                                'actions' => ['view'],
                                'roles' => ['?', '@'],
                            ],*/
                        ],
                    ];

        $behaviors['verbs'] = [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ];

        return $behaviors;
    }


    /**
     * Дія при винекненні помилки
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id = 1)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }










    /* -- ПРАВА І РОЛІ КОРИСТУВАЧІВ --------------------------------------------------------------------------------- */
    /**
     * Встановлюємо ролі користувачів в файлах (варіант для малої кількості користувачів)
     * 'class' => 'yii\rbac\PhpManager'
     * {@inheritdoc}
     */
    public function actionRbacPhp()
    {
        /*
        echo '<p>actionsRb-1</p><pre>';
        $auth = Yii::$app->authManager;

        // ДОЗВОЛИ ------------------------------------------------------------
        // добавляем разрешение "editBase"
        $editBase = $auth->createPermission('editBase');
        $editBase->description = 'Редагувати базу даних сайту';
        $auth->add($editBase);

        // добавляем разрешение "createBd"
        $createBd = $auth->createPermission('createBd');
        $createBd->description = 'Створювати базу даних наукової діяльності';
        $auth->add($createBd);

        // добавляем разрешение "updatePost"
        $updateBd = $auth->createPermission('updateBb');
        $updateBd->description = 'Редагувати базу даних наукової діяльності';
        $auth->add($updateBd);

        // добавляем разрешение "revisionBd"
        $revisionBd = $auth->createPermission('revisionBd');
        $revisionBd->description = 'Перглядати базу даних наукової діяльності користувачів';
        $auth->add($revisionBd);


        // РОЛИ ----------------------------------------------------------------
        // добавляем роль "user" и даём роли разрешение "createBd"
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createBd);
        $auth->addChild($user, $updateBd);

        // добавляем роль "manager" и даём роли разрешение "createBd"
        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $revisionBd);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createBd);
        $auth->addChild($admin, $updateBd);
        $auth->addChild($admin, $manager);
        $auth->addChild($admin, $editBase);

        // ----------------------------------------------------------------------
        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($manager, 2);
        $auth->assign($admin, 1);

        echo '</pre><p>actionsRb-2</p>';
        */
    }
    /**
     * Встановлюємо ролі користувачів в базу даних
     * 'class' => 'yii\rbac\DbManager'
     * {@inheritdoc}
     */
    public function actionDb()
    {
        echo '<pre> actionRbacDb:start<br>';

        // РОЛІ -------------
        /*
        echo '1.role.';
        $admin = Yii::$app->authManager->createRole('admin');
        $admin->description = 'Адміністратор (повний доступ)';
        Yii::$app->authManager->add($admin);
        //
        $manager = Yii::$app->authManager->createRole('manager');
        $manager->description = 'Менеджер сайту (доступ для перегляду даних користувачів)';
        Yii::$app->authManager->add($manager);
        //
        $user = Yii::$app->authManager->createRole('user');
        $user->description = 'Менеджер сайту (доступ для перегляду даних користувачів)';
        Yii::$app->authManager->add($user);
        */

        // ПРАВА ------------
        /*echo '2.role.';
        $createRa = Yii::$app->authManager->createPermission('canUser'); // scientific activity
        $createRa->description = 'Право на створення каталогу наукової діяльності (research activities)';
        Yii::$app->authManager->add($createRa);
        //
        $editDb = Yii::$app->authManager->createPermission('canAdmin');
        $editDb->description = 'Право на редагування бази даних (для адміністратора)';
        Yii::$app->authManager->add($editDb);
        //
        $managerRa = Yii::$app->authManager->createPermission('canManager');
        $managerRa->description = 'Право на перегляд каталогу наукової діяльності користувачів (research activities)';
        Yii::$app->authManager->add($managerRa);
        */

        /*
        echo '3.role.';
        $role_a = Yii::$app->authManager->getRole('admin');
        $role_m = Yii::$app->authManager->getRole('manager');
        $role_u = Yii::$app->authManager->getRole('user');

        $permit_a = Yii::$app->authManager->getPermission('canAdmin');
        $permit_m = Yii::$app->authManager->getPermission('canManager');
        $permit_u = Yii::$app->authManager->getPermission('canUser');

        Yii::$app->authManager->addChild($role_a, $permit_a);
        Yii::$app->authManager->addChild($role_m, $permit_a);
        Yii::$app->authManager->addChild($role_u, $permit_a);

        Yii::$app->authManager->addChild($role_m, $permit_m);
        Yii::$app->authManager->addChild($role_u, $permit_u);
        */

        /*
        echo '4.role.';
        $userRole = Yii::$app->authManager->getRole('user');
        Yii::$app->authManager->assign($userRole, 2);
        */

        echo '<br>actionRbacDb:end</pre> ';
    }
}
