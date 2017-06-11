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
<?php if ($is_admin) : ?>
    <section class="boxed-group">
        <h2><?= __('Users') ?></h2>
        <div class="boxed-group-inner boxed-group-inner-table">
            <?= $this->Flash->render('users') ?>
            <table class="table table-sm">
                <thead>
                    <?= $this->Html->tableHeaders([
                        __('Username'),
                        __('Role')
                    ]) ?>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= h($user->username) ?></td>
                        <td><?= h($user->_joinData->role) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="boxed-group-inner">
            <?= $this->Form->create($post) ?>
            <?php foreach($users as $user): ?>
            <?= $this->Form->hidden('users._ids[]', ['value' => $user->id]) ?>
            <?php endforeach; ?>
            <div class="form-group text required">
                <label class="control-label" for="name"><?= __('User Name') ?></label>
                <div class="form-inline">
                    <?= $this->Form->text('users._username') ?>
                    <?= $this->Form->button(__('Add'), ['class' => 'btn-secondary']); ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </section>
    <section class="boxed-group">
        <h2><?= __('Settings') ?></h2>
        <div class="boxed-group-inner boxed-group-row">
            <?= $this->Form->create($post) ?>
            <?php if ($post->publish) : ?>
                <?= $this->Form->button(__('Make private'), ['class' => 'btn-secondary js-confirm', 'data-confirm' => __('Are you sure you want to private?'), 'name' => 'publish', 'value' => '0']); ?>
                <p class="doc"><strong><?= __('Make this post private') ?></strong></p>
            <?php else: ?>
                <?= $this->Form->button(__('Make publish'), ['class' => 'btn-secondary js-confirm', 'data-confirm' => __('Are you sure you want to publish?'), 'name' => 'publish', 'value' => '1']); ?>
                <p class="doc"><strong><?= __('Make this post publish') ?></strong></p>
            <?php endif; ?>
            <?= $this->Form->end() ?>
        </div>
        <div class="boxed-group-inner boxed-group-row">
            <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $post->id],
                    ['class' => 'btn btn-secondary btn-delete', 'role' => 'button', 'aria-pressed' => 'true', 'confirm' => __('Are you sure you want to delete # {0}?', $post->id)]
                )
            ?>
            <p class="doc"><strong><?= __('Delete this post') ?></strong></p>
        </div>
    </section>
<?php endif; ?>
</div>
