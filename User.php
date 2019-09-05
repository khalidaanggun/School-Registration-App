<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id_user
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $id_level
 * @property string $saltPassword
 *
 * The followings are the available model relations:
 * @property Admin $admin
 * @property Pendaftar $pendaftar
 */
class User extends CActiveRecord
{
public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	public $password2; 
	public $verifyCode;

	/**
		 * @return array validation rules for model attributes.
	 */
	public function rules()
	 { return array
		( 
		array('username, email, password, password2, verifyCode','required','message'=>'{attribute} Tidak Boleh Kosong'),
		array('username', 'length', 'max'=>20),
		array('username', 'ext.alphanumeric'),
		array('password, password2', 'ext.alphanumeric'),
		array('username','unique','on'=>'updateuser'),
		array('username, email','unique','caseSensitive'=>true, 'allowEmpty'=>true ), 
		array('password2','required', 'on'=>'register'),
		array('password, password2, saltPassword, email', 'length', 'min'=>6), 
		array('email', 'email'),
		array('verifyCode', 'captcha', 'allowEmpty'=>!extension_loaded('gd')),	
		array('level_id', 'numerical', 'integerOnly'=>true), 
		array('id, username, password, saltPassword, joinDate, level_id, isActive', 'safe', 'on'=>'search'), 
		);
	}
	
	public function validatePassword($password) {
			return $this->hashPassword($password,$this->saltPassword)===$this->password; 
	}
	public function hashPassword($password,$salt) {
			return md5($salt.$password); 
	} 
	public function generateSalt() {
			return uniqid('',true); 
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'admin' => array(self::HAS_ONE, 'Admin', 'id_admin'),
			'pendaftar' => array(self::HAS_ONE, 'Pendaftar', 'id_pendaftar'),
		);
	}

	public function getFullName() {
    	return $this->username;
	}

	public function getSuggest($q) {
	    $c = new CDbCriteria();
	    $c->addSearchCondition('username', $q, true, 'OR');
	    $c->addSearchCondition('email', $q, true, 'OR');
	    return $this->findAll($c);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_user' => 'Id_User',
			'username' => 'Username',
			'password' => 'Password',
			'level_id'=> 'Level_id',
			'password2' => 'Ulangi Password Anda',
			'verifyCode' => 'Kode Verifikasi'
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

		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('level_id',$this->level_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}