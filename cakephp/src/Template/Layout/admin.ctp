<!doctype html>
<html lang="ja">
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?= $this->fetch('title') ?></title>
<?= $this->Html->css('//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css') . PHP_EOL ?>
<?= $this->Html->css('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') . PHP_EOL ?>
<?= $this->Html->css('admin.css') . PHP_EOL ?>
<?= $this->fetch('css') ?>
</head>
<body class="<?= $style ?>">
<?= $this->element($header) ?>
<main>
<div class="container">
<?= $this->fetch('content') ?>
</div>
</main>
<footer>
    <div class="container">
        <p class="copyright">&copy; 2017</p>
    </div>
</footer>
<?= $this->Html->script('//code.jquery.com/jquery-3.1.1.slim.min.js') . PHP_EOL ?>
<?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js') . PHP_EOL ?>
<?= $this->Html->script('//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js') . PHP_EOL ?>
<?= $this->Html->script('admin.js') . PHP_EOL ?>
<?= $this->fetch('script') ?>
</body>
</html>
