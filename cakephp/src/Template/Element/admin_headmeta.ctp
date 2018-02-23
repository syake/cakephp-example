<head>
  <?= $this->Html->charset() . PHP_EOL ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->fetch('title') ?></title>
  <?= $this->Html->meta('icon') . PHP_EOL ?>
  <?= $this->Html->css('admin.css') . PHP_EOL ?>
  <?= $this->fetch('meta') . PHP_EOL ?>
  <?= $this->fetch('css') . PHP_EOL ?>
</head>
