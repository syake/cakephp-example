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
<html lang="ja">
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?= $this->fetch('meta') . PHP_EOL ?>
  <title><?= $this->fetch('title') ?></title>
  <?= $this->Html->meta('icon') . PHP_EOL ?>
  <?= $this->Html->css('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') . PHP_EOL ?>
  <?= $this->Html->css('admin.css') . PHP_EOL ?>
  <?= $this->fetch('css') ?>
</head>
<body class="<?= $style ?>">
  <main>
    <main id="content" role="main">
      <?= $this->Flash->render() . PHP_EOL ?>
      <?= $this->fetch('content') ?>
    </div>
  </main>
  <footer>
    <footer class="login-footer text-muted">
      <div class="container-fluid p-3 p-md-5">
        <p class="copyright"><?= COPY_RIGHT ?></p>
      </div>
    </div>
  </footer>
<?= $this->Html->script('//code.jquery.com/jquery-3.2.1.min.js', ['crossorigin' => 'anonymous', 'integrity' => 'sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=']) . PHP_EOL ?>
<?= $this->Html->script('//code.jquery.com/ui/1.12.1/jquery-ui.min.js', ['crossorigin' => 'anonymous', 'integrity' => 'sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=']) . PHP_EOL ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?= $this->Html->script('admin.js') . PHP_EOL ?>
<?= $this->fetch('script') ?>
</body>
</html>
