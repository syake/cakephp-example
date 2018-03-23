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

// for vue.js
$this->Html->scriptStart(['block' => true]);
echo '(function(){window.data.post=' . json_encode($post) . '})();';
$this->Html->scriptEnd();
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
        <div id="editor">
          <fieldset class="bd-fieldset">
            <div class="bd-fieldset-body">
              <?= $this->Form->control('project.name', ['label' => __('Page URL')]) . PHP_EOL ?>
              <?= $this->Form->control('title', ['label' => __('Title')]) . PHP_EOL ?>
              <?= $this->Form->control('content', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) . PHP_EOL ?>
            </div>
          </fieldset>
          <template v-if="sections.length > 0">
            <fieldset class="bd-fieldset" v-for="(section, i) in sections">
              <div class="d-flex justify-content-between bd-fieldset-header">
                <div>
                  <button type="button" class="btn btn-link text-secondary p-0 mr-1 db-btn-up" @click="upSection(i)" :disabled="i == 0"><i class="fas fa-caret-up"></i></button>
                  <button type="button" class="btn btn-link text-secondary p-0 db-btn-down" @click="downSection(i)" :disabled="i >= sections.length - 1"><i class="fas fa-caret-down"></i></button>
                </div>
                <button type="button" class="btn btn-link text-danger p-0 db-btn-remove" @click="removeSection(i)"><i class="far fa-minus-square"></i></button>
              </div>
              <div class="bd-fieldset-body">
                <div class="form-group mb-0">
                  <label class="control-label" :for="'sections-' + i + '-title'"><?= __('Title') ?></label>
                  <input type="text" :name="'sections[' + i + '][section_title]'" v-model="section.section_title" class="form-control" :id="'sections-' + i + '-title'">
                  <input type="hidden" :name="'sections[' + i + '][section_id]'" :value="i + 1">
                </div>
                <div class="row">
                  <template v-if="section.images && section.images.length > 0">
                    <div class="col-sm-4 mt-4" v-for="(clause, j) in section.images">
                      {{clause.image_name}}
                      <input type="file" :name="'sections[' + i + '][images][' + j + '][file]'" @change="selectedFile(i, j)">
                      <input type="hidden" :name="'sections[' + i + '][images][' + j + '][image_name]'" :value="clause.image_name">
                      <input type="hidden" :name="'sections[' + i + '][images][' + j + '][clause_id]'" :value="j + 1">
                      <button type="button" class="btn btn-link text-danger bd-btn-remove" @click="removeClause(i, j)"><i class="far fa-minus-square"></i></button>
                      <!-- <input type="hidden" :name="'sections[' + i + '][images][' + j + '][clause_order]'" :value="j"> -->
                    </div>
                  </template>
                  <template v-else>
                    <input type="hidden" :name="'sections[' + i + '][images]'" value="[]">
                  </template>
                  <div class="col-sm-4 mt-4">
                    <button class="btn bd-btn-field" @click="addClause(i)"><span><i class="fas fa-plus"></i></span></button>
                  </div>
                </div>
              </div>
            </fieldset>
          </template>
          <template v-else>
            <input type="hidden" name="sections" value="[]">
          </template>
          <fieldset class="bd-fieldset">
            <button class="btn bd-btn-field" @click="addSection"><span><i class="fas fa-plus"></i></span></button>
          </fieldset>
        </div>
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
