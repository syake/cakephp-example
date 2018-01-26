<!doctype html>
<html lang="ja">
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?= $this->fetch('meta') . PHP_EOL ?>
<title><?= $this->fetch('title') ?></title>
<?= $this->Html->meta('icon') . PHP_EOL ?>
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
<?= $this->Html->script('//code.jquery.com/jquery-3.2.1.min.js', ['crossorigin' => 'anonymous', 'integrity' => 'sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=']) . PHP_EOL ?>
<?= $this->Html->script('//code.jquery.com/ui/1.12.1/jquery-ui.min.js', ['crossorigin' => 'anonymous', 'integrity' => 'sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=']) . PHP_EOL ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?= $this->Html->script('admin.js') . PHP_EOL ?>
<?= $this->fetch('script') ?>
</body>
</html>
