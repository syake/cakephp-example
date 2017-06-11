<nav class="navbar navbar-inverse bg-inverse">
    <div class="container">
        <div class="navbar-nav navbar-toggler-right">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i></a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                    <li class="dropdown-header">Signed in as <?= $user_name ?></li>
                    <li class="dropdown-divider" role="separator"></li>
                    <li class="dropdown-item"><?= $this->Html->link(__('Edit Profile'), ['controller' => 'Users', 'action' => 'edit', 'prefix' => false]) ?></li>
                    <li class="dropdown-divider" role="separator"></li>
                    <li class="dropdown-item"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
                    <li class="dropdown-divider" role="separator"></li>
                    <li class="dropdown-item"><?= $this->Html->link(__('Sign out'), ['controller' => 'Users', 'action' => 'logout', 'prefix' => false]) ?></li>
                </ul>
            </div>
        </div>
        <?= $this->Html->link(__('Users'), ['controller' => 'Users', 'action' => 'index', 'prefix' => false], ['class' => 'navbar-brand']) ?>
    </div>
</nav>
