<nav class="navbar navbar-inverse bg-inverse">
    <div class="container">
        <div class="navbar-nav navbar-toggler-right">
            <?= $this->Html->link(__('Sign in'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']) ?>
        </div>
        <div class="navbar-brand">
            <?= $this->fetch('title') ?>
        </div>
    </div>
</nav>
