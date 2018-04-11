<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!doctype html>
<html>
<head>
  <?= $this->Html->charset() . PHP_EOL ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->fetch('title') ?></title>
  <?= $this->Html->meta('icon') . PHP_EOL ?>
  <?= $this->Html->css('editor.css') . PHP_EOL ?>
  <?= $this->Html->script('editor.js') . PHP_EOL ?>
  <?= $this->fetch('meta') . PHP_EOL ?>
</head>
<body>
<?= $this->fetch('content') ?>
<?= $this->Element('admin_footer', ['class' => 'bd-footer']) ?>
<?= $this->fetch('postLink') ?>
</body>
</html>
