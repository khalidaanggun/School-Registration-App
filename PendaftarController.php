<?php

class PendaftarController extends Controller
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
		//$id = Yii::app()->request->getParam('id_pendaftar');
		//$self = $this->getSelfAccess($id);
		return array(
			array('allow', // allow authenticated user to perform 'create', 'update', 'view' actions
				'actions'=>array('create','update','view','index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin', 'delete', 'index' actions
				'actions'=>array('admin','delete', 'export', 'view', 'update'),
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
		if(Yii::app()->user->isAdmin())
		{
			$this->render('view',array('model'=>$this->loadModel($id)));
		}
		
		$id=Yii::app()->user->getId();
		$pendaftar=Pendaftar::model()->findByAttributes(array('id_pendaftar' =>$id ));
		$info=InformasiPendaftar::model()->findByAttributes(array('id_pendaftar' =>$id ));
		$berkas=Berkas::model()->findByAttributes(array('id_pendaftar' =>$id ));

		if(Yii::app()->user->isPendaftar())
		{
			if($pendaftar==null)
			{
				$this->redirect(array('/pendaftar/create'));			
			
			}
			else
			{
				if($info==null)
				{
					$this->redirect(array('/informasiPendaftar/create'));			
				}
				else
				{
					if($berkas==null)
					{
						$this->redirect(array('/berkas/create'));			
					}
					else
					{
						$this->render('view',array('model'=>$this->loadModel($id)));		
					}
				}
			}
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

		$id=Yii::app()->user->getId();
		$modelP=Pendaftar::model()->findByAttributes(array('id_pendaftar' =>$id ));
		
		if($modelP!=null)
		{
			$this->redirect(array('pendaftar/update', 'id'=>$id));
		}

		else{
			$model=new Pendaftar;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

			if(isset($_POST['Pendaftar']))
			{
				$model->attributes=$_POST['Pendaftar'];
				$id = $model->id_pendaftar = Yii::app()->user->getId();
				$model->no_pendaftaran = $id;
				$model->foto=CUploadedFile::getInstance($model, 'foto');
				if($model->save())
				{	
					if(strlen($model->foto)>0)
						$model->foto->saveAs(Yii::app()->basePath.'/../foto/'.$model->foto);
					$this->redirect(array('/informasiPendaftar/create'));
				}
			}

			$this->render('create',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	
	public function actionUpdate($id)
	{	
		$model=$this->loadModel($id);
		$InformasiPendaftar = InformasiPendaftar::model()->findAll(array("condition"=>"id_pendaftar = $model->id_pendaftar"));
		if($InformasiPendaftar==null)
		{
			if(isset($_POST['Pendaftar']))
			{
				$model->attributes=$_POST['Pendaftar'];
				$model->foto=CUploadedFile::getInstance($model, 'foto');
				if($model->save())
				{
					if(strlen($model->foto)>0)
						$model->foto->saveAs(Yii::app()->basePath.'/../foto/'.$model->foto);
					$this->redirect(array('/informasiPendaftar/create'));
				}	
			}

			$this->render('update',array(
				'model'=>$model,
			));	
		}

		foreach($InformasiPendaftar as $a){
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
			if(isset($_POST['Pendaftar']))
			{
				$model->attributes=$_POST['Pendaftar'];
				$model->foto=CUploadedFile::getInstance($model, 'foto');
				if($model->save())
				{
					if(strlen($model->foto)>0){
						$model->foto->saveAs(Yii::app()->basePath.'/../foto/'.$model->foto);
					}
					Yii::app()->user->setFlash('success', "<br><br><h2><center><strong>Data diri anda berhasil disimpan!</strong></center></h2>");
					$this->redirect(array('/pendaftar/view','id'=>$a->id_info_pendaftar));
				}
			}

			$this->render('update',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model1 = $this->loadModel1($id);
		$model->delete();
		$model1->delete();
		$this->redirect(array('/pendaftar/admin'));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_GET['ajax']))
		//	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$id=Yii::app()->user->getId();
		$model = User::model()->findByAttributes(array ('id_user'=>$id));

		if($id==1){
			$dataProvider=new CActiveDataProvider('Pendaftar');
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
			));
		}
		
		if($id!=1){
			$model1 = Pendaftar::model()->findByAttributes(array ('id_pendaftar'=>$id));
			$model2 = InformasiPendaftar::model()->findByAttributes(array('id_pendaftar'=>$id));
			
				if($model2 == null){
					$this->redirect(array('/pendaftar/create'));
				}
				if($model2 != null){
					$this->redirect(array('/pendaftar/view','id'=>$id));
				}
			
		}
	}
	
	public function actionExport() {  

        $datareader = Pendaftar::model()->findAll();
        $hasil = array();

        $hasil[0] = array('nama' => 'Nama', 'no_induk' => 'Nomor Induk', 'jenjang' => 'Jenjang Pendaftaran', 'jenis_kelamin' => 'Jenis Kelamin', 'sekolah_asal' => 'Sekolah Asal', 'alamat_sekolah_asal' => 'Alamat Sekolah Asal', 'alamat_pendaftar' => 'Alamat Pendaftar', 'agama' => 'Agama', 'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir' => 'Tanggal Lahir', 'anak_ke' => 'Anak Ke', 'status_dlm_keluarga' => 'Status Dalam Keluarga', 'jml_saudara' => 'Jumlah Saudara');

        foreach ($datareader as $i => $row) {
            $hasil[$i + 1] = array(
                'nama' => $row->nama,
                'no_induk' => $row->no_induk,
                'jenjang' => $row->jenjang,
                'jenis_kelamin' => $row->jenis_kelamin,
				'sekolah_asal' => $row->sekolah_asal,
				'alamat_sekolah_asal' => $row->alamat_sekolah_asal,
				'alamat_pendaftar' => $row->alamat_pendaftar,
				'agama' => $row->agama,
                'tempat_lahir' => $row->tempat_lahir,
                'tanggal_lahir' => $row->tanggal_lahir,
                'anak_ke' => $row->anak_ke,
				'status_dlm_keluarga' => $row->status_dlm_keluarga,
				'jml_saudara' => $row->jml_saudara,
            );
        }

        $header = array(array('Rekap Pendaftar'));
        Yii::import('application.extensions.phpexcel.JPhpExcel');
        $xls = new JPhpExcel('UTF-8', false, 'pendaftar');
        $xls->addArray($header);
        $xls->addArray($hasil);
        $xls->generateXML('RekapPendaftar');
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pendaftar('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pendaftar']))
			$model->attributes=$_GET['Pendaftar'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pendaftar the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pendaftar::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pendaftar $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pendaftar-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function loadModel1($id){
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
?>