<?php
    $this->assign('title', 'Hello ' . $user_name );
?>
<div class="content index-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Flash->render() ?>
<?php if (count($projects) > 0) : ?>
    <section class="projects">
        <h2><?= __('List Projects') ?></h2>
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
<?php
    foreach($projects as $i => $project):
        if ($project->status) {
            $status_icon = 'fa-check-circle';
        }  else {
            $status_icon = 'fa-ban';
        }
        $articles = $project->articles;
        foreach($articles as $j => $article):
?>
                <tr>
                    <td class="num"><?= $i ?></td>
                    <td><?= h($article->title) ?></td>
                    <td><?= h($article->author) ?></td>
                    <td class="status"><i class="fa <?= $status_icon ?>" aria-hidden="true"></i></td>
                    <td><?= $this->Time->format($project->modified, 'yyyy/MM/dd HH:mm') ?></td>
                    <td><?= $this->Html->link(__('View'), ['controller' => 'Projects', 'id' => $project->uuid], ['class' => 'view-link', 'target' => '_blank']) ?></td>
                    <td><?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $article->id], ['class' => 'edit-link']) ?></td>
                    <td><?php if ($project->hasAdmin($user_id)) : ?>
                        <?= $this->Html->link(__('Setup'), ['controller' => 'Projects', 'action' => 'setup', $project->id], ['class' => 'setup-link']) ?>
                    <?php endif; ?></td>
                </tr>
<?php
        endforeach;
    endforeach;
?>
            </tbody>
        </table>
    </section>
<?php endif; ?>
    <?= $this->Html->link('Create new post', ['controller' => 'Projects', 'action' => 'add'], ['class' => 'add-link']) . PHP_EOL ?>
</div>
