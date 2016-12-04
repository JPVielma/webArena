<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Home'), ['controller' => 'Arenas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Combat Arena'), ['controller' => 'Arenas', 'action' => 'sight']) ?></li>
        <li><?= $this->Html->link(__('Fighter'), ['controller' => 'Fighters', 'action' => 'index']) ?></li>
        <li><strong><?= $this->Html->link(__('Diary'), ['controller' => 'Arenas', 'action' => 'diary']) ?></strong></li>
    </ul>
</nav>
<div class="events index large-9 medium-8 columns content">
    <h3><?= __('Events') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('coordinate_x') ?></th>
                <th scope="col"><?= $this->Paginator->sort('coordinate_y') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
            <tr>
                <td><?= h($event->name) ?></td>
                <td><?= h($event->date) ?></td>
                <td><?= $this->Number->format($event->coordinate_x) ?></td>
                <td><?= $this->Number->format($event->coordinate_y) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
