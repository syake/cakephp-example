<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projects posts
 */
$this->assign('title', __('Projects') . ' | ' . __(SITE_TITLE));
?>
<div class="posts-index-content">
        <div class="container">
<?php if (count($posts) > 0) : ?>
          <section class="my-3 p-3 bg-white rounded box-shadow">
            <h6 class="border-bottom border-gray pb-2 mb-0"><?= __('Projects') ?></h6>
<?php
    foreach($posts as $i => $post):
        if ($post->status) {
            $status_icon = 'fa-check-circle';
        }  else {
            $status_icon = 'fa-ban';
        }
?>
            <div class="media text-muted pt-3">
              <img data-src="holder.js/32x32?theme=thumb&amp;bg=007bff&amp;fg=007bff&amp;size=1" alt="" class="mr-2 rounded" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_161c20afb43%20text%20%7B%20fill%3A%23007bff%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_161c20afb43%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23007bff%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2211.828125%22%20y%3D%2217.0078125%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
              <div class="media-body pb-3 mb-0 small border-bottom border-gray">
                <div class="d-flex justify-content-between align-items-center w-100">
                  <?= $this->Html->link($post->id, ['controller' => 'Posts', 'action' => 'edit', $post->id], ['class' => 'post_id']) ?>
                  <i class="fa <?= $status_icon ?>" aria-hidden="true"></i>
                </div>
                <strong><?= h($post->title) ?></strong>
                <span class="d-block"><?= h($post->author) ?> - <?= __('Last Update') ?> <?= $this->Time->format($post->modified, 'yyyy-MM-dd HH:mm') ?></span>
              </div>
            </div>
<?php endforeach; ?>
            <small class="d-block text-muted text-right mt-3">
              <?= $this->Paginator->counter(['format' => __('{{count}} items') . '<span class="pages">{{page}} / {{pages}}</span>']) ?>
            </small>
          </section>
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first() ?>
                <?= $this->Paginator->numbers(['modulus' => 4]); ?>
                <?= $this->Paginator->last() ?>
            </ul>
          </nav>
<?php endif; ?>
          <?= $this->Html->link(__('Create new post'), ['controller' => 'Posts', 'action' => 'add'], ['class' => 'add-link']) . PHP_EOL ?>
        </div>
      </div>

