<?php
    $this->assign('title', __('Setup Project'));
    if ($project->status) {
        $badge_label = __('Publish');
        $badge_style = 'badge-success';
    } else {
        $badge_label = __('Private');
        $badge_style = 'badge-default';
    }
?>
<nav class="nav topicpath">
    <?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link back-link']) . PHP_EOL ?>
</nav>
<div class="content edit-post-content">
    <div class="title">
        <h1><?= $this->fetch('title') ?><span class="badge badge-pill <?= $badge_style ?>"><?= $badge_label ?></span></h1>
    </div>
    <?= $this->Flash->render() ?>
    <section class="boxed-group">
        <h2><?= __('Users') ?></h2>
        <div class="boxed-group-inner boxed-group-inner-table">
            <?= $this->Flash->render('users') ?>
            <table class="table table-sm">
                <thead>
                    <?= $this->Html->tableHeaders([
                        __('Username'),
                        __('Role'),
                        [__('Unjoin') => ['class' => 'unjoin']]
                    ]) ?>
                </thead>
                <tbody>
<?php foreach($users as $user): ?>
                    <tr>
                        <td><?= h($user->username) ?></td>
                        <td><?= h($user->_joinData->role) ?></td>
                        <td class="unjoin">
<?php if ($user->id != $user_id) : ?>
                            <?= $this->Form->postLink(
                                    '<i class="fa fa-times-circle" aria-hidden="true"></i>',
                                    ['action' => 'unjoin', $project->id, $user->id],
                                    [
                                        'role' => 'button',
                                        'aria-pressed' => 'true',
                                        'confirm' => __('Are you sure you want to remove "{0}" ?', h($user->username)),
                                        'escape' => false
                                    ]
                                ) . PHP_EOL
                            ?>
<?php endif; ?>
                        </td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="boxed-group-inner">
            <?= $this->Form->create($project) . PHP_EOL ?>
            <div class="form-group text required">
                <label class="control-label" for="name"><?= __('User Name') ?></label>
                <div class="form-inline">
                    <?= $this->Form->text('users._username', ['value' => '']) . PHP_EOL ?>
                    <?= $this->Form->button(__('Add'), ['class' => 'btn-secondary']) . PHP_EOL ?>
                </div>
            </div>
            <?= $this->Form->end() . PHP_EOL ?>
        </div>
    </section>
    <section class="boxed-group">
        <h2><?= __('Settings') ?></h2>
        <div class="boxed-group-inner boxed-group-row">
            <?= $this->Form->create($project) . PHP_EOL ?>
<?php if ($project->status) : ?>
                <?= $this->Form->button(__('Make private'), ['class' => 'btn-secondary js-confirm', 'data-confirm' => __('Are you sure you want to private?'), 'name' => 'status', 'value' => '0']) . PHP_EOL ?>
                <p class="doc"><strong><?= __('Make this project private') ?></strong></p>
<?php else: ?>
                <?= $this->Form->button(__('Make publish'), ['class' => 'btn-secondary js-confirm', 'data-confirm' => __('Are you sure you want to publish?'), 'name' => 'status', 'value' => '1']) . PHP_EOL ?>
                <p class="doc"><strong><?= __('Make this project publish') ?></strong></p>
<?php endif; ?>
            <?= $this->Form->end() . PHP_EOL ?>
        </div>
        <div class="boxed-group-inner boxed-group-row">
            <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $project->id],
                    ['class' => 'btn btn-secondary btn-delete', 'role' => 'button', 'aria-pressed' => 'true', 'confirm' => __('Are you sure you want to delete # {0}?', $project->id)]
                ) . PHP_EOL
            ?>
            <p class="doc"><strong><?= __('Delete this project') ?></strong></p>
        </div>
    </section>
</div>
