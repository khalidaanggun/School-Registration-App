<?php

class UserController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	public function accessRules() 
	{
		return array(
		array(	'allow', 'actions'=>array('view','index','register'),
				'users'=>array('*'), ),
		array(	'allow', 'actions'=>array('create','captcha'),
				'users'=>array('*'), ),
		array(	'allow', 'actions'=>array('update','view'), 
				'users'=>array('@'), ), 
		array(	'allow', 'actions'=>array('admin','index','delete'),
				'expression'=>'$user->isAdmin()'),
		array(	'deny', 
				'users'=>array('*'),),);
		
	}
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
		'captcha'=>array(
		'class'=>'CCaptchaAction', 
		'backColor'=>0xFFFFFF, ), );
	}
		
	public function actionCreate()
	{
		$model=new User('register'); 
		// Uncomment the following line if AJAX validation is needed 
		// $this->performAjaxValidation($model);
		if(isset($_POST['User'])) 
		{
			$model->attributes=$_POST['User']; 
			
			$dua=$model->password; 
			$model->saltPassword=$model->generateSalt();
			$model->password=$model->hashPassword($dua,$model->saltPassword); 
			$model->level_id=3; 
			$model->isActive=0; 
			$sss; 
				
			if($model->validate()) 
			{
				//Yii::app()->user->setFlash(success,'thank you');
				if ($model->passsword2 == $dua)
				{
					$model->save();
					$this->redirect(Yii::app()->user->loginUrl);
				}
				else
				{
					$this->redirect(Yii::app()->user->registerUrl);
				}
			}
		}
			$this->render('create',
			array( 'model'=>$model, ));
	}
	
	public function actionRegister() 
	{
		$model=new User('register'); 
		// Uncomment the following line if AJAX validation is needed 
		// $this->performAjaxValidation($model);
		if(isset($_POST['User'])) 
		{ 
 			$model->attributes=$_POST['User']; 
			$dua=$model->password; 
			$pass2 = $_POST['User']['password2'];
			$model->saltPassword=$model->generateSalt();
			$model->password=$model->hashPassword($dua,$model->saltPassword); 
			$model->level_id=3;  
			//$model->isActive=0; 
			$sss; 
				if($model->validate()) 
				{
					if ($pass2 == $dua){
						$model->save();
						Yii::app()->user->setFlash('success', '<br><br><h2><center><strong>Selamat! Akun berhasil dibuat. Silahkan login ke sistem dan Isi Formulir Pendaftaran!</br></br></h2></center></strong>');
						$this->redirect(Yii::app()->user->loginUrl);
					}else{
						Yii::app()->user->setFlash('register', '<strong><h4>Password tidak sesuai!</h4> Cek kembali password yang dimasukkan</strong>');
					}
				}
			}
			$this->render('register',
			array( 'model'=>$model, )); 
	}
	
}