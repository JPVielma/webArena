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

// $cakeDescription = __d('cake_dev', 'CakePHP ');
// $cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

	<?php echo $this->Html->charset(); ?>
	<title>
		<?php $this->assign('title', 'WebArenaGroup1-11-DF'); ?>
		<?php echo $this->fetch('title'); ?>
	</title>

	<link href='https://fonts.googleapis.com/css?family=Marvel' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="webroot/images/favicon.ico">
	<style type="text/css">.lead{text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;}</style>
	

	<?php
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css('bootstrap-theme');
		echo $this->Html->css('main');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

	?>
</head>
<body class="home">
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<?php echo  $this->Html->image('logo.png', array('url'=>array('controller' => 'Arenas', 'action' => 'index')));?>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li class="active"><?php echo $this->Html->link(' Home ', array('controller' => 'players', 'action' => 'index'));?></li>
					<li><?php echo $this->Html->link(' Login ', array('controller' => 'players', 'action' => 'login'));?></li>
					<li><?php echo $this->Html->link(' Story ', array('controller' => 'Arenas', 'action' => 'diary'));?></li>
					<li><?php echo $this->Html->link(' Create Fighter ', array('controller' => 'Arenas', 'action' => 'fighter'));?></li>
					<li><?php echo $this->Html->link(' Arena ', array('controller' => 'Arenas', 'action' => 'avatar'));?></li>
					<li><?php if($this->Session->read('Connected')) echo $this->Html->link('Logout', array('controller' => 'Players', 'action' => 'logout'));?></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->

	<!-- Header -->
	<header id="head">
		<div class="container">
			<div class="row">
				<h1 class="lead">MeuhPORG</h1>
				<p><a class="btn btn-default btn-lg" role="button" href="#container">RULES</a> <a class="btn btn-action btn-lg" role="button" href="arenas/avatar">PLAY</a></p>
			</div>
		</div>
	</header>
	<!-- /Header -->

	<!-- Highlights - jumbotron -->

	<div id="container">

		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<!-- /Highlights -->



	<footer id="footer" class="top-space">

		<div class="footer1">
			<div class="container">
				<div class="row">
					
					<div class="col-md-3 widget">
						<h3 class="widget-title">Groupe : 1 Option DF</h3>
						<div class="widget-body">
							<p>Auteurs : <a href="https://fr.linkedin.com/pub/anatole-guyot-reeb/71/661/aa2" target=_blank>Guyot</a> - <a href="https://fr.linkedin.com/pub/théophile-dunoyer-de-segonzac/66/491/418" target=_blank>Dunoyer</a> - <a href="https://fr.linkedin.com/in/leonardbellot" target=_blank>Bellot</a></p>	
						</div>
					</div>


				</div> <!-- /row of widgets -->
			</div>
		</div>

		<div class="footer2">
			<div class="container">
				<div class="row">
					
					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="simplenav">
								<a class="active"><?php echo $this->Html->link(' Accueil ', array('controller' => 'Arenas', 'action' => '/'));?></a> | 
					<a><?php echo $this->Html->link(' Login ', array('controller' => 'Players', 'action' => 'login'));?></a> | 
					<a><?php echo $this->Html->link(' Story ', array('controller' => 'Arenas', 'action' => 'diary'));?></a> | 
					<a><?php echo $this->Html->link(' Create Fighter ', array('controller' => 'Arenas', 'action' => 'fighter'));?></a> | 
					<a><?php echo $this->Html->link(' Arena ', array('controller' => 'Arenas', 'action' => 'avatar'));?></a>
								| <a><?php echo $this->Html->link(' TESTPAGE ', '/');?></a>
							</p>
						</div>
					</div>

					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="text-right">
								Copyright &copy; 2015.
							</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

	</footer>	
		




	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="assets/js/headroom.min.js"></script>
	<script src="assets/js/jQuery.headroom.min.js"></script>
	<script src="assets/js/template.js"></script>
</body>


</html>
