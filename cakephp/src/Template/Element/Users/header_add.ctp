<header class="navbar navbar-expand navbar-dark bg-dark box-shadow">
    <div class="container d-flex justify-content-between">
        <h1 class="navbar-brand mb-0"><?= $this->fetch('title') ?></h1>
        <ul class="navbar-nav flex-row ml-md-auto dnone d-md-flex">
            <li class="nav-item dropdown">
                <?= $this->Html->link(__('Sign in'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']) ?>
            </li>
        </ul>
    </div>
</header>
