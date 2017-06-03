<?php
    $this->assign('title', 'Edit Profile' );
?>
<nav class="nav topicpath">
    <?= $this->Html->link($topicpath_title, $topicpath_link, ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content edit-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Form->create($user) ?>
    <fieldset class="field-content">
        <p class="doc"><?= __('Edit your account') ?></p>
        <?= $this->Flash->render() ?>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->control('nickname') ?>
    </fieldset>
    <?= $this->Form->button(__('Update an account'), ['class' => 'btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
