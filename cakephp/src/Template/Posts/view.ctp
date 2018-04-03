<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\post $post
 */
$this->assign('title', $post->title);
?>
<!DOCTYPE html>
<html>
<head>
  <?= $this->Html->charset() . PHP_EOL ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->fetch('title') ?></title>
  <?= $this->Html->css('style.css') . PHP_EOL ?>
  <?= $this->fetch('meta') . PHP_EOL ?>
  <?= $this->fetch('css') . PHP_EOL ?>
</head>
<body>
  <nav class="site-header sticky-top py-1">
    <div class="container d-flex flex-column flex-md-row justify-content-between">
      <a class="py-2" href="#"><?= $this->fetch('title') ?></a>
<?php foreach ($post->sections as $i => $section): ?>
      <a class="py-2 d-none d-md-inline-block" href="#p<?= $i ?>"><?= $section->title ?></a>
><?php endforeach; ?>
    </div>
  </nav>

  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
      <h1 class="display-4 font-weight-normal">Punny headline</h1>
      <p class="lead font-weight-normal"><?= $post->description ?></p>
    </div>
  </div>

  <main id="content" role="main" class="p-3">
<?php foreach ($post->sections as $i => $section): ?>
    <section id="p<?= $i ?>" class="mb-5">
      <h2><?= $section->title ?></h2>
      <p><?= $section->description ?></p>
      <div class="row">
<?php if ($section->cells) : foreach ($section->cells as $cell): ?>
<?php if ($section->style == 'images'): ?>
        <div class="col-sm-3">
          <div class="mb-4">
            <?= $this->Html->image(['controller' => 'Images', 'action' => 'view', 'width' => '640', 'height' => '480', 'id' => $cell->image_name], ['width' => '100%']) ?>
          </div>
        </div>
<?php endif; ?>
<?php if ($section->style == 'items' && $cell->image_name): ?>
        <div class="col-sm-4">
          <div class="card mb-4 box-shadow">
            <?= $this->Html->image(['controller' => 'Images', 'action' => 'view', 'width' => '640', 'height' => '480', 'id' => $cell->image_name], ['width' => '100%']) ?>
            <div class="card-body">
              <h3 class="card-title"><?= $cell->title ?></h3>
              <p class="card-text"><?= $cell->description ?></p>
              <div class="text-right">
                <small class="text-muted"><?= $this->Time->format($cell->modified ?: time(), 'yyyy-MM-dd') ?></small>
              </div>
            </div>
          </div>
        </div>
<?php endif; ?>
<?php if ($section->style == 'values'): ?>
        <div class="col-sm-12">
          <div class="media pt-3 pb-3 border-bottom border-gray">
            <div class="media-time text-muted mr-3">
              <?= $this->Time->format($cell->modified ?: time(), 'yyyy-MM-dd') ?>
            </div>
            <div class="media-title">
              <?= h($cell->title) ?>
            </div>
          </div>
        </div>
<?php endif; ?>
<?php endforeach; endif; ?>
      </div>
    </section>
<?php endforeach; ?>
  </main>
  <footer role="contentinfo">
    <div class="container-fluid p-3 p-md-5 text-muted">
      <p><?= COPY_RIGHT ?></p>
    </div>
  </footer>
<?= $this->fetch('script') ?>
</body>
</html>
