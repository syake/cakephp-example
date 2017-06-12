<?php
    $this->assign('title', __('Create a new post'));
?>
<nav class="nav topicpath">
  <?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content add-post-content">
    <div class="title">
        <h1><?= $this->fetch('title') ?></h1>
    </div>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($post) ?>
    <div class="row">
        <div class="col-md-9">
            <section class="boxed-group">
                <h2><?= __('New Content') ?></h2>
                <div class="boxed-group-inner">
                    <?= $this->Form->control('title', ['label' => __('Title')]) ?>
                    <?= $this->Form->control('content', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) ?>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="boxed-group">
                <h2><?= __('Create') ?></h2>
                <div class="boxed-group-inner">
                    <div class="boxed-group-section">
                        <?= $this->Form->control('status', [
                            'label' => __('Publish'),
                            'type' => 'checkbox',
                            'checked',
                            'templates' => [
                                'nestingLabel' => '{{hidden}}<label class="custom-control custom-checkbox"{{attrs}}>{{input}}{{text}}</label>'
                            ]
                        ]) ?>
                    </div>
                    <div class="boxed-group-section">
                        <?= $this->Form->button(__('Create new post'), ['class' => 'btn-primary']); ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
