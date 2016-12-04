<?php //$this -> layout = 'index';?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><strong><?= $this->Html->link(__('Home'), ['controller' => 'Arenas', 'action' => 'index']) ?></strong></li>
        <li><?= $this->Html->link(__('Combat Arena'), ['controller' => 'Arenas', 'action' => 'sight']) ?></li>
        <li><?= $this->Html->link(__('Fighter'), ['controller' => 'Fighters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Diary'), ['controller' => 'Arenas', 'action' => 'diary']) ?></li>
    </ul>
</nav>
<div class="players view large-9 medium-8 columns content">
		<div class="container">
			
			<h1 class="text-center thin">Game Rules</h1>
			
			<div class="row">
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-cogs fa-5"></i>Movement</h4></div>
					<div class="h-body text-center">
						<p>A fighter is in a checkerboard arena at a position X, Y. This position can not be outside the dimensions of the arena. Only one fighter per box. One arena per site. </p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-flash fa-5"></i>Attaque</h4></div>
					<div class="h-body text-center">
						<p>Une action d'attaque réussit si une valeur aléatoire entre 1 et 20 (d20) est supérieur à un seuil calculé comme suit : 10 + niveau de l'attaqué - niveau de l'attaquant. </p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-heart fa-5"></i>Santé</h4></div>
					<div class="h-body text-center">
						<p>Un combattant commence avec les caractéristiques suivantes : vue= 0, force=1, point de vie=3. Il apparaît à une position aléatoire libre.
                                                   Lorsque le combattant voit ses points de vie atteindre 0, il est retiré du jeu. Un joueur dont le combattant a été retiré du jeu est invité à en recréer un nouveau. </p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-smile-o fa-5"></i>Vie social</h4></div>
					<div class="h-body text-center">
						<p>Chaque action provoque la création d'un événement avec une description claire. Par exemple : « jonh attaque bill et le touche ». </p>
					</div>
				</div>
			</div> <!-- /row  -->
		
		</div>
	</div>
	<!-- /Highlights -->