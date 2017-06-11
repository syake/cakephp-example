<?php
    $this->assign('title', __('Edit Post'));
    if ($post->publish) {
        $badge_label = __('Publish');
        $badge_style = 'badge-success';
    } else {
        $badge_label = __('Private');
        $badge_style = 'badge-default';
    }
?>
<nav class="nav topicpath">
  <?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content edit-post-content">
    <div class="title">
        <h1><?= $this->fetch('title') ?><span class="badge badge-pill <?= $badge_style ?>"><?= $badge_label ?></span></h1>
        <div class="nav">
            <?= $this->Html->link(__('Preview'), ['controller' => 'Posts', 'action' => 'view', $article->id], ['class' => 'view-link', 'target' => '_blank']) ?>
        </div>
    </div>
    <?= $this->Flash->render() ?>
    <section class="boxed-group">
        <h2><?= __('Edit Content') ?></h2>
        <div class="boxed-group-inner">
            <?= $this->Flash->render('article') ?>
            <?= $this->Form->create($article) ?>
            <?= $this->Form->hidden('article', ['value' => 'update']) ?>
            <?= $this->Form->control('title', ['label' => __('Title')]) ?>
            <?= $this->Form->control('content', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) ?>
            <?= $this->Form->button(__('Update'), ['class' => 'btn-secondary']); ?>
            <?= $this->Form->end() ?>
        </div>
    </section>
</div>
