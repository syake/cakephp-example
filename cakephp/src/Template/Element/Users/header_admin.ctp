<header class="navbar navbar-expand navbar-dark bg-dark box-shadow">
    <div class="container d-flex justify-content-between">
        <?= $this->Html->link(__('Users'), ['controller' => 'Users', 'action' => 'index', 'prefix' => false], ['class' => 'navbar-brand']) ?>
        <ul class="navbar-nav flex-row ml-md-auto dnone d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-item nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i></a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                    <li class="dropdown-header">Signed in as <?= $user_name ?></li>
                    <li class="dropdown-divider" role="separator"></li>
                    <li class="dropdown-item"><?= $this->Html->link(__('Edit Profile'), ['controller' => 'Users', 'action' => 'edit', 'prefix' => false]) ?></li>
                    <li class="dropdown-divider" role="separator"></li>
                    <li class="dropdown-item"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin']) ?></li>
                    <li class="dropdown-divider" role="separator"></li>
                    <li class="dropdown-item"><?= $this->Html->link(__('Sign out'), ['controller' => 'Users', 'action' => 'logout', 'prefix' => false]) ?></li>
                </div>
            </li>
        </ul>
    </div>
</header>
