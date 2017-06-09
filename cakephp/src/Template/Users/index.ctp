<?php
    $this->assign('title', 'Hello ' . $user_name );
?>
<div class="content index-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Flash->render() ?>
    <?php if (count($posts) > 0) : ?>
    <section class="posts">
        <h2><?= __('List Posts') ?></h2>
        <table class="table table-striped table-bordered">
            <thead>
                <?= $this->Html->tableHeaders([
                    ['#' => ['class' => 'num']],
                    __('Title'),
                    __('Author'),
                    __('Publish'),
                    'modified',
                    '',
                    ''
                ]) ?>
            </thead>
            <tbody>
                <?php foreach($posts as $i => $post): ?>
                <?php
                  if ($post->publish) {
                      $publish_icon = 'fa-check-circle';
                  }  else {
                      $publish_icon = 'fa-ban';
                  }
                ?>
                <tr>
                    <td class="num"><?= $i ?></td>
                    <td><?= h($post->title) ?></td>
                    <td><?= h($post->author) ?></td>
                    <td><i class="fa <?= $publish_icon ?>" aria-hidden="true"></i></td>
                    <td><?= $this->Time->format($post->modified, 'yyyy/MM/dd HH:mm') ?></td>
                    <td><?= $this->Html->link(__('View'), ['controller' => 'Posts', 'id' => $post->uuid], ['class' => 'view-link', 'target' => '_blank']) ?></td>
                    <td><?= $this->Html->link(__('Edit'), ['controller' => 'Posts', 'action' => 'edit', $post->id], ['class' => 'edit-link']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <?php endif; ?>
    <?= $this->Html->link('Create new post', ['controller' => 'Posts', 'action' => 'add'], ['class' => 'add-link']) ?>
</div>
