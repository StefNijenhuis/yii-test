<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
      $auth = Yii::$app->authManager;

      // Category permissions
      // Add "manageCategory" permission
      $manageCategory = $auth->createPermission('manageCategory');
      $manageCategory->description = 'manage categories';
      $auth->add($manageCategory);

      // User permissions
      // Add "manageUsers" permission
      $manageUser = $auth->createPermission('manageUser');
      $manageUser->description = 'manage users';
      $auth->add($manageUser);

      // Activity permissions
      // Add "createActivity" permission
      $createActivity = $auth->createPermission('createActivity');
      $createActivity->description = 'create activity';
      $auth->add($createActivity);

      // add "updateOwnActivity" permission
      $updateOwnActivity = $auth->createPermission('updateOwnActivity');
      $updateOwnActivity->description = 'update own activity';
      $auth->add($updateOwnActivity);

      // Add "deleteOwnActivity" permission
      $deleteOwnActivity = $auth->createPermission('deleteOwnActivity');
      $deleteOwnActivity->description = 'delete own activity';
      $auth->add($deleteOwnActivity);

      // Add "manageActivity" permission
      $manageActivity = $auth->createPermission('manageActivity');
      $manageActivity->description = 'manage activities';
      $auth->add($manageActivity);
      $auth->addChild($manageActivity, $createActivity);
      $auth->addChild($manageActivity, $updateOwnActivity);
      $auth->addChild($manageActivity, $deleteOwnActivity);

      // Roles
      // Add "user" role and give this role the "createActivity" permission
      $user = $auth->createRole('user');
      $auth->add($user);
      $auth->addChild($user, $createActivity);
      $auth->addChild($user, $updateOwnActivity);
      $auth->addChild($user, $deleteOwnActivity);


      // Add "admin" role and give this role the "user" permissions
      // as well as the category permissions.
      $admin = $auth->createRole('admin');
      $auth->add($admin);
      $auth->addChild($admin, $user);
      $auth->addChild($admin, $manageCategory);
      $auth->addChild($admin, $manageActivity);

      // Assign roles to users.
      $auth->assign($user, 2);
      $auth->assign($admin, 1);
    }
}
