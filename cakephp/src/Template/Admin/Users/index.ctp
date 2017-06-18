<?php
    $this->assign('title', __('List Users') );
    $index = ($this->Paginator->param('page') - 1) * 5 + 1;
?>
<?= $this->element('Users/breadcrumb') ?>
<div class="content users-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Flash->render() ?>
    <div class="table-wrapper">
        <table class="table table-striped">
            <thead>
                <tr><?= $this->Html->tableHeaders([
                        $this->Paginator->sort('id', '#'),
                        $this->Paginator->sort('username', __('Username')),
                        $this->Paginator->sort('nickname', __('Nickname')),
                        $this->Paginator->sort('role', __('Role')),
                        $this->Paginator->sort('created', __('Last Updated')),
                        $this->Paginator->sort('status', __('Status')),
                        $this->Paginator->sort('count(projects)', __('Projects')),
                        ''
                    ]) ?></tr>
            </thead>
            <tbody>
<?php
    foreach($users as $i => $user):
        if ($user_id == $user->id) {
            $col_style = 'active';
        } else {
            $col_style = '';
        }
        if ($user->status) {
            $status_icon = 'fa-check-circle';
            $status_style = 'status_active';
            $status_link  = $this->Form->postLink(__('Deactivate'), ['action' => 'deactivate', $user->id]);
        }  else {
            $status_icon = 'fa-ban';
            $status_style = 'status_deactive';
            $status_link  = $this->Form->postLink(__('Activate'), ['action' => 'activate', $user->id]);
        }
?>
                <tr class="<?= $col_style . ' ' . $status_style ?>">
                    <td><?= ($index + $i) ?></td>
                    <td class="username"><?= h($user->username) ?></td>
                    <td><?= h($user->nickname) ?></td>
                    <td><?= h($user->role) ?></td>
                    <td><?= $this->Time->format($user->modified, 'yyyy/MM/dd HH:mm') ?></td>
                    <td><i class="fa <?= $status_icon ?>" aria-hidden="true"></i></td>
                    <td><?= count($user->projects) ?></td>
                    <td class="postlink"><?= $status_link ?> | <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?></td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <p class="pagination-help"><?= $this->Paginator->counter(['format' => __('{{count}} items') . '<span class="pages">{{page}} / {{pages}}</span>']) ?></p>
<?php if ($this->Paginator->param('pageCount') > 1): ?>
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first() . PHP_EOL ?>
                <?= $this->Paginator->numbers(['modulus' => 4]) . PHP_EOL ?>
                <?= $this->Paginator->last() . PHP_EOL ?>
            </ul>
<?php endif; ?>
        </nav>
    </div>
</div>
