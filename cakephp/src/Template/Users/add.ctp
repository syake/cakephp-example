<?php
    $this->assign('title', __('Welcome to CakePHP'));
?>
<div class="content add-user-content">
    <h1><?= __('Create your account') ?></h1>
    <?= $this->Form->create($user) . PHP_EOL ?>
        <fieldset class="field-content">
            <?= $this->Flash->render() ?>
            <?= $this->Form->control('username', ['help' => __('This will be your username.')]) . PHP_EOL ?>
            <?= $this->Form->control('email', ['help' => __('You will occasionally receive account related emails.')]) . PHP_EOL ?>
            <?= $this->Form->control('password', ['help' => __('Use at least one lowercase letter, one numeral, and 4 characters.')]) . PHP_EOL ?>
            <?= $this->Form->control('nickname') . PHP_EOL ?>
        </fieldset>
        <?= $this->Form->button(__('Create an account'), ['class' => 'btn-primary']) . PHP_EOL ?>
    <?= $this->Form->end() . PHP_EOL ?>
</div>
