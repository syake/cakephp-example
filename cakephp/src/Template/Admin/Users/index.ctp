<?php
    $this->assign('title', __('List Users') );
    $index = ($this->Paginator->param('page') - 1) * 5 + 1;
?>
<?= $this->element('Users/breadcrumb') ?>
<div class="content users-content">
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
                [$this->Paginator->sort('status', 'ST') => ['class' => 'status']],
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
                <td class="status"><?= $this->Form->control('status' . $user->id, [
                    'checked' => $user->status,
                    'type' => 'checkbox',
                    'templates' => [
                        'nestingLabel' => '{{hidden}}<label class="custom-control custom-checkbox"{{attrs}}>{{input}}</label>'
                    ]
                ]) ?></td>
                <td><?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id], ['class' => 'setup-link']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <p class="pagination-help"><?= $this->Paginator->counter(['format' => __('{{count}} items') . '<span class="pages">{{page}} / {{pages}}</span>']) ?></p>
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first() ?>
            <?= $this->Paginator->numbers(['modulus' => 4]); ?>
            <?= $this->Paginator->last() ?>
        </ul>
        
    </nav>
</div>
