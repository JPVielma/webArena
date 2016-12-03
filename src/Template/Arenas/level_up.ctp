<div class='container'>
<?php
echo "<h3> Choose what characteristics to enhance :<td>";
echo $this->Session->Flash();
echo $this->Form->create('Skills', array('class'=>'form-horizontal'));
echo $this->Form->input('choice',array('options' => array('health'=>'Health +3','sight'=>'Sight +1','strength'=>'Strength +1'), 'default' => 'strength'));
echo $this->Form->end(array('label'=>'Choose','div'=>array('class'=>'controls'), 'class'=>'btn btn-primary'));
?>
</div>