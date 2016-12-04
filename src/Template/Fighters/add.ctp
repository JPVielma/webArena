<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Home'), ['controller' => 'Arenas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Combat Arena'), ['controller' => 'Arenas', 'action' => 'sight']) ?></strong></li>
        <li><strong><?= $this->Html->link(__('Fighter'), ['controller' => 'Fighters', 'action' => 'index']) ?></strong></li>
        <li><?= $this->Html->link(__('Diary'), ['controller' => 'Arenas', 'action' => 'diary']) ?></li>
    </ul>
</nav>
<div class="fighters form large-9 medium-8 columns content">
    <?= $this->Form->create($fighter) ?>
    <fieldset>
        <legend><?= __('Add Fighter') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('player_id', ['options' => $players]);
            // echo $this->Form->input('coordinate_x');
            // echo $this->Form->input('coordinate_y');
            // echo $this->Form->input('level');
            // echo $this->Form->input('xp');
            // echo $this->Form->input('skill_sight');
            // echo $this->Form->input('skill_strength');
            // echo $this->Form->input('skill_health');
            // echo $this->Form->input('current_health');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
