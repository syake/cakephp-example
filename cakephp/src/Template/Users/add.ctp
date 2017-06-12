<?php
    $this->assign('title', __('Welcome to CakePHP'));
?>
<div class="content add-user-content">
    <h1><?= __('Create your account') ?></h1>
    <?= $this->Form->create($user) ?>
    <fieldset class="field-content">
        <?= $this->Flash->render() ?>
        <?= $this->Form->control('username', ['help' => __('This will be your username.')]) ?>
        <?= $this->Form->control('email', ['help' => __('You will occasionally receive account related emails.')]) ?>
        <?= $this->Form->control('password', ['help' => __('Use at least one lowercase letter, one numeral, and 4 characters.')]) ?>
        <?= $this->Form->control('nickname') ?>
    </fieldset>
    <?= $this->Form->button(__('Create an account'), ['class' => 'btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
