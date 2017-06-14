<?php
    $this->assign('title', __('Sign in to Your Page'));
?>
<div class="content login-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() . PHP_EOL ?>
        <fieldset class="field-content">
            <p class="doc"><?= __('Please enter your username and password') ?></p>
            <?= $this->Form->control('username') . PHP_EOL ?>
            <?= $this->Form->control('password') . PHP_EOL ?>
            <?= $this->Form->button(__('Sign in'), ['class' => 'btn-primary btn-block']) . PHP_EOL ?>
        </fieldset>
    <?= $this->Form->end() . PHP_EOL ?>
    <div class="create-account-content">
        <?= $this->Html->link('Create an account.', ['controller' => 'Users', 'action' => 'add'], ['class' => 'add-link']) . PHP_EOL ?>
    </div>
</div>
