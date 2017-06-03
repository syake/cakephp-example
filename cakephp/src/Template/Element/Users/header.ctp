<nav class="navbar navbar-inverse bg-inverse">
    <div class="container">
        <div class="navbar-nav navbar-toggler-right">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user"></i></a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                    <li class="dropdown-header">Signed in as <?= $user_name ?></li>
                    <li class="dropdown-divider" role="separator"></li>
                    <li class="dropdown-item"><?= $this->Html->link(__('Edit Profile'), '/users/edit') ?></li>
                    <li class="dropdown-divider" role="separator"></li>
<?php if ($user_role == 'admin') : ?>
                    <li class="dropdown-item"><?= $this->Html->link(__('List Users'), '/users/lookup') ?></li>
                    <li class="dropdown-divider" role="separator"></li>
<?php endif; ?>
                    <li class="dropdown-item"><?= $this->Html->link(__('Sign out'), '/users/logout') ?></li>
                </ul>
            </div>
        </div>
        <?= $this->Html->link(__('Users'), '/users', ['class' => 'navbar-brand']) ?>
    </div>
</nav>
