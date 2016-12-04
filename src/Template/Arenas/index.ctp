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
					<div class="h-caption"><h4><i class="fa fa-flash fa-5"></i>Attack</h4></div>
					<div class="h-body text-center">
						<p>An attack is successful if a random value between 1 and 20 is higher than ( 10 + Attackee Level - Attacker Level )</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-heart fa-5"></i>Skills</h4></div>
					<div class="h-body text-center">
						<p>A fighter starts with the following skills : sight = 0, strength = 1, health = 3. He spawns at a randam position in the grid. When he reaches 0 health, he is removed from the game. The player is then requested to create a new fighter.</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-smile-o fa-5"></i>Diary</h4></div>
					<div class="h-body text-center">
						<p>Each action is logged with a clear description. E.g. "1 attacks 2 and hits !"</p>
					</div>
				</div>
			</div> <!-- /row  -->
		
		</div>
	</div>
	<!-- /Highlights -->