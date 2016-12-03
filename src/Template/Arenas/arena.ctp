<br><br>

<div class='container'>
<table style='table-layout:fixed; width: 100%; text-align: center; border: 2px solid black;'>
<?php
foreach(range(0, 9) as $d)
{
	echo "<tr style='border:1px solid black;'>";
	foreach(range(0, 14) as $c)
	{
		$cl='';
		$nl = '';
		if(isset($classes[$c][$d]) && isset($names[$c][$d]))
		{
			$f = $c - $x;
			$g = $d - $y;
			if($f < 0) $f = -$f;
			if($g < 0) $g = -$g;
			$vue = $vue-1;
			$cl=" class='".$classes[$c][$d]."'";
			if($names[$c][$d] != 'x' && $names[$c][$d] != 'o') $nl = $this->Html->link($names[$c][$d], array('controller' => 'Arenas', 'action' => "doAttack/".$curfighter."/".$ids[$c][$d]));
			else if($names[$c][$d] == 'o') $nl = $this->Html->link($names[$c][$d], array('controller' => 'Arenas', 'action' => "doMove/".$curfighter."/".$c."/".$d));
			else if($names[$c][$d] == 'x') $nl = "x";
			echo '<td'.$cl.'> '.$nl.' </td>';
		}
		else echo '<td'.$cl.'> '.$nl.' </td>';
	}
	echo "</tr>";
}
?>
</table>
</div>
