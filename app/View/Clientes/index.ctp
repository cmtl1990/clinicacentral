
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

					<div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse navbar-right">
						<ul class="nav navbar-nav">
							<!--li id="btnNuevo" class="active"><a href="#"><span class="glyphicon glyphicon-plus-sign"></span> Crear Nuevo</a></li-->
							
							<li>
								<ul id="paginacion" class="pagination pull-right navtool"></ul>
							</li>
							<li><button class="btn btn-default navtool" type="button" id="btnPDF"><span class="glyphicon glyphicon-print"></span></button></li>
							<li>
								<form role="search" class="navbar-form">
									<div class="form-group col-lg-offset-0">
										<input type="text" placeholder="Filtro de búsqueda" class="form-control" id="filtro" kl_virtual_keyboard_secure_input="on">
									</div>
								</form>
							</li>
							<li>
								<?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span>&nbsp;Nuevo', array('action'=>'add'), array('class'=>'btn btn-default navtool', 'escape'=>false)); ?>
							</li>
							<!-- li class="disabled"><a href="#"><span id="statusCliente" class="glyphicon glyphicon-ok"></span></a></li-->
						</ul>

					</div>
				</nav>

				<table class="table table-hover table-bordered" id="tablaClientes">
					<thead>
						<tr>
							<th class="col-sm-6">Cliente</th>
							<th class="col-sm-3">Cédula</th>
							<th class="col-sm-2"></th>
						</tr>
					</thead>
					<tbody id="registros">
						<?php foreach ($data AS $row): ?>
							<tr>
								<td><?php echo $row['Cliente']['cli_apel']." ".$row['Cliente']['cli_nomb']; ?></td>
								<td><?php echo $row['Cliente']['cli_ruc']; ?></td>
								<td><?php echo $row['Cliente']['cli_tel1']; ?></td>
								<td class="btn-toolbar">
									<?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array('controller'=>'clientes', 'action'=>'edit', $row['Cliente']['id']), array('class'=>'btn btn-primary', 'escape'=>false)); ?>
									<?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>', array('controller'=>'clientes', 'action'=>'delete', $row['Cliente']['id']), array('class'=>'btn btn-danger', 'escape'=>false), 'Confirmar?'); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>


				<div class="jumbotron text-center" id="formulario">
					<div class="row clearfix">
						<div class="col-md-2 column"></div>
						<div class="col-md-8 column">
							<form role="form" class="form-horizontal">
								<!--
		/*
		  clie_codi serial NOT NULL,
		  clie_nomb character varying(50) NOT NULL,
		  clie_apel character varying(50) NOT NULL,
		  clie_ciru character varying(13) NOT NULL,
		  clie_tipo smallint NOT NULL DEFAULT 0,
		  clie_ema1 character varying(30),
		  clie_ema2 character varying(30),
		  clie_ema3 character varying(30),
		  clie_tel1 character varying(20),
		  clie_tel2 character varying(20),
		  clie_dire character varying(100),
		  clie_refe character varying(50),
		  clie_esta smallint NOT NULL DEFAULT 0,
		 */
								-->
								<div class="form-group">
									<label class="col-sm-2 control-label" for="nom">Nombres</label>
									<div class="col-sm-10">
										<input type="text" id="nom" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="ape">Apellidos</label>
									<div class="col-sm-10">
										<input type="text" id="ape" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="ced">Cédula</label>
									<div class="col-sm-10">
										<input type="number" id="ced" class="form-control bfh-number">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="tip">Tipo</label>
									<div style="text-align: left" class="col-sm-10">
										<div class="select2-container" id="s2id_tip" style="width: 100%;"><a tabindex="-1" class="select2-choice" href="javascript:void(0)">   <span class="select2-chosen" id="select2-chosen-1">Tipo A</span><abbr class="select2-search-choice-close"></abbr>   <span role="presentation" class="select2-arrow"><b role="presentation"></b></span></a><label class="select2-offscreen" for="s2id_autogen1">Tipo</label><input type="text" role="button" aria-haspopup="true" class="select2-focusser select2-offscreen" aria-labelledby="select2-chosen-1" id="s2id_autogen1" kl_virtual_keyboard_secure_input="on"><div class="select2-drop select2-display-none select2-with-searchbox">   <div class="select2-search">       <label class="select2-offscreen" for="s2id_autogen1_search">Tipo</label>       <input type="text" aria-autocomplete="list" aria-expanded="true" role="combobox" class="select2-input" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off" aria-owns="select2-results-1" id="s2id_autogen1_search" placeholder="" kl_virtual_keyboard_secure_input="on">   </div>   <ul role="listbox" class="select2-results" id="select2-results-1">   </ul></div></div><select id="tip" tabindex="-1" title="Tipo" class="select2-offscreen">
											<option value="0">Tipo A</option>
											<option value="1">Tipo B</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="em1">Email 1</label>
									<div class="col-sm-10">
										<input type="text" id="em1" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="em2">Email 2</label>
									<div class="col-sm-10">
										<input type="text" id="em2" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="em3">Email 3</label>
									<div class="col-sm-10">
										<input type="text" id="em3" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="te1">Telefono 1</label>
									<div class="col-sm-10">
										<input type="text" id="te1" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="te2">Telefono 2</label>
									<div class="col-sm-10">
										<input type="text" id="te2" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="dir">Dirección</label>
									<div class="col-sm-10">
										<input type="text" id="dir" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="ref">Referencia</label>
									<div class="col-sm-10">
										<input type="text" id="ref" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="est">Estado</label>
									<div class="col-sm-10">
										<input type="text" id="est" class="form-control" kl_virtual_keyboard_secure_input="on">
									</div>
								</div>


								<div class="form-group">
									<div class="col-sm-offset-2">
										<button class="btn btn-primary" id="btnGuardar" type="button">
												<span class="glyphicon glyphicon-save"></span>&nbsp;Guardar
										</button>
										<button class="btn btn-default" id="btnCancelar" type="button">
											<span class="glyphicon glyphicon-ban-circle"></span>&nbsp;Cancelar
										</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-2 column"></div>
					</div>
				</div>
					
				<div class="modal fade">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
						<h4 class="modal-title">Modal title</h4>
					  </div>
					  <div class="modal-body">
						<p>One fine body…</p>
					  </div>
					  <div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">/button&gt;
						</button><button class="btn btn-primary" type="button"></button>
					  </div>
					</div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
	
			</div>
		</div>