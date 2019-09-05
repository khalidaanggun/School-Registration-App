<?php

class KartuUjianController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view','index','gagal', 'gagal2', 'gagal3'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'expression'=>'$user->isAdmin()',
				//'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new KartuUjian;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['KartuUjian']))
		{
			$model->attributes=$_POST['KartuUjian'];
			//$id = $model->id_pendaftar;
			//$model->id_kartu_ujian = $id;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_kartu_ujian));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['KartuUjian']))
		{
			$model->attributes=$_POST['KartuUjian'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_kartu_ujian));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
	public function actionGagal()
	{
		$this->render('viewGagal');
	}

	public function actionGagal2()
	{
		$this->render('viewGagal2');
	}

	public function actionGagal3()
	{
		$this->render('viewGagal3');
	}

	public function actionIndex()
	{
		$id=Yii::app()->user->getId();
		
		$model = KartuUjian::model()->findByAttributes(array ('id_pendaftar'=>$id));
		$modelPendaftar = Pendaftar::model()->findByAttributes(array('id_pendaftar'=>$id));
		$modelBerkas = Berkas::model()->findByAttributes(array('id_pendaftar'=>$id));
		$modelInfo = InformasiPendaftar::model()->findByAttributes(array('id_pendaftar'=>$id));
		$modelValidasi = Validasi::model()->findByAttributes(array('no_pendaftaran'=>$id));
		if($modelBerkas==null | $modelInfo==null | $modelPendaftar==null)
		{
			$this->redirect(array('KartuUjian/gagal'));
		}
		else if($modelValidasi->status_berkas=="Belum Divalidasi")
		{
			$this->redirect(array('KartuUjian/gagal2'));
		}

		else if($modelValidasi->status_berkas=="Tidak Valid")
		{
			$this->redirect(array('KartuUjian/gagal3'));
		}
		else
		{
			$mPDF1 = Yii::app()->ePdf->mpdf();
	 
	        # You can easily override default constructor's params
	        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');
	 
	        # render (full page)
	       // $mPDF1->WriteHTML($this->render('index', array(), true));
	 
	        # Load a stylesheet
	        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/styleKartu.css');
	        $mPDF1->WriteHTML($stylesheet, 1);
	 
	        # renderPartial (only 'view' of current controller)
	        //$mPDF1->WriteHTML("<br><br><br>$htmlTable");
			$mPDF1->WriteHTML($this->renderPartial('view', array('model'=>$model,), true));
	 
	        # Renders image
	        //$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
	 
	        # Outputs ready PDF
	        $mPDF1->Output();
			}
		}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new KartuUjian('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KartuUjian']))
			$model->attributes=$_GET['KartuUjian'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return KartuUjian the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=KartuUjian::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param KartuUjian $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='kartu-ujian-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}