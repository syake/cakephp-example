<?php
    $this->assign('title', __('List Users') );
    $index = ($this->Paginator->param('page') - 1) * 5 + 1;
?>
<nav class="nav topicpath">
  <?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index', 'prefix' => false], ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content index-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Flash->render() ?>
    <table class="table table-striped table-bordered">
        <thead>
            <?= $this->Html->tableHeaders([
                [$this->Paginator->sort('id', '#') => ['class' => 'num']],
                $this->Paginator->sort('username'),
                $this->Paginator->sort('nickname'),
                $this->Paginator->sort('role'),
                'created',
                'modified',
                $this->Paginator->sort('status'),
                ''
            ]) ?>
        </thead>
        <tbody>
            <?php foreach($users as $i => $user): ?>
            <?php
                if ($user_id == $user->id) {
                    $col_style = 'active';
                } else if (!$user->status) {
                    $col_style = 'invalid';
                } else {
                    $col_style = '';
                }
            ?>
            <tr class="<?= $col_style ?>">
                <td class="num"><?= $i + $index ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->nickname) ?></td>
                <td><?= h($user->role) ?></td>
                <td><?= $this->Time->format($user->created, 'yyyy/MM/dd HH:mm') ?></td>
                <td><?= $this->Time->format($user->modified, 'yyyy/MM/dd HH:mm') ?></td>
                <td><?= $this->Form->input('status', ['type' => 'checkbox']) ?></td>
                <td><?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id], ['class' => 'edit-link']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first() ?>
            <?= $this->Paginator->numbers(['modulus' => 4]); ?>
            <?= $this->Paginator->last() ?>
        </ul>
        <p class="pagination-doc"><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </nav>
</div>
