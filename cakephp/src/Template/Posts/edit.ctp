<?php
    $this->assign('title', __('Edit Post'));
    if ($project->status) {
        $badge_label = __('Publish');
        $badge_style = 'badge-success';
    } else {
        $badge_label = __('Private');
        $badge_style = 'badge-default';
    }
?>
<?= $this->element('Users/breadcrumb') ?>
<div class="content edit-post-content">
    <div class="title">
        <h1><?= $this->fetch('title') ?><span class="badge badge-pill <?= $badge_style ?>"><?= $badge_label ?></span></h1>
    </div>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($post, ['enctype' => 'multipart/form-data']) . PHP_EOL ?>
        <div class="row">
            <div class="col-md-9">
    <?= $this->element('Posts/form') ?>
            </div>
            <div class="col-md-3">
                <section class="boxed-group">
                    <h2><?= __('Publish') ?></h2>
                    <div class="boxed-group-inner">
                        <div class="boxed-group-section">
                            <?= $this->Html->link(__('Preview'), ['controller' => 'Posts', 'action' => 'view', $post->id], ['class' => 'view-link', 'target' => '_blank']) . PHP_EOL ?>
                        </div>
                        <div class="boxed-group-section">
                            <dl class="status-list">
                                <dt><?= __('Project ID:') ?></dt>
                                <dd><?= $project->uuid ?></dd>
                                <dt><?= __('Date Modified:') ?></dt>
                                <dd><?= $this->Time->format($post->modified, 'yyyy/MM/dd HH:mm') ?></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="boxed-group-footer">
                        <?= $this->Form->button(__('Save'), ['class' => 'btn-secondary']) . PHP_EOL ?>
                    </div>
                </section>
            </div>
        </div>
    <?= $this->Form->end() . PHP_EOL ?>
</div>
