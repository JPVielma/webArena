<?php
echo "<table>";
for ($i=0; $i<10; $i++){
    echo "<tr>";
    for ($j=0; $j<15; $j++){
        echo "<td>";
        if ($matrix[$i][$j]==1)echo "F";
        if ($matrix[$i][$j]==0) echo ".";
        if ($matrix[$i][$j]==2) echo "</br>".$this->Form->postLink(
                'Attack!',
                array('controller' => 'Arenas',
                    'action' => 'attack', $fighter['id'], $players[$i.$j]['id']));
        if ($matrix[$i][$j]==10) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], 10));
        if ($matrix[$i][$j]==11) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], 11));
        if ($matrix[$i][$j]==12) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], 12));
        if ($matrix[$i][$j]==13) echo "</br>".$this->Form->postLink(
                'X',
                array('controller' => 'Arenas',
                    'action' => 'move', $fighter['id'], 13));
        echo "</td>" ;
    }
    echo "</tr>";
}
echo "</table>";
