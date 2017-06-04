<!doctype html>
<html lang="ja">
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?= $this->fetch('title') ?> | Users</title>
<?= $this->Html->css('//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css') ?>
<?= $this->Html->css('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') ?>
<?= $this->Html->css('users.css') ?>
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
<?= $this->Html->script('//code.jquery.com/jquery-3.1.1.slim.min.js') ?>
<?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js') ?>
<?= $this->Html->script('//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js') ?>
<?= $this->Html->script('users.js') ?>
<?= $this->fetch('script') ?>
</body>
</html>
