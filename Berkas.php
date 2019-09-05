<?php

/**
 * This is the model class for table "berkas".
 *
 * The followings are the available columns in table 'berkas':
 * @property integer $id_pendaftar
 * @property integer $id_berkas
 * @property integer $id_admin
 * @property string $kk
 * @property string $akte_lahir
 * @property string $ijazah
 * @property integer $status_berkas
 *
 * The followings are the available model relations:
 * @property Pendaftar $idPendaftar
 * @property Admin $idAdmin
 */
class Berkas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'berkas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pendaftar, ktp', 'required', 'message'=>'{attribute} Tidak Boleh Kosong'),
			array('id_pendaftar', 'numerical', 'integerOnly'=>true),
			array('ktp', 'file', 'types'=>'pdf, jpg, gif, png', 'allowEmpty'=>false, 'maxSize'=>5242880, 'wrongType'=>'Hanya file pdf, jpg, png, gif yang diperbolehkan', 'tooLarge'=>'Ukuran file terlalu besar! 5 MB maksimum!'),
			array('kk, akte_lahir, ijazah, nisn', 'file', 'types'=>'pdf, jpg, gif, png', 'allowEmpty'=>true, 'maxSize'=>5242880, 'wrongType'=>'Hanya file pdf, jpg, png, gif yang diperbolehkan', 'tooLarge'=>'Ukuran file terlalu besar! 5 MB maksimum!'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pendaftar, id_berkas, ktp, kk, akte_lahir, ijazah, nisn', 'safe', 'on'=>'search'),
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
			'idPendaftar' => array(self::BELONGS_TO, 'Pendaftar', 'id_pendaftar'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pendaftar' => 'Id Pendaftar',
			'id_berkas' => 'Id Berkas',
			'ktp' => 'Fotokopi KTP Orang Tua',
			'kk' => 'Kartu Keluarga',
			'akte_lahir' => 'Akte Kelahiran',
			'ijazah' => 'Ijazah/STK/SKHUN',
			'nisn' => 'Kartu NISN'
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

		$criteria=new CDbCriteria;

		$criteria->compare('id_pendaftar',$this->id_pendaftar);
		$criteria->compare('id_berkas',$this->id_berkas);
		$criteria->compare('ktp',$this->ktp,true);
		$criteria->compare('kk',$this->kk,true);
		$criteria->compare('akte_lahir',$this->akte_lahir,true);
		$criteria->compare('ijazah',$this->ijazah,true);
		$criteria->compare('nisn',$this->nisn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Berkas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
