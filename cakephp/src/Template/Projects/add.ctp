<?php
    $this->assign('title', __('Add Project'));
?>
<nav class="nav topicpath">
  <?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content form-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Form->create($project) ?>
    <?= $this->Form->hidden('users._id', ['value' => $user_id]) ?>
    <fieldset class="field-content">
        <p class="doc"><?= __('Create new project') ?></p>
        <?= $this->Flash->render() ?>
        <?= $this->Form->control('name') ?>
        <?= $this->Form->control('article_id') ?>
    </fieldset>
    <?= $this->Form->button(__('Create new project'), ['class' => 'btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
