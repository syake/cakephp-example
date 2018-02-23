<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projects posts
 */
$this->assign('title', __('Projects') . ' | ' . __(SITE_TITLE));
?>
<div class="posts-index-content">
        <section class="container">
          <h1><?= __('Projects') ?></h1>
<?php if (count($posts) > 0) : ?>
          <table class="table table-striped table-bordered">
            <thead>
              <?= $this->Html->tableHeaders([
                    [$this->Paginator->sort('id', '#') => ['class' => 'num']],
                    $this->Paginator->sort('id', __('Project ID')),
                    $this->Paginator->sort('Articles.title', __('Title')),
                    __('Author'),
                    $this->Paginator->sort('status', __('Status')),
                    $this->Paginator->sort('Articles.modified', __('Last Updated')),
                    '',
                    '',
                    ''
                ]) ?>
            </thead>
            <tbody>
<?php
    foreach($posts as $i => $post):
        if ($post->status) {
            $status_icon = 'fa-check-circle';
        }  else {
            $status_icon = 'fa-ban';
        }
?>
                <tr>
                    <td class="num"><?= $i ?></td>
                    <td><?= h($post->id) ?></td>
                    <td><?= h($post->title) ?></td>
                    <td><?= h($post->author) ?></td>
                    <td class="status"><i class="fa <?= $status_icon ?>" aria-hidden="true"></i></td>
                    <td><?= $this->Time->format($post->modified, 'yyyy/MM/dd HH:mm') ?></td>
                    <td><?= $this->Html->link(__('View'), ['controller' => 'Posts', 'action' => 'display', 'id' => $post->id], ['class' => 'view-link', 'target' => '_blank']) ?></td>
                    <td><?= $this->Html->link(__('Edit'), ['controller' => 'Posts', 'action' => 'edit', $post->id], ['class' => 'edit-link']) ?></td>
                    <td><?php if ($post->_matchingData['ProjectsUsers']['role'] == 'admin') : ?>
                        <?= $this->Html->link(__('Setup'), ['controller' => 'Projects', 'action' => 'edit', $post->id], ['class' => 'setup-link']) ?>
                    <?php endif; ?></td>
                </tr>
<?php endforeach; ?>
            </tbody>
          </table>
          <nav aria-label="Page navigation">
            <p class="pagination-help"><?= $this->Paginator->counter(['format' => __('{{count}} items') . '<span class="pages">{{page}} / {{pages}}</span>']) ?></p>
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first() ?>
                <?= $this->Paginator->numbers(['modulus' => 4]); ?>
                <?= $this->Paginator->last() ?>
            </ul>
          </nav>
<?php endif; ?>
          <?= $this->Html->link(__('Create new post'), ['controller' => 'Posts', 'action' => 'add'], ['class' => 'add-link']) . PHP_EOL ?>
        </section>
      </div>

