<?php

class BerkasController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create', 'update', 'view' actions
				'actions'=>array('create','update','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin', 'delete', 'index' actions
				'actions'=>array('admin','delete', 'index'),
				'expression'=>'$user->isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Berkas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Berkas']))
		{
			$model->attributes=$_POST['Berkas'];
			
			$id = $model->id_pendaftar = Yii::app()->user->getId();
			$model->id_berkas = $id;
			$model->id_pendaftar = Yii::app()->user->getId();
			$model->ktp=CUploadedFile::getInstance($model, 'ktp');
			$model->kk=CUploadedFile::getInstance($model, 'kk');
			$model->akte_lahir=CUploadedFile::getInstance($model, 'akte_lahir');
			$model->ijazah=CUploadedFile::getInstance($model, 'ijazah');
			$model->nisn=CUploadedFile::getInstance($model, 'nisn');
			if($model->save())
			{	
				if(strlen($model->ktp)>0)
				{
					$model->ktp->saveAs(Yii::app()->basePath.'/../berkas/ktp_ortu/'.$model->ktp);
					if($model->kk==null | $model->akte_lahir==null | $model->ijazah==null | $model->nisn==null)
					{

					}
					else
					{
						$model->kk->saveAs(Yii::app()->basePath.'/../berkas/kk/'.$model->kk);
						$model->akte_lahir->saveAs(Yii::app()->basePath.'/../berkas/akte/'.$model->akte_lahir);
						$model->ijazah->saveAs(Yii::app()->basePath.'/../berkas/ijazah_stk_skhun/'.$model->ijazah);
						$model->nisn->saveAs(Yii::app()->basePath.'/../berkas/kartu_nisn/'.$model->nisn);
					}
					
					$modelKartu= new KartuUjian;
					
						$modelKartu->id_pendaftar=Yii::app()->user->getId();
						$modelKartu->save();
					
					$modelValidasi= new Validasi;
					
						$modelValidasi->no_pendaftaran=Yii::app()->user->getId();
						$modelValidasi->status_berkas="Belum Divalidasi";
						$modelValidasi->status_bayar="Belum Lunas";
						$modelValidasi->status_lulus="Menunggu";
						$modelValidasi->save();
				}
					Yii::app()->user->setFlash('success', "<br><br><h2><center><strong>Data diri anda berhasil disimpan! Silahkan tunggu validasi dari Admin untuk mendapatkan Kartu Ujian Anda.</strong></center></h2>");
					$this->redirect(array('/pendaftar/view', 'id'=>$model->id_pendaftar));
			}
		}
		$this->render('create',array('model'=>$model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Berkas']))
		{
			$model->attributes=$_POST['Berkas'];
			$model->ktp=CUploadedFile::getInstance($model, 'ktp');
			$model->kk=CUploadedFile::getInstance($model, 'kk');
			$model->akte_lahir=CUploadedFile::getInstance($model, 'akte_lahir');
			$model->ijazah=CUploadedFile::getInstance($model, 'ijazah');
			$model->nisn=CUploadedFile::getInstance($model, 'nisn');
			if($model->save())
			{	

				if(strlen($model->ktp)>0)
					$model->ktp->saveAs(Yii::app()->basePath.'/../berkas/ktp_ortu/'.$model->ktp);
					if($model->kk==null | $model->akte_lahir==null | $model->ijazah==null | $model->nisn==null)
					{

					}
					else
					{
						$model->kk->saveAs(Yii::app()->basePath.'/../berkas/kk/'.$model->kk);
						$model->akte_lahir->saveAs(Yii::app()->basePath.'/../berkas/akte/'.$model->akte_lahir);
						$model->ijazah->saveAs(Yii::app()->basePath.'/../berkas/ijazah_stk_skhun/'.$model->ijazah);
						$model->nisn->saveAs(Yii::app()->basePath.'/../berkas/kartu_nisn/'.$model->nisn);
					}
				Yii::app()->user->setFlash('success', "<br><br><h2><center><strong>Data diri anda sukses disimpan!</strong></center></h2>");
				$this->redirect(array('/pendaftar/view', 'id'=>$model->id_pendaftar));
			}
		}

		$this->render('update',array('model'=>$model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Berkas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Berkas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Berkas']))
			$model->attributes=$_GET['Berkas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Berkas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Berkas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Berkas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='berkas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
