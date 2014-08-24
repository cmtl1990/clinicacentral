<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->css(array('bootstrap.min', 'bootstrap-theme.min', 'message', 'style'), 'stylesheet', array('media'=>'all')); 
		echo $this->Html->script(array('jquery.min.js','bootstrap.min.js', 'message.js'),array('inline'=>true));
	?>
</head>
<body>
	<?php echo $this->Session->flash(); ?>
	<div id="wrapper">
		<div id="template">
			<nav style="margin-bottom: 0" role="navigation" class="navbar navbar-default navbar-fixed-top">
				<div class="navbar-header">
					<button data-target=".sidebar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="index.html" class="navbar-brand">Sistema de Inventario y Facturación</a>
				</div>
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">
							<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="javascript:void();"><i class="fa fa-user fa-fw"></i> Perfil de Usuario</a>
							</li>
							<li><a href="javascript:void();"><i class="fa fa-gear fa-fw"></i> Configuraciones</a>
							</li>
							<li class="divider"></li>
							<li>
								<?php echo $this->Html->link('<i class="fa fa-sign-out fa-fw"></i>Cerrar Sesión', array('controller'=>'users', 'action'=>'logout'), array('escape'=>false)); ?>
							</li>
						</ul>
					</li>
				</ul>
				<div id="menu" role="navigation" class="navbar-default navbar-static-side">
					<div class="sidebar-collapse">
						<ul id="side-menu" class="nav">
							<li><?php echo $this->Html->link('<i class="fa fa-dashboard fa-fw"></i>Home', array('controller'=>'pages', 'action'=>'display', 'home'), array('escape'=>false)); ?></li>
							<li>
								<?php echo $this->Html->link('<i class="fa fa-users"><i>Clientes', array('controller'=>'clientes', 'action'=>'index'), array('escape'=>false)); ?>
							</li>
						</ul>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#it_clientes").click(function(){
								alert("asd");
							});
						});
					</script>
				</div>
			</nav>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#menu").load("pages/menu.php");
				})
			</script>
		</div>
		<div id="page-wrapper">
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
