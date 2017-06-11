<?php
    $this->assign('title', __('Your Profile'));
?>
<nav class="nav topicpath">
    <?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content edit-user-content">
    <h1><?= $this->fetch('title') ?></h1>
    <section class="boxed-group">
        <h2><?= __('Name') ?></h2>
        <div class="boxed-group-inner">
            <?= $this->Flash->render() ?>
            <?= $this->Form->create($user) ?>
            <div class="form-group">
                <label class="control-label" for="name"><?= __('Nickname') ?></label>
                <div class="form-inline">
                    <?= $this->Form->text('nickname') ?>
                    <?= $this->Form->button(__('Update'), ['class' => 'btn-secondary']); ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </section>
    <section class="boxed-group">
        <h2><?= __('Email') ?></h2>
        <div class="boxed-group-inner">
            <?= $this->Flash->render('email') ?>
            <?= $this->Form->create($user) ?>
            <?= $this->Form->hidden('_email', ['value' => '1']) ?>
            <div class="form-group">
                <label class="control-label" for="name"><?= __('Email address') ?></label>
                <div class="form-inline">
                    <?= $this->Form->text('email') ?>
                    <?= $this->Form->button(__('Update'), ['class' => 'btn-secondary']); ?>
                </div>
                <?= $this->Form->error('email') ?>
            </div>
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
</div>
