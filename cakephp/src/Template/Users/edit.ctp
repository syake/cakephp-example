<?php
    $this->assign('title', __('Edit Profile'));
?>
<nav class="nav topicpath">
<?php if ($backto_list): ?>
    <?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'lookup'], ['class' => 'nav-link back-link']) ?>
<?php else: ?>
    <?= $this->Html->link(__('Home'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link back-link']) ?>
<?php endif; ?>
</nav>
<div class="content">
    <h1><?= $this->fetch('title') ?></h1>
    <div class="form-container">
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
</div>
