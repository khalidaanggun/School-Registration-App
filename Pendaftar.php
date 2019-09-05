<?php

/**
 * This is the model class for table "pendaftar".
 *
 * The followings are the available columns in table 'pendaftar':
 * @property integer $id_pendaftar
 * @property string $nama
 * @property string $no_induk
 * @property string $jenis_kelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $foto
 *
 * The followings are the available model relations:
 * @property Berkas[] $berkases
 * @property InformasiPendaftar[] $informasiPendaftars
 * @property User $idPendaftar
 * @property Pendaftaran $pendaftaran
 * @property Admin[] $admins
 */
class Pendaftar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pendaftar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pendaftar, no_pendaftaran, jenjang, nama, no_induk, jenis_kelamin, tempat_lahir, tanggal_lahir, foto, agama, alamat_pendaftar, anak_ke, jml_saudara, status_dlm_keluarga, sekolah_asal, alamat_sekolah_asal,', 'required','message'=>'{attribute} Tidak Boleh Kosong'),
			array('id_pendaftar, no_induk', 'numerical', 'integerOnly'=>true),
			array('nama, tempat_lahir, jenjang','length', 'max'=>40),
			array('no_induk', 'length', 'max'=>20),
			array('jenis_kelamin', 'length', 'max'=>20),
			array('sekolah_asal, alamat_sekolah_asal, alamat_pendaftar', 'ext.alphanumeric', 'extra'=>array('.')),
			array('alamat_sekolah_asal, alamat_pendaftar', 'length', 'max'=>500),
			array('sekolah_asal', 'length', 'max'=>100),
			array('anak_ke, jml_saudara', 'length', 'max'=>2),
			array('status_dlm_keluarga', 'length', 'max'=>15),
			array('foto', 'file', 'types'=>'jpg, gif, png', 'maxSize'=>2097152, 'wrongType'=>'Hanya file pdf, jpg, png, gif yang diperbolehkan', 'tooLarge'=>'Ukuran file terlalu besar! 2 MB maksimum!'),
			array('nama, tempat_lahir', 'ext.alpha'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pendaftar, no_pendaftaran, nama, no_induk, jenis_kelamin, tempat_lahir, tanggal_lahir, foto, agama, alamat_pendaftar, anak_ke, status_dlm_keluarga, jml_saudara', 'safe', 'on'=>'search'),
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
			'berkases' => array(self::HAS_MANY, 'Berkas', 'id_pendaftar'),
			'informasiPendaftars' => array(self::HAS_MANY, 'InformasiPendaftar', 'id_pendaftar'),
			'idPendaftar' => array(self::BELONGS_TO, 'User', 'id_pendaftar'),
			'pendaftaran' => array(self::HAS_ONE, 'Pendaftaran', 'id_pendaftar'),
			'noPendaftaran' => array(self::BELONGS_TO, 'Pendaftar', 'no_pendaftaran'),
			'admins' => array(self::MANY_MANY, 'Admin', 'pengelolaan_pendaftar(id_pendaftar, id_admin)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pendaftar' => 'Id Pendaftar',
			'no_pendaftaran' => 'No Pendaftaran',
			'jenjang' => 'Jenjang Pendaftaran',
			'nama' => 'Nama',
			'no_induk' => 'NISN',
			'jenis_kelamin' => 'Jenis Kelamin',
			'sekolah_asal' => 'Sekolah Asal',
			'alamat_sekolah_asal' => 'Alamat Sekolah Asal',
			'alamat_pendaftar' => 'Alamat Pendaftar',
			'agama' => 'Agama',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'anak_ke' => 'Anak Ke',
			'status_dlm_keluarga' => 'Status dalam Keluarga',
			'jml_saudara' => 'Jumlah Saudara Kandung',
			'foto' => 'Foto',
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
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		//$criteria->addSearchCondition('noPendaftaran.nama',$this->no_pendaftaran);
		//$criteria->with=array('noPendaftaran');
		//$criteria->addSearchCondition('noPendaftaran.jenjang',$this->no_pendaftaran);
		//$criteria->with=array('noPendaftaran');
		$criteria->compare('jenjang',$this->jenjang,true);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('no_induk',$this->no_induk,true);
		$criteria->compare('jenis_kelamin',$this->jenis_kelamin,true);
		$criteria->compare('sekolah_asal',$this->sekolah_asal,true);
		$criteria->compare('alamat_sekolah_asal',$this->alamat_sekolah_asal,true);
		$criteria->compare('alamat_pendaftar',$this->alamat_pendaftar,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('anak_ke',$this->anak_ke,true);
		$criteria->compare('status_dlm_keluarga',$this->status_dlm_keluarga,true);
		$criteria->compare('jml_saudara',$this->jml_saudara,true);
		$criteria->compare('foto',$this->foto,true);

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
	 * @return Pendaftar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
