<br>
<table class="container" style="text-align:center;">
<tr>
	<th class="tabcenter"><h2>Avatar</h2></th>
	<th class="tabcenter"><h2>Name</h2></th>
	<th class="tabcenter"><h2>Health</h2></th>
	<th class="tabcenter"><h2>Strength</h2></th>
	<th class="tabcenter"><h2>XP</h2></th>
	<th class="tabcenter"><h2>Level</h2></th>
	<th class="tabcenter"><h2>Email</h2></th>
	<th class="tabcenter"><h2>Join the Fight</h2></th>
	<th class="tabcenter"><h2>Upload Avatar</h2></th>
</tr>
<?php
foreach ($perso as $e)
{
echo"<tr>";
echo"<td>".$this->Html->image('/upload/'.$e['Fighter']['id'].'.png', array('width'=>70,))."</td>";
echo"<td>".$e['Fighter']['name']."</td>";
echo"<td>".$e['Fighter']['current_health']."</td>";
echo"<td>".$e['Fighter']['skill_strength']."</td>";
echo"<td>".$e['Fighter']['xp']."</td>";
if(($e['Fighter']['xp'] -(4*$e['Fighter']['level'])+4)>=4)echo"<td>".$e['Fighter']['level']." (".$this->Html->link('Level Up !', array('controller' => 'Arenas', 'action' => "levelUp/".$e['Fighter']['id'])).")</td>";
else echo "<td> ".$e['Fighter']['level']."</td>";
echo"<td>".$e['Player']['email']."</td>";
echo"<td>".$this->Html->image('arena.png', array('width'=>70,'url'=>array('controller' => 'Arenas', 'action' => 'arena/'.$e['Fighter']['id'])))."</td>";
echo"<td>".$this->Html->image('upload.png', array('width'=>70,'url'=>array('controller' => 'Arenas', 'action' => 'upload/'.$e['Fighter']['id'])))."</td>";
echo"</tr>";
}?>
</table>