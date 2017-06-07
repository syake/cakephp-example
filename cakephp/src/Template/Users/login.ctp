<?php
    $this->assign('title', __('Sign in to Your Page'));
?>
<div class="content login-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <fieldset class="field-content">
        <p class="doc"><?= __('Please enter your username and password') ?></p>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->button(__('Sign in'), ['class' => 'btn-primary btn-block']); ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <div class="create-account-content">
        <?= $this->Html->link('Create an account.', ['controller' => 'Users', 'action' => 'add'], ['class' => 'add-link']) ?>
    </div>
</div>
