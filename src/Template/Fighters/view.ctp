<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Home'), ['controller' => 'Arenas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Combat Arena'), ['controller' => 'Arenas', 'action' => 'sight']) ?></strong></li>
        <li><strong><?= $this->Html->link(__('Fighter'), ['controller' => 'Fighters', 'action' => 'index']) ?></strong></li>
        <li><?= $this->Html->link(__('Diary'), ['controller' => 'Arenas', 'action' => 'diary']) ?></li>
    </ul>
</nav>
<div class="fighters view large-9 medium-8 columns content">
    <h3><?= h($fighter->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($fighter->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($fighter->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Coordinate X') ?></th>
            <td><?= $this->Number->format($fighter->coordinate_x) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Coordinate Y') ?></th>
            <td><?= $this->Number->format($fighter->coordinate_y) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Level') ?></th>
            <td><?= $this->Number->format($fighter->level) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Xp') ?></th>
            <td><?= $this->Number->format($fighter->xp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Skill Sight') ?></th>
            <td><?= $this->Number->format($fighter->skill_sight) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Skill Strength') ?></th>
            <td><?= $this->Number->format($fighter->skill_strength) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Skill Health') ?></th>
            <td><?= $this->Number->format($fighter->skill_health) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Current Health') ?></th>
            <td><?= $this->Number->format($fighter->current_health) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Next Action Time') ?></th>
            <td><?= h($fighter->next_action_time) ?></td>
        </tr>
    </table>
</div>
