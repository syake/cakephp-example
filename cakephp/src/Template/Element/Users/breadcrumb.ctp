<nav class="breadcrumb">
<?php if ($referer == 'users'): ?>
    <?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin'], ['class' => 'breadcrumb-item back-link']) . PHP_EOL ?>
<?php else: ?>
    <?= $this->Html->link(__('Home'), ['controller' => 'Projects', 'action' => 'index', 'prefix' => false], ['class' => 'breadcrumb-item back-link']) . PHP_EOL ?>
<?php endif; ?>
</nav>
