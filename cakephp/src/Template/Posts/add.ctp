<?php
    $this->assign('title', __('Create a new post'));
?>
<nav class="nav topicpath">
  <?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content add-post-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Form->create($post) ?>
    <?= $this->Form->hidden('users._id', ['value' => $user_id]) ?>
    <?= $this->Form->control('articles.0.title', ['label' => __('Title'), 'value' => __('Title Name')]) ?>
    <?= $this->Form->control('articles.0.content', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) ?>
    <?= $this->Form->control('publish', ['label' => __('Publish'), 'checked']) ?>
    <hr>
    <?= $this->Form->button(__('Create new post'), ['class' => 'btn-primary']); ?>
    <?= $this->Form->end() ?>
</div>
