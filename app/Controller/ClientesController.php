<?php

class ClientesController extends AppController {
	public $name = 'Clientes';
	public $uses = array('Cliente');

	public function index(){
		$this->set("title_for_layout","Clinica Central / Clientes");
		$data = $this->Cliente->find('all');
		$this->set('data', $data);
	}

	public function add(){
		$this->set("title_for_layout","Clinica Central / Clientes / add");
		if (!empty($this->data)) {
			if ($this->Cliente->save($this->data)) {
				$this->Session->setFlash('El clinte ha sido creado');
				$this->redirect('index');
			} else {
				$this->Session->setFlash('No se pudo guardar, pruebe de nuevo');
			}
		}
	}

	public function delete( $id = null){
		$this->Cliente->id = $id;
		$data = $this->Cliente->read();
		if (!$id) {
			$this->Session->setFlash('Id invalida');
			$this->redirect('index');
			exit();
		}
		if( $this->Cliente->delete($id) ){
			$this->Session->setFlash('Cliente '.$data['Cliente']['cli_nomb'].' borrado');
			$this->redirect('index');
		}
	}

	public function edit($id = null){
		$this->set("title_for_layout","Clinica Central / Clientes / edit");
		$this->set('id',$id);
		if (empty($this->data)){
			$this->Cliente->id = $id;
			$this->data = $this->Cliente->read();
		}else{
			if ($this->Cliente->save($this->data)) {
				$this->Session->setFlash('Sus cambios han sido guardados');
				$this->redirect('index');
			}
		}
	}
}