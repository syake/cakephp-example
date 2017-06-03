<?php
    $this->assign('title', 'Add User');
?>
<div class="content add-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Form->create($user) ?>
    <fieldset class="field-content">
        <p class="doc"><?= __('Create your account') ?></p>
        <?= $this->Flash->render() ?>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->control('nickname') ?>
    </fieldset>
    <?= $this->Form->button(__('Create an account'), ['class' => 'btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
