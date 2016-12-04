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
        if ($matrix[$i][$j]==2 && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'Attack!',
                array('controller' => 'Arenas',
                    'action' => 'attack', $fighter['id'], $players[$i.$j]['id']));
        if ($matrix[$i][$j]==10 && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], 10));
        if ($matrix[$i][$j]==11 && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], 11));
        if ($matrix[$i][$j]==12 && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], 12));
        if ($matrix[$i][$j]==13 && $surroundings[$i][$j]==1) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], 13));
        echo "</td>" ;
    }
    echo "</tr>";
}
echo "</table>";?>
</div>