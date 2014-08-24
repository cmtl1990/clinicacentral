<?php echo $this->Html->css(array('login'), 'stylesheet', array('media'=>'all'));  ?>

<div id="login">
<?php echo $this->Form->create('User', array('action' => 'login', 'class'=>'form-horizontal')); ?>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <?php echo $this->Form->input('username', array('label'=>false, 'placeholder'=>'Nombre de usuario')); ?>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <?php echo $this->Form->input('password', array('label'=>false, 'placeholder'=>'Contraseña','type'=>'password')); ?>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <?php echo $this->Form->input('rememberme', array('label'=>'Recordarme en este equipo', 'type'=>'checkbox', 'checked'=>'true')); ?>
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign in</button>
    </div>
  </div>
<?php echo $this->Form->end(); ?>
</div>