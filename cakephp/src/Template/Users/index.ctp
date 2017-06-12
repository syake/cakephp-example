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
                    __('Status'),
                    'modified',
                    '',
                    '',
                    ''
                ]) ?>
            </thead>
            <tbody>
                <?php foreach($posts as $i => $post): ?>
                <?php
                  if ($post->status) {
                      $status_icon = 'fa-check-circle';
                  }  else {
                      $status_icon = 'fa-ban';
                  }
                  $articles = $post->articles;
                  foreach($articles as $j => $article):
                ?>
                <tr>
                    <td class="num"><?= $i ?></td>
                    <td><?= h($article->title) ?></td>
                    <td><?= h($article->author) ?></td>
                    <td class="status"><i class="fa <?= $status_icon ?>" aria-hidden="true"></i></td>
                    <td><?= $this->Time->format($post->modified, 'yyyy/MM/dd HH:mm') ?></td>
                    <td><?= $this->Html->link(__('View'), ['controller' => 'Posts', 'id' => $post->uuid], ['class' => 'view-link', 'target' => '_blank']) ?></td>
                    <td><?= $this->Html->link(__('Edit'), ['controller' => 'Posts', 'action' => 'edit', $article->id], ['class' => 'edit-link']) ?></td>
                    <td><?php if ($post->hasAdmin($user_id)) : ?>
                        <?= $this->Html->link(__('Setup'), ['controller' => 'Posts', 'action' => 'setup', $post->id], ['class' => 'setup-link']) ?>
                    <?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <?php endif; ?>
    <?= $this->Html->link('Create new post', ['controller' => 'Posts', 'action' => 'add'], ['class' => 'add-link']) ?>
</div>
