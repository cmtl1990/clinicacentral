<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');

class UsersController extends AppController {
	public $name = 'Users';
	public $allowCookie = TRUE;
	public $cookieTerm = '+4 weeks';
	public $components = array('SwiftMailer');
	public $uses = array('User');

	function beforeFilter(){
		App::uses('CakeEmail', 'Network/Email');
		$this->Auth->allow('login', 'logout','forgot');
		$this->Auth->mapActions(array(
			'read' => array('account'),
			'update' => array('changepassword','perfil')
		));
		parent::beforeFilter();
	}

	function account($slug){
		$this->set("title_for_layout","Clinica Central / ".$slug);
		$this->layout = 'private';
		$data = $this->User->find('first', array('conditions'=>array('User.username'=>$slug)));
		$this->set('user', $data);
	}

	function changepassword(){
		$this->set("title_for_layout","Clinica Central / Cambiar contraseña");
		$this->layout = 'private';
		if (empty($this->data)) {
			$this->User->id = $this->Auth->user('id');
			$this->data = $this->User->read();
		} else {
			$data = $this->data;
			$data['User']['password'] = $this->Auth->password($data['User']['password']);
			$data['User']['password_confirm'] = $this->Auth->password($this->data['User']['password_confirm']);
			if ($this->User->save($data)) {
				$this->Session->setFlash('Sus contraseña ha sido actualizada');
				$this->redirect('changepassword');
			}
		}
	}

	function perfil(){
		$this->set("title_for_layout","Clinica Central / Perfil");
		$this->layout = 'private';
		if (empty($this->data)) {
			$this->User->id = $this->Auth->user('id');
			$this->data = $this->User->read();
		}else{
			$data = $this->data;
			if($data['User']['avatar'] = $this->User->upload($data)){
				if ($this->User->save($data)) {
					$this->Session->setFlash('Su perfil ha sido actualizado');
					$this->redirect('perfil');
				}
			}else{
				$this->Session->setFlash('No se pudo subir la imagen');
			}
		}
	}

	function login() {
		$this->set("title_for_layout","Clinica Central / Login");
		$this->layout = 'login';
		if ($this->Auth->login()) {
			if (!empty($this->data)) {
				if (!empty($this->data['User']['rememberme'])){
					//$this->Cookie->write('Auth.User', $this->Auth->user(), false, $this->cookieTerm );
				}
				$this->Session->setFlash($this->__greeting($this->Auth->user('name')));
				$this->User->update($this->Auth->user('id'));
			}
			return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
		} else {
			if (!empty($this->data)) {
				$this->Session->setFlash('Usuario o contraseña no válidos, pruebe de nuevo');
			}else{
				$cookie = $this->Cookie->read('Auth.User');
				if (!is_null($cookie)) {
					if ($this->Auth->login($cookie)) {
						$this->Session->delete('Message.auth');
						//$this->redirect($this->Auth->redirect());
					}else{
						$this->Cookie->delete('Auth.User');
					}
				}
			}
		}
	}

	function logout() {
       	$cookie = $this->Cookie->read('Auth.User');
		$this->Cookie->delete('Auth.User');
		if ($this->Auth->loggedIn()) $this->Session->setFlash('Has salido satisfactoriamente');
		$this->redirect($this->Auth->logout());
	}

	function forgot(){
		$this->set("title_for_layout","Clinica Central / forgot");
		$this->layout = 'public';
		if (!empty($this->data)){
			$users = $this->User->find('first', array('conditions' => array('User.email' => $this->data["User"]["email"],'estado'=>'1')));
			if (!empty($users)){
				$code = $this->__aleatorio();
				$data["User"]["id"] = $users["User"]["id"];
				$data["User"]["name"] = $users["User"]["name"];
				$data["User"]["username"] = $users["User"]["username"];
				$data["User"]["email"] = $users["User"]["email"];
				$data["User"]["password"] = $this->Auth->password($code);
				if ($this->__sendmail('forgot','Nueva contraseña',$data, $code)){
					if ($this->User->save($data)) {
						$this->Session->setFlash('Su nueva contraseña se ha enviado a su correo');
						$this->redirect('login');
					}else $this->Session->setFlash('No se pudo guardar, pruebe de nuevo');
				}else $this->Session->setFlash('No se pudo enviar, pruebe de nuevo');
			}else{
				$this->Session->setFlash('Este correo electrónico no está registrado');
			}
		}
	}

	function __sendmail($view,$asunto,$data, $code){
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if (preg_match($regex, $data["User"]["email"])){
			$email = new CakeEmail('smtp');
			$email->template($view, 'default')
				->emailFormat('html') //both - to send multipart
				->viewVars(array(
					'name'=>$data["User"]["name"],
					'username'=>$data["User"]["username"], 
					'password' => $code))
				->to($data["User"]["email"])
				->from(array('webmaster@Clinica Central.edu.ec' => 'Clinica Central'))
				->subject($asunto);
			return $email->send();
		}else
			return false;
	}

	function __sendMandrill($view, $asunto, $data, $code){
		$email = new CakeEmail();
		$email->config('mandrill')
			  ->template($view, 'default')
			  ->emailFormat('html')
			  ->viewVars(array(
					'name'=>$data["User"]["name"],
					'username'=>$data["User"]["username"], 
					'password' => $code))
			  ->from('webmaster@Clinica Central.edu.ec')
			  ->to($data["User"]["email"])
			  ->subject($asunto);
		$result = $email->send('test');
		print_r($result['Mandrill']); exit();
	}

	function __configureAuthCookie(){
		if( $this->allowCookie ){
			$this->set('rememberme', TRUE);
		} else {
			$this->set('rememberme', FALSE);
		}
	}

	function __greeting($nombre){
		$saludos = array("Hola ".$nombre."!","Buenos días ".$nombre, "Hola ".$nombre.", cómo estás!", "Qué tal ".$nombre,"Cómo te va ".$nombre."!","Bienvenid@ ".$nombre,"Qué fue ".$nombre."!","Hola ".$nombre.", que tal");
		return $saludos[array_rand($saludos,1)];
	}

	function __checkUsersOwnRecord($recordId = null){
		if( $this->Auth->user('id') == $recordId ){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function __aleatorio ($long = 6, $letras_min = true, $letras_max = true, $num = true) {
		$salt = $letras_min?'abchefghknpqrstuvwxyz':'';
		$salt .= $letras_max?'ACDEFHKNPRSTUVWXYZ':'';
		$salt .= $num?(strlen($salt)?'2345679':'0123456789'):'';
		if (strlen($salt) == 0) {
			return '';
		}
		$i = 0;
		$str = '';
		srand((double)microtime()*1000000);
		while ($i < $long) {
			$num = rand(0, strlen($salt)-1);
			$str .= substr($salt, $num, 1);
			$i++;
		}
		return $str;
	}

}