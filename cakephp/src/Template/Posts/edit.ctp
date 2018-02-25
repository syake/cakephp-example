<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projects posts
 */
$this->assign('title', __('Edit Post') . ' | ' . __(SITE_TITLE));
if ($post->status) {
      $badge_label = __('Publish');
      $badge_style = 'badge-success';
  } else {
      $badge_label = __('Private');
      $badge_style = 'badge-default';
  }
?>
<?= $this->Form->create($post, ['enctype' => 'multipart/form-data']) . PHP_EOL ?>
  <header class="navbar navbar-expand navbar-dark flex-row bd-navbar">
    <a href="/" class="navbar-brand mr-0 mr-md-2"><?= __(SITE_TITLE) ?></a>
    <ul class="navbar-nav flex-row ml-auto d-md-flex">
      <li class="nav-item"><?= $this->Form->button(__('Save'), ['class' => 'btn-outline-light btn-sm']) ?></li>
    </ul>
  </header>
  <main id="content" role="main">
    <div class="posts-edit-content py-4">
      <div class="container">
        <div class="d-flex justify-content-between mb-3">
          <h4 class="mb-3"><?= __('Edit Post') ?></h4>
          <span class="d-block small text-muted"><?= __('Last Update') ?>  <time><?= $this->Time->format($post->modified, 'yyyy-MM-dd HH:mm') ?></time></span>
        </div>
        <?= $this->Flash->render() . PHP_EOL ?>
        <fieldset class="bd-fieldset">
          <?= $this->Form->control('title', ['label' => __('Title')]) . PHP_EOL ?>
          <?= $this->Form->control('content', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) . PHP_EOL ?>
        </fieldset>
      </div>
    </div>
  </main>
<?= $this->Form->end() . PHP_EOL ?>

<?php /*
<?= $this->element('Users/breadcrumb') ?>
<div class="content edit-post-content">
    <?= $this->Form->create($post, ['enctype' => 'multipart/form-data']) . PHP_EOL ?>
        <div class="title">
            <h1><?= $this->fetch('title') ?><span class="badge badge-pill <?= $badge_style ?>"><?= $badge_label ?></span></h1>
            <ul class="controllers">
                <li><?= $this->Html->link(__('Preview'), ['controller' => 'Posts', 'action' => 'view', $post->id], ['class' => 'view-link btn btn-secondary btn-sm', 'target' => '_blank']) ?></li>
                <li><?= $this->Form->button(__('Save'), ['class' => 'btn-secondary btn-sm']) ?></li>
            </ul>
        </div>
        <?= $this->Flash->render() ?>
        <div class="status">
            <dl class="project_id">
                <dt><?= __('Project ID:') ?></dt>
                <dd><?= $project->uuid ?></dd>
            </dl>
            <dl class="modified">
                <dt><?= __('Date Modified:') ?></dt>
                <dd><?= $this->Time->format($post->modified, 'yyyy/MM/dd HH:mm') ?></dd>
            </dl>
        </div>
        <div class="form">
<?= $this->element('Posts/form') ?>
        </div>
    <?= $this->Form->end() . PHP_EOL ?>
</div>
*/
?>
