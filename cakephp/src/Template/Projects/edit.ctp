<?php
    $this->assign('title', __('Edit Project'));
?>
<nav class="nav topicpath">
  <?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content edit-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Flash->render() ?>
    <section class="boxed-group">
        <h2><?= __('Settings') ?></h2>
        <div class="boxed-group-inner">
            <?= $this->Form->create($project) ?>
            <div class="form-group text required">
                <label class="control-label" for="name"><?= __('Project Name') ?></label>
                <div class="form-inline">
                    <?= $this->Form->text('name') ?>
                    <?= $this->Form->button(__('Rename'), ['class' => 'btn-secondary']); ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </section>
    <section class="boxed-group">
        <h2><?= __('Users') ?></h2>
        <div class="boxed-group-inner boxed-group-inner-table">
            <table class="table table-sm">
                <thead>
                    <?= $this->Html->tableHeaders([
                        __('Username'),
                        __('Role')
                    ]) ?>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= h($user->username) ?></td>
                        <td><?= h($user->_joinData->role) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="boxed-group-inner">
            <?= $this->Form->create($project) ?>
            <?php foreach($users as $user): ?>
            <?= $this->Form->hidden('users._ids[]', ['value' => $user->id]) ?>
            <?php endforeach; ?>
            <div class="form-group text required">
                <label class="control-label" for="name"><?= __('User Name') ?></label>
                <div class="form-inline">
                    <?= $this->Form->text('users._username') ?>
                    <?= $this->Form->button(__('Add'), ['class' => 'btn-secondary']); ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </section>
    <section class="boxed-group">
        <h2><?= __('Delete') ?></h2>
        <div class="boxed-group-inner">
            <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $project->id],
                    ['class' => 'btn btn-secondary btn-delete', 'role' => 'button', 'aria-pressed' => 'true', 'confirm' => __('Are you sure you want to delete # {0}?', $project->id)]
                )
            ?>
            <p class="doc"><strong><?= __('Delete this project') ?></strong></p>
        </div>
    </section>
</div>


<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="projects form large-9 medium-8 columns content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __('Edit Project') ?></legend>
        <?php
            echo $this->Form->control('article_id');
            echo $this->Form->control('uuid');
            echo $this->Form->control('name');
            echo $this->Form->control('users._ids', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
