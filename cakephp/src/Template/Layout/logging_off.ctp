<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<?= $this->Element('admin_headmeta') ?>
<body>
  <header class="navbar navbar-expand navbar-dark flex-row bd-navbar">
    <a href="/" class="navbar-brand mr-0 mr-md-2"><?= SITE_TITLE ?></a>
    <ul class="navbar-nav flex-row ml-auto d-md-flex">
      <li class="nav-item"><?= $this->Html->link(__('Sign in'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link login-link']) ?></li>
    </ul>
  </header>
  <main id="content" role="main">
    <?= $this->Flash->render() . PHP_EOL ?>
    <?= $this->fetch('content') ?>
  </main>
<?= $this->Element('admin_footer', ['class' => 'bd-footer']) ?>
<?= $this->fetch('postLink') ?>
<?= $this->fetch('script') ?>
</body>
</html>
