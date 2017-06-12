<?php
    $this->assign('title', __('Edit Post'));
    if ($post->publish) {
        $status = __('Publish');
        $badge_label = __('Publish');
        $badge_style = 'badge-success';
    } else {
        $status = __('Private');
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
    </div>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($article) ?>
    <div class="row">
        <div class="col-md-9">
            <section class="boxed-group">
                <h2><?= __('Edit Content') ?></h2>
                <div class="boxed-group-inner">
                    <?= $this->Form->control('title', ['label' => __('Title')]) ?>
                    <?= $this->Form->control('content', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) ?>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="boxed-group">
                <h2><?= $status ?></h2>
                <div class="boxed-group-inner">
                    <div class="boxed-group-section">
                        <?= $this->Html->link(__('Preview'), ['controller' => 'Posts', 'action' => 'view', $article->id], ['class' => 'view-link', 'target' => '_blank']) ?>
                    </div>
                    <div class="boxed-group-section">
                        <dl class="status-list">
                            <dt><?= __('Date Modified:') ?></dt>
                            <dd><?= $this->Time->format($article->modified, 'yyyy/MM/dd HH:mm') ?></dd>
                        </dl>
                    </div>
                </div>
                <div class="boxed-group-footer">
                    <?= $this->Form->button(__('Save'), ['class' => 'btn-secondary']); ?>
                </div>
            </section>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
