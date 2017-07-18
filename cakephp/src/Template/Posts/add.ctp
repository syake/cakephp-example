<?php
    $this->assign('title', __('Create a new post'));
?>
<?= $this->element('Users/breadcrumb') ?>
<div class="content edit-post-content">
    <?= $this->Form->create($post, ['enctype' => 'multipart/form-data']) . PHP_EOL ?>
        <div class="title">
            <h1><?= $this->fetch('title') ?></h1>
            <ul class="controllers">
                <li><?= $this->Form->button(__('Save Draft'), ['class' => 'btn-secondary btn-sm']) ?></li>
                <li><?= $this->Form->button(__('Save &amp; Publish'), ['name' => 'publish', 'value' => '1', 'class' => 'btn-primary btn-sm']) ?></li>
            </ul>
        </div>
        <?= $this->Flash->render() ?>
        <div class="form">
<?= $this->element('Posts/form') ?>
        </div>
<!--
        <div class="row">
            <div class="col-md-9">
<?= $this->element('Posts/form') ?>
            </div>
            <div class="col-md-3">
                <section class="boxed-group">
                    <h2><?= __('Create') ?></h2>
                    <div class="boxed-group-inner">
                        <div class="boxed-group-section">
                            <?= $this->Form->control('publish', [
                                'label' => __('Publish'),
                                'type' => 'checkbox',
                                'checked',
                                'templates' => [
                                    'nestingLabel' => '{{hidden}}<label class="custom-control custom-checkbox"{{attrs}}>{{input}}{{text}}</label>'
                                ]
                            ]) ?>
                        </div>
                        <div class="boxed-group-section">
                            <?= $this->Form->button(__('Create new post'), ['class' => 'btn-primary']) . PHP_EOL ?>
                        </div>
                    </div>
                </section>
            </div>
-->
<!--         </div> -->
    <?= $this->Form->end() . PHP_EOL ?>
</div>
