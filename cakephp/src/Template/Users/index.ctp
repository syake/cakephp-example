<?php
    $this->assign('title', 'Hello ' . $user_name );
?>
<div class="content index-content">
    <h1><?= $this->fetch('title') ?></h1>
    <?= $this->Flash->render() ?>
    <?php if ($has_project) : ?>
    <section class="projects">
        <h2><?= __('List Projects') ?></h2>
        <table class="table table-striped table-bordered">
            <thead>
                <?= $this->Html->tableHeaders([
                    ['#' => ['class' => 'num']],
                    __('Project Name'),
                    __('ID'),
                    __('Role'),
                    '',
                    ''
                ]) ?>
            </thead>
            <tbody>
                <?php foreach($projects as $i => $project): ?>
                <tr>
                    <td class="num"><?= $i ?></td>
                    <td><?= h($project->name) ?></td>
                    <td><?= h($project->uuid) ?></td>
                    <td><?= h($project->_joinData->role) ?></td>
                    <td><?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'display', 'id' => $project->uuid], ['class' => 'view-link', 'target' => '_blank']) ?></td>
                    <td><?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $project->id], ['class' => 'edit-link']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <?php endif; ?>
    <?= $this->Html->link('Create new project', ['controller' => 'Projects', 'action' => 'add'], ['class' => 'add-link']) ?>
</div>
