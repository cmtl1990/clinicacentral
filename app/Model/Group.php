<?php
App::uses('AppModel', 'Model');

class Group extends AppModel{
	public $name = 'Group';
	public $actsAs = array('Acl'=>'requester');

	function parentNode(){
		if (!$this->id) {
		  return null;
		}

		$data = $this->read();

		if (!$data['Group']['parent_id']){
		  return null;
		} else {
		  return array('model' => 'Group', 'foreign_key' => $data['Group']['parent_id']);
		}
	}

	function afterSave($created = null){
	    if( $created ){
		    $this->id = $this->getLastInsertId();
		    // first create alias for the newly created Aro
		    $this->__createAroAlias();
		} else {
		    $this->__updateAclGroup();
		}
	}

	function getNodePath(){
	        return $this->Aro->node( $this );
	}

	function __createAroAlias(){
	    $aroId = $this->Aro->getLastInsertId();
		$this->Aro->create();
		$this->Aro->id = $aroId;
		if( $this->Aro->saveField('alias', $this->data['Group']['name'] ) ){
		    return TRUE;
		} else {
		    return FALSE;
		}
	}

	function __updateAclGroup(){
		if( $this->data['Group']['parent_id'] !== $this->data['Group']['old_parent_id'] ){
			// what is the id of the aro row that has $this->data['Group']['parent_id'] as it's foreign_key?
			$parentInfo = $this->Aro->find(array('foreign_key'=>$this->data['Group']['parent_id'], 'model'=>'Group') );
			$groupAro = $this->Aro->find(array('foreign_key'=>$this->data['Group']['id'], 'model'=>'Group') );
			$updatedAro = array(
			    'Aro' => array(
				    'id' => $groupAro['Aro']['id'],
					'parent_id' => $parentInfo['Aro']['id']
					)
				);
			$this->Aro->save( $updatedAro );
		}
	}
}