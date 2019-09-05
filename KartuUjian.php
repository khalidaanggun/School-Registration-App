<?php

/**
 * This is the model class for table "kartu_ujian".
 *
 * The followings are the available columns in table 'kartu_ujian':
 * @property integer $id_pendaftar
 * @property integer $id_kartu_ujian
 *
 * The followings are the available model relations:
 * @property Pendaftar $idPendaftar
 * @property Pendaftaran[] $pendaftarans
 * @property Pendaftaran[] $pendaftarans1
 */
class KartuUjian extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kartu_ujian';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pendaftar', 'required'),
			array('id_pendaftar', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pendaftar, id_kartu_ujian', 'safe', 'on'=>'search'),
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
			'pendaftarans' => array(self::HAS_MANY, 'Pendaftaran', 'id_kartu'),
			'pendaftarans1' => array(self::HAS_MANY, 'Pendaftaran', 'id_kartu_ujian'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pendaftar' => 'No Pendaftaran',
			'id_kartu_ujian' => 'No Pendaftaran',
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
		$criteria->compare('id_kartu_ujian',$this->id_kartu_ujian);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KartuUjian the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
