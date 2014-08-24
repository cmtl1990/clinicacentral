
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
		<title></title>
				<script src="lib/js/clientes.js" type="text/javascript"></script>
		<style type="text/css">
			#formulario{
				display: none;
			}
		</style>
	
	
				<br>
		<div class="row clearfix">
			<div class="col-md-12 column">
				<nav role="navigation" class="navbar navbar-default">
					<div class="navbar-header">
							 <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="sr-only">Toggle navigation</span>
								 <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
							 <a href="#" class="navbar-brand">Clientes</a>
					</div>
				</nav>

				<div class="block-body">
					<?php echo $this->Form->create('Cliente', array('action'=>'edit', 'class'=>'wizard form-horizontal', 'data-validate'=>'parsley')); ?>
						<?php echo $this->Form->hidden('Cliente.id') ?>
						<div class="input-prepend">
							<span class="add">
								<i class="fa fa-user"></i>
							</span>
							<?php echo $this->Form->text('Cliente.cli_apel', array('size' => '40', 'placeholder'=>'Apellido', 'data-required'=>'true')); ?>
							<?php echo $this->Form->error('Cliente.cli_apel'); ?>
						</div>
						<hr>
						<div class="input-prepend">
							<span class="add">
								<i class="fa fa-user"></i>
							</span>
							<?php echo $this->Form->text('Cliente.cli_nomb', array('size' => '40', 'placeholder'=>'Nombre', 'data-required'=>'true')); ?>
							<?php echo $this->Form->error('Cliente.cli_nomb'); ?>
						</div>
						<hr>
						<div class="input-prepend">
							<span class="add">
								<i class="fa fa-user"></i>
							</span>
							<?php echo $this->Form->text('Cliente.cli_ruc', array('size' => '40', 'placeholder'=>'RUC', 'data-required'=>'true')); ?>
							<?php echo $this->Form->error('Cliente.cli_ruc'); ?>
						</div>
						<hr>
						<span id="validate-basic-form-valid" onclick="javascript:$('#validate-basic-form').parsley('validate');">
							<?php echo $this->Form->submit('Guardar', array('class'=>'btn btn-primary', 'div'=>false)); ?>
						</span>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>