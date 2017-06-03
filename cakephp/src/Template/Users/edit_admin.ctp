<?php
    $this->assign('title', 'Edit User Profile' );
?>
<nav class="nav topicpath">
  <?= $this->Html->link($topicpath_title, $topicpath_link, ['class' => 'nav-link back-link']) ?>
</nav>
<div class="content edit-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Form->create($user) ?>
    <fieldset class="field-content">
        <p class="doc"><?= __('Edit user account') ?></p>
        <?= $this->Flash->render() ?>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->control('nickname') ?>
        <?= $this->Form->control('role', [
            'type' => 'radio',
            'options' => [
                ['value' => 'admin', 'text' => 'Admin'],
                ['value' => 'author', 'text' => 'Author'],
                ['value' => 'invalid', 'text' => 'Invalid']
            ],
            'templates' => [
                'formGroup' => '{{label}}<div class="radio-group">{{input}}</div>',
                'radioWrapper' => '{{label}}',
                'nestingLabel' => '{{hidden}}<label class="custom-control custom-radio"{{attrs}}>{{input}}{{text}}</label>',
                'radio' => '<input type="radio" name="{{name}}" value="{{value}}" class="custom-control-input"{{attrs}}><span class="custom-control-indicator"></span><span class="custom-control-description">{{text}}</span>'
            ]
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('Update an account'), ['class' => 'btn-primary']); ?>
    <?= $this->Form->end() ?>
    <?= $this->Form->postLink(
            __('Delete'),
            ['action' => 'delete', $user->id],
            ['class' => 'btn btn-secondary btn-delete', 'role' => 'button', 'aria-pressed' => 'true', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
        )
    ?>
</div>
