<?php

/**
 * This is the model class for table "validasi".
 *
 * The followings are the available columns in table 'validasi':
 * @property integer $id_validasi
 * @property integer $no_pendaftaran
 * @property string $status_berkas
 * @property string $status_bayar
 * @property string $status_lulus
 *
 * The followings are the available model relations:
 * @property Pendaftar $noPendaftaran
 */
class Validasi extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'validasi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_pendaftaran, status_berkas, status_bayar, status_lulus', 'required'),
			array('no_pendaftaran', 'numerical', 'integerOnly'=>true),
			array('status_berkas, status_bayar, status_lulus', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_validasi, no_pendaftaran, status_berkas, status_bayar, status_lulus', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'noPendaftaran' => array(self::BELONGS_TO, 'Pendaftar', 'no_pendaftaran'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_validasi' => 'Id Validasi',
			'no_pendaftaran' => 'No Pendaftaran',
			'status_berkas' => 'Status Berkas',
			'status_bayar' => 'Status Bayar',
			'status_lulus' => 'Status Lulus',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		//$Pendaftar = Pendaftar::model()->findAll();
			
			$criteria=new CDbCriteria;

			$criteria->compare('id_validasi',$this->id_validasi);
			$criteria->compare('no_pendaftaran',$this->no_pendaftaran);
			//$criteria->compare('nama',$Pendaftar->nama,true);
			//$criteria->compare('jenjang',$Pendaftar->jenjang,true);
			$criteria->compare('status_berkas',$this->status_berkas,true);
			$criteria->compare('status_bayar',$this->status_bayar,true);
			$criteria->compare('status_lulus',$this->status_lulus,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
                'pageSize' => 10,
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Validasi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
