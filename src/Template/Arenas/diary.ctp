<table class="container" style="text-align:center;">
<tr>
        <th class="tabcenter"><h1>Date</h1></th>
	<th class="tabcenter"><h1>Evenement</h1></th>
	<th class="tabcenter"><h1>Coordonnée X</h1></th>
	<th class="tabcenter"><h1>Coordonnée Y</h1></th>
</tr>

<?php
foreach ($raw as $e)
{
echo"<tr>";
echo"<td>".$e['Event']['date']."</td>";
echo"<td>".$e['Event']['name']."</td>";
echo"<td>".$e['Event']['coordinate_x']."</td>";
echo"<td>".$e['Event']['coordinate_y']."</td>";
echo"</tr>";
}?>
</table>