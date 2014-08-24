<?php
App::uses('AppModel', 'Model');

class User extends AppModel{
	public $name = 'User';
	public $belongsTo = array('Group');
	public $actsAs = array('Acl'=>'requester');
	public $validate = array(
		'name' => array('Sólo letras permitidas'=>'/[a-z]$/i'),
		'username' => array(
			'notEmpty' => array(
				'rule'=>'notEmpty',
				'message' => 'Ingrese su nombre de usuario',
				'last' => true
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Este nombre de usuario ya está ocupado, cámbielo',
				'last' => true
			),
			'between' => array(
				'rule' => array('between', 4, 20),
				'message' => 'Entre 4 y 20 caracteres'
			)
		),
		'group_id' => 'notEmpty',
		'email' => array(
			'notEmpty' => array(
				'rule'=>'notEmpty',
				'message' => 'Ingrese su correo electrónico',
				'last' => true
			),
			 'email' => array(
				'rule' => 'email',
				'message' => 'Por favor indique una dirección de correo electrónico válida.',
				'last' => true
			 ),
			 'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Este correo electrónico ya está registrado!'
			 )
		),
		'password' => array(
			'notEmpty' => array(
				'rule'=>'notEmpty',
				'message' => 'Ingrese su contraseña',
				'last' => true
			),
			'minLength' => array(
				'rule' => array('minLength', 6),
				'message' => 'Su contraseña debe tener por lo menos 6 caracteres'
			)
		),
		'password_confirm' => array (
			'required' => array (
				'rule' => array('minLength', 6),
				'message' => 'Ingrese la confirmación de la contraseña',
				'last' => true
			),
			'identicalFieldValues' => array (
				'rule' => array ('identicalFieldValues','password'),
				'message' => 'Su contraseña no coincide',
				'last' => true
			)
		)
	);

	public $bannedPasswords = array('password', 'admin', 'pass', 'login');

	function identicalFieldValues( $field=array(), $compare_field=null ) {
		foreach( $field as $key => $value ){
			$v1 = $value;
			$v2 = $this->data[$this->name][ $compare_field ];
				if($v1 !== $v2) {
				return FALSE;
			} else {
			   continue;
			}
		}
		return TRUE;
	}

	function parentNode(){
		if (!$this->id) {
			return null;
		}

		$data = $this->read();

		if (!$data['User']['group_id']){
			return null;
		} else {
			return array('model' => 'Group', 'foreign_key' => $data['User']['group_id']);
		}
	}

	function afterSave($created = null){
		if( $created ){
			$this->id = $this->getLastInsertId();
			// first create alias for the newly created Aro
			// ACL Behavior does NOT manage alias values
			$this->__createAroAlias();
		} else {
				if( isset($this->data['User']['group_id']) && isset( $this->data['User']['old_group_id'] ) ){
				$this->__updateAclGroup();
			}
		}
	}
	
	function __updateAclGroup(){
		if( $this->data['User']['group_id'] !== $this->data['User']['old_group_id'] ){
			// what is the id of the aro row that has $this->data['User']['group_id'] as it's foreign_key?
			$groupInfo = $this->Aro->find(array('foreign_key'=>$this->data['User']['group_id'], 'model'=>'Group') );
			$userAro = $this->Aro->find(array('foreign_key'=>$this->data['User']['id'], 'model'=>'User') );
			$updatedAro = array(
				'Aro' => array(
					'id' => $userAro['Aro']['id'],
					'parent_id' => $groupInfo['Aro']['id']
					)
				);
			$this->Aro->save( $updatedAro );
		}
	}

	function __createAroAlias(){
		$aroId = $this->Aro->getLastInsertId();
		$this->Aro->create();
		$this->Aro->id = $aroId;
		if( $this->Aro->saveField('alias', $this->data['User']['username'] ) ){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function update($id){
		$this->id = $id;
		$this->saveField('ultimavisita',date("Y-n-d H:i:s"));
	}

	function readFolder($folderName = null) {
		$folder = new Folder($folderName);
		$images = $folder->read(
			true,
			array(
				'.',
				'..',
				'Thumbs.db'
			),
			true
		);
		$images = $images[1]; // We are only interested in files

		// Get more infos about the images
		$retVal = array();
		foreach ($images as $the_image)
		{
			$the_image = new File($the_image);
			$retVal[] = array_merge(
				$the_image->info(),
				array(
					'size' => $the_image->size(),
					'last_changed' => $the_image->lastChange()
				)
			);
		}
		return $retVal;
	}
	
	function thumbjpeg($imagen, $altura, $dir_thumb) {
		if (preg_match('/.png$/', $imagen)){
			$img = @imagecreatefrompng($imagen) or die("No se encuentra la imagen ".$imagen."<br>");
		}else if (preg_match('/.gif$/', $imagen)){
			$img = @imagecreatefromgif($imagen) or die("No se encuentra la imagen ".$imagen."<br>");
		}else if (preg_match('/.jpg$/', $imagen) or preg_match('/.jpeg$/', $imagen) or preg_match('/.JPG$/', $imagen)){ 
			$img = @imagecreatefromjpeg($imagen) or die("No se encuentra la imagen ".$imagen."<br>");
		}else if (preg_match('/.bmp$/', $imagen)){
			$img = @imagecreatefrombmp($imagen) or die("No se encuentra la imagen ".$imagen."<br>");
		}
		$datos = getimagesize($imagen) or die("Problemas con ".$imagen."<br>");
		$ratio = ($datos[1] / $altura);
		$anchura = round($datos[0] / $ratio);
		$thumb = imagecreatetruecolor($anchura,$altura);
		imagecopyresampled ($thumb, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]);
		if (preg_match('/.png$/', $imagen)){
			imagepng($thumb,$dir_thumb);
		}else if (preg_match('/.gif$/', $imagen)){
			imagegif($thumb,$dir_thumb);
		}else if (preg_match('/.jpg$/', $imagen) or preg_match('/.jpeg$/', $imagen) or preg_match('/.JPG$/', $imagen)){
			imagejpeg($thumb,$dir_thumb);
		}else if (preg_match('/.bmp$/', $imagen)){
			imagebmp($thumb,$dir_thumb);
		}
	}

	function upload($data = null){
		$this->set($data);
		if(empty($this->data)){
			return false;
		}
		// Validation
		if(!$this->validates()){
			return false;
		}
		$imagen = $this->data['User']['avatar']['name'];

		if (preg_match('/.png$/', $imagen)){
			$imagen = time().'.png';
		}else if (preg_match('/.gif$/', $imagen)){
			$imagen = time().'.gif';
		}else if (preg_match('/.jpg$/', $imagen) or preg_match('/.jpeg$/', $imagen) or preg_match('/.JPG$/', $imagen) or preg_match('/.JPEG$/', $imagen)){
			$imagen = time().'.jpg';
		}else if (preg_match('/.bmp$/', $imagen)){
			$imagen = time().'.bmp';
		}
		// Move the file to the uploads folder
		if(!move_uploaded_file($this->data['User']['avatar']['tmp_name'], APP.WEBROOT_DIR.DS.'img'.DS.'avatares'.DS.$imagen)) {
			return false;
		}
		if (!empty($this->data['User']['old_avatar'])) $this->deleteFoto($this->data['User']['old_avatar']);
		
		$this->thumbjpeg(APP.WEBROOT_DIR.DS.'img'.DS.'avatares'.DS.$imagen, 200, APP.WEBROOT_DIR.DS.'img'.DS.'avatares'.DS.$imagen);
		$this->thumbjpeg(APP.WEBROOT_DIR.DS.'img'.DS.'avatares'.DS.$imagen, 20, APP.WEBROOT_DIR.DS.'img'.DS.'avatares'.DS.'thumbs'.DS.$imagen);
		return $imagen;
	}

	function deleteFoto($foto){
		if ($foto && file_exists(APP.WEBROOT_DIR.DS.'img'.DS.'avatares'.DS.'thumbs'.DS.$foto))
			unlink(APP.WEBROOT_DIR.DS.'img'.DS.'avatares'.DS.'thumbs'.DS.$foto);
		if ($foto && file_exists(APP.WEBROOT_DIR.DS.'img'.DS.'avatares'.DS.$foto))
			unlink(APP.WEBROOT_DIR.DS.'img'.DS.'avatares'.DS.$foto);
	}

	function validFile($check, $settings){
		$_default = array(
			'required' => false,
			'extensions' => array(
				'bmp',
				'gif',
				'png',
				'jpg',
				'jpeg'
			)
		);
		$_settings = array_merge(
			$_default,
			ife(
				is_array($settings),
				$settings,
				array()
			)
		);
		// Remove first level of Array
		$_check = array_shift($check);
		if($_settings['required'] == false && $_check['size'] == 0) {
			return true;
		}
		// No file uploaded.
		if($_settings['required'] && $_check['size'] == 0) {
			return false;
		}
		// Check for Basic PHP file errors.
		if($_check['error'] !== 0) {
			return false;
		}
		// Use PHPs own file validation method.
		if(is_uploaded_file($_check['tmp_name']) == false) {
			return false;
		}
		// Valid extension
		return Validation::extension(
			$_check,
			$_settings['extensions']
		);
	}
}
