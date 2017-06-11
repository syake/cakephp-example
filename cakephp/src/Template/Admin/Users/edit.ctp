<?php
    $this->assign('title', __('Edit User Profile'));
?>
<nav class="nav topicpath">
  <?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content edit-user-content">
    <h1><?= $this->fetch('title') ?></h1>
    <section class="boxed-group">
        <h2><?= __('Edit user account') ?></h2>
        <div class="boxed-group-inner">
            <?= $this->Flash->render() ?>
            <?= $this->Form->create($user) ?>
            <?= $this->Form->control('username') ?>
            <?= $this->Form->control('email') ?>
            <?= $this->Form->control('nickname') ?>
            <?= $this->Form->control('role', [
                    'type' => 'radio',
                    'options' => [
                        ['value' => 'admin', 'text' => 'Admin'],
                        ['value' => 'author', 'text' => 'Author']
                    ],
                    'templates' => [
                        'formGroup' => '{{label}}<div class="radio-group">{{input}}</div>'
                    ]
                ]) ?>
                <?= $this->Form->control('status', ['label' => __('Publish')]) ?>
            <?= $this->Form->button(__('Update an account'), ['class' => 'btn-secondary']); ?>
            <?= $this->Form->end() ?>
        </div>
    </section>
    <section class="boxed-group">
        <h2><?= __('Password') ?></h2>
        <div class="boxed-group-inner">
            <?= $this->Flash->render('password') ?>
            <?= $this->Form->create($user) ?>
            <?= $this->Form->hidden('_password', ['value' => '1']) ?>
            <?= $this->Form->control('password', ['type' => 'password', 'label' => __('New password'), 'value' => '']) ?>
            <?= $this->Form->button(__('Update password'), ['class' => 'btn-secondary']); ?>
            <?= $this->Form->end() ?>
        </div>
    </section>
    <section class="boxed-group">
        <h2><?= __('Delete') ?></h2>
        <div class="boxed-group-inner boxed-group-row">
            <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $user->id],
                    ['class' => 'btn btn-secondary btn-delete', 'role' => 'button', 'aria-pressed' => 'true', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
                )
            ?>
            <p class="doc"><strong><?= __('Delete this user') ?></strong></p>
        </div>
    </section>
</div>
