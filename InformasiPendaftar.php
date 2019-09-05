<?php

/**
 * This is the model class for table "informasi_pendaftar".
 *
 * The followings are the available columns in table 'informasi_pendaftar':
 * @property integer $id_pendaftar
 * @property integer $id_info_pendaftar
 * @property string $telepon
 * @property string $nama_ayah
 * @property string $pendidikan_ayah
 * @property string $pekerjaan_ayah
 * @property string $gaji_ayah
 * @property string $nama_ibu
 * @property string $pendidikan_ibu
 * @property string $pekerjaan_ibu
 * @property string $gaji_ibu
 * @property string $alamat_orangtua
 * @property string $nama_wali
 * @property string $pendidikan_wali
 * @property string $pekerjaan_wali
 * @property string $gaji_wali
 * @property string $alamat_wali
 * @property integer $status_form
 *
 * The followings are the available model relations:
 * @property Pendaftar $idPendaftar
 */
class InformasiPendaftar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasi_pendaftar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pendaftar, telepon, nama_ayah, nama_ibu, alamat_orangtua, pendidikan_ayah, pekerjaan_ayah, gaji_ayah, pendidikan_ibu, pekerjaan_ibu, gaji_ibu', 'required', 'message'=>'{attribute} Tidak Boleh Kosong'),
			array('id_pendaftar, telepon', 'numerical', 'integerOnly'=>true),
			array('telepon', 'length', 'max'=>20),
			array('nama_ayah, nama_ibu, nama_wali', 'length', 'max'=>100),
			array('nama_ayah, nama_ibu, pekerjaan_ayah, pekerjaan_ibu', 'ext.alpha'),
			array('alamat_orangtua', 'ext.alphanumeric', 'extra'=>array('.')),
			array('alamat_orangtua, alamat_wali', 'length', 'max'=>4000),
			array('pendidikan_ayah, pekerjaan_ayah, gaji_ayah, pendidikan_ibu, pekerjaan_ibu, gaji_ibu, pendidikan_wali, pekerjaan_wali, gaji_wali', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pendaftar, id_info_pendaftar, telepon, nama_ayah, pendidikan_ayah, pekerjaan_ayah, gaji_ayah, nama_ibu, pendidikan_ibu, pekerjaan_ibu, gaji_ibu, alamat_orangtua, nama_wali, pendidikan_wali, pekerjaan_wali, gaji_wali, alamat_wali', 'safe', 'on'=>'search'),
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
			'id_info_pendaftar' => 'Id Info Pendaftar',
			'telepon' => 'No Telepon Pendaftar',
			'nama_ayah' => 'Nama Ayah',
			'pendidikan_ayah' => 'Pendidikan Terakhir Ayah',
			'pekerjaan_ayah' => 'Pekerjaan Ayah',
			'gaji_ayah' => 'Gaji Ayah',
			'nama_ibu' => 'Nama Ibu',
			'pendidikan_ibu' => 'Pendidikan Terakhir Ibu',
			'pekerjaan_ibu' => 'Pekerjaan Ibu',
			'gaji_ibu' => 'Gaji Ibu',
			'alamat_orangtua' => 'Alamat Orangtua',
			'nama_wali' => 'Nama Wali',
			'pendidikan_wali' => 'Pendidikan Terakhir Wali',
			'pekerjaan_wali' => 'Pekerjaan Wali',
			'gaji_wali' => 'Gaji Wali',
			'alamat_wali' => 'Alamat Wali',
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
		$criteria->compare('id_info_pendaftar',$this->id_info_pendaftar);
		$criteria->compare('telepon',$this->telepon,true);
		$criteria->compare('nama_ayah',$this->nama_ayah,true);
		$criteria->compare('pendidikan_ayah',$this->pendidikan_ayah,true);
		$criteria->compare('pekerjaan_ayah',$this->pekerjaan_ayah,true);
		$criteria->compare('gaji_ayah',$this->gaji_ayah,true);
		$criteria->compare('nama_ibu',$this->nama_ibu,true);
		$criteria->compare('pendidikan_ibu',$this->pendidikan_ibu,true);
		$criteria->compare('pekerjaan_ibu',$this->pekerjaan_ibu,true);
		$criteria->compare('gaji_ibu',$this->gaji_ibu,true);
		$criteria->compare('alamat_orangtua',$this->alamat_orangtua,true);
		$criteria->compare('nama_wali',$this->nama_wali,true);
		$criteria->compare('pendidikan_wali',$this->pendidikan_wali,true);
		$criteria->compare('pekerjaan_wali',$this->pekerjaan_wali,true);
		$criteria->compare('gaji_wali',$this->gaji_wali,true);
		$criteria->compare('alamat_wali',$this->alamat_wali,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasiPendaftar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
