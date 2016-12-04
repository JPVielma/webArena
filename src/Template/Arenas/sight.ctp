<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Home'), ['controller' => 'Arenas', 'action' => 'index']) ?></li>
        <li><strong><?= $this->Html->link(__('Combat Arena'), ['controller' => 'Arenas', 'action' => 'sight']) ?></strong></li>
        <li><?= $this->Html->link(__('Fighter'), ['controller' => 'Fighters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Diary'), ['controller' => 'Arenas', 'action' => 'diary']) ?></li>
    </ul>
</nav>
<div class="players view large-9 medium-8 columns content">
<h1>Combat Arena</h1>
<?php
echo "<table>";
for ($i=0; $i<BORDERY; $i++){
    echo "<tr>";
    for ($j=0; $j<BORDERX; $j++){
        echo "<td>";
        if ($matrix[$i][$j]==FIGHTER && $surroundings[$i][$j]==1)echo "F";
        if ($matrix[$i][$j]==0 && $surroundings[$i][$j]==0) echo ".";
        if ($matrix[$i][$j]==ATTACK && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'Attack!',
                array('controller' => 'Arenas',
                    'action' => 'attack', $fighter['id'], $players[$i.$j]['id']));
        if ($matrix[$i][$j]==UP && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], UP));
        if ($matrix[$i][$j]==DOWN && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], DOWN));
        if ($matrix[$i][$j]==LEFT && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], LEFT));
        if ($matrix[$i][$j]==RIGHT && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], RIGHT));
        echo "</td>" ;
    }
    echo "</tr>";
}
echo "</table>";?>
</div>