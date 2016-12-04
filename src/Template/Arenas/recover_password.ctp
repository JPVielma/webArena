<div class="index large-4 medium-4 large-offset-4 medium offset-4 columns">
   <br>
   <div class="panel">
       <h2 class="text-center">Recover Password</h2>
       <?= $this->Form->create(); ?>
       <?= $this->Form->input('email');?>
       <?= $this->Form->submit('Email Password', array('class'=>'button'));?>
       <?= $this->Form->end(); ?>

   </div>

   

</div>
