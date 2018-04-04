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
<?= $this->Form->create($post) . PHP_EOL ?>
  <header id="controls" class="navbar navbar-expand navbar-dark flex-row bd-navbar">
    <a href="/" class="navbar-brand mr-0 mr-md-2"><?= __(SITE_TITLE) ?></a>
    <ul class="nav navbar-nav flex-row ml-auto d-md-flex">
      <li class="nav-item"><?= $this->Html->link('<span><i class="fas fa-eye"></i></span>',
        ['action' => 'view', $post->id],
        ['id' => 'previewPostlink', 'class' => 'btn btn-icon mr-md-3', 'escape' => false, '@click' => 'preview']) ?></li>
      <li class="nav-item"><?= $this->Form->button('<i class="far fa-save"></i>',
        ['class' => 'btn-outline-light btn-sm btn-icon']) ?></li>
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
              <?= $this->Form->control('description', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) . PHP_EOL ?>
            </div>
          </fieldset>

          <fieldset class="bd-fieldset">
            <div class="bd-fieldset-body pb-0">
              <div class="form-group mb-0">
                <label class="control-label" for="mainvisuals"><?= __('Main Visuals') ?></label>
                <input type="hidden" name="mainvisuals" value="[]" v-if="!mainvisuals || mainvisuals.length == 0">
                <div class="row">
                  <div class="col-sm-3 mb-4" v-for="(mainvisual, i) in mainvisuals">
                    <div class="bd-cell" v-if="mainvisual.image_name">
                      <button type="button" class="btn btn-link text-danger bd-btn-remove" @click="remove(mainvisuals, i)"><i class="fas fa-times-circle fa-lg"></i></button>
                      <input type="file" :id="'file-mainvisual-' + i" style="display:none" @change="selectedFile(mainvisual)">
                      <input type="hidden" :name="'mainvisuals[' + i + '][id]'" :value="i">
                      <input type="hidden" :name="'mainvisuals[' + i + '][image_name]'" :value="mainvisual.image_name">
                      <img :src="'<?= $this->Url->build(['controller' => 'Images', 'action' => 'view', 'width' => '980', 'height' => '512']) ?>/' + mainvisual.image_name" alt="" width="100%" @click="trigger('file-mainvisual-' + i)">
                    </div>
                  </div>
                  <div class="col-sm-3 mb-4">
                      <div class="bd-image-empty" style="padding-top: 52.24%">
                        <input type="file" id="file-mainvisual" style="display:none" @change="selectedFile(addMainvisual())">
                        <button class="btn bd-btn-field" @click="trigger('file-mainvisual')"><span><i class="fas fa-plus-circle fa-3x"></i></span></button>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </fieldset>

          <template v-if="sections.length > 0">
            <fieldset class="bd-fieldset" v-for="(section, i) in sections">
              <div class="d-flex justify-content-between bd-fieldset-header">
                <div>
                  <button type="button" class="btn btn-link text-secondary p-0 mr-1 bd-btn-up" @click="up(sections, i)" :disabled="i == 0"><i class="fas fa-caret-up"></i></button>
                  <button type="button" class="btn btn-link text-secondary p-0 bd-btn-down" @click="down(sections, i)" :disabled="i >= sections.length - 1"><i class="fas fa-caret-down"></i></button>
                </div>
                <button type="button" class="btn btn-link text-danger p-0 bd-btn-remove" @click="remove(sections, i)"><i class="far fa-minus-square"></i></button>
              </div>
              <div class="bd-fieldset-body">
                <input type="hidden" :name="'sections[' + i + '][id]'" :value="i + 1">
                <input type="hidden" :name="'sections[' + i + '][style]'" :value="section.style">
                <div class="form-group">
                  <label class="control-label" :for="'sections-' + i + '-title'"><?= __('Title') ?></label>
                  <input type="text" :name="'sections[' + i + '][title]'" v-model="section.title" class="form-control" :id="'sections-' + i + '-title'">
                </div>
                <div class="form-group">
                  <label class="control-label" :for="'sections-' + i + '-description'"><?= __('Content') ?></label>
                  <textarea rows="5" :name="'sections[' + i + '][description]'" v-model="section.description" class="form-control" :id="'sections-' + i + '-description'"></textarea>
                </div>

                <div class="bd-cells" :class="'bd-cells-' + section.style">
                  <input type="hidden" :name="'sections[' + i + '][cells]'" value="[]" v-if="!section.cells || section.cells.length == 0">
                  <div class="row">
                    <div class="mb-4" :class="colStyles[section.style]" v-for="(cell, j) in section.cells">
                      <div class="bd-cell">
                        <button type="button" class="btn btn-link text-danger bd-btn-remove" @click="remove(section.cells, j)"><i class="fas fa-times-circle fa-lg"></i></button>
                        <input type="hidden" :name="'sections[' + i + '][cells][' + j + '][id]'" :value="j + 1">

                        <template v-if="section.style == 'images' && cell.image_name">
                          <input type="file" :id="'file-' + i + '-' + j" style="display:none" @change="selectedFile(cell)">
                          <input type="hidden" :name="'sections[' + i + '][cells][' + j + '][image_name]'" :value="cell.image_name">
                          <img :src="'<?= $this->Url->build(['controller' => 'Images', 'action' => 'view', 'width' => '640', 'height' => '480']) ?>/' + cell.image_name" alt="" width="100%" @click="trigger('file-' + i + '-' + j)">
                        </template>

                        <template v-if="section.style == 'items'">
                          <div class="form-group">
                            <input type="file" :id="'file-' + i + '-' + j" style="display:none" @change="selectedFile(cell)">
                            <template v-if="cell.image_name">
                              <input type="hidden" :name="'sections[' + i + '][cells][' + j + '][image_name]'" :value="cell.image_name">
                              <img :src="'<?= $this->Url->build(['controller' => 'Images', 'action' => 'view', 'width' => '640', 'height' => '480']) ?>/' + cell.image_name" alt="" width="100%" @click="trigger('file-' + i + '-' + j)">
                            </template>
                            <template v-else>
                              <div class="bd-image-empty">
                                <button class="btn bd-btn-field" @click="trigger('file-' + i + '-' + j)"><span><i class="far fa-image fa-3x"></i></span></button>
                              </div>
                            </template>
                          </div>
                          <div class="form-group">
                            <label class="control-label"><?= __('Title') ?></label>
                            <input type="text" :name="'sections[' + i + '][cells][' + j + '][title]'" v-model="cell.title" class="form-control">
                          </div>
                          <div class="form-group mb-0">
                            <label class="control-label" :for="'sections-' + i + '-description'"><?= __('Content') ?></label>
                            <textarea rows="5" :name="'sections[' + i + '][cells][' + j + '][description]'" v-model="cell.description" class="form-control"></textarea>
                          </div>
                        </template>

                        <template v-if="section.style == 'values'">
                          <div class="form-group">
                            <label class="control-label"><?= __('Title') ?></label>
                            <input type="text" :name="'sections[' + i + '][cells][' + j + '][title]'" v-model="cell.title" class="form-control">
                          </div>
                          <div class="form-group">
                            <label class="control-label" :for="'sections-' + i + '-description'"><?= __('Content') ?></label>
                            <textarea rows="5" :name="'sections[' + i + '][cells][' + j + '][description]'" v-model="cell.description" class="form-control"></textarea>
                          </div>
                          <div class="form-group mb-0">
                            <input type="hidden" :name="'sections[' + i + '][cells][' + j + '][modified]'" :value="cell.modified" v-if="cell.modified">
                            <label class="control-label mr-1" :for="'sections-' + i + '-description'"><?= __('Last Update') ?></label>
                            <el-date-picker v-model="cell.modified" type="datetime" value-format="yyyy-MM-dd HH:mm:ss" placeholder="<?= __('Select time') ?>"></el-date-picker>
                          </div>
                        </template>

                      </div>
                    </div>
                    <div class="mb-4" :class="colStyles[section.style]">
                      <div class="bd-cell-add">
                        <template v-if="section.style == 'images'">
                          <div class="bd-image-empty">
                            <input type="file" :id="'file-' + i" style="display:none" @change="selectedFile(addCell(i))">
                            <button class="btn bd-btn-field" @click="trigger('file-' + i)"><span><i class="fas fa-plus-circle fa-3x"></i></span></button>
                          </div>
                        </template>
                        <template v-if="section.style == 'items' || section.style == 'values'">
                          <button class="btn bd-btn-field" @click="addCell(i)"><span><i class="fas fa-plus-circle fa-3x"></i></span></button>
                        </template>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </fieldset>
          </template>
          <template v-else>
            <input type="hidden" name="sections" value="[]">
          </template>
          <fieldset class="bd-fieldset p-2">
            <div class="row">
              <div class="col-sm">
                <button class="btn bd-btn-field" @click="addSection('values')"><span><i class="far fa-newspaper fa-3x"></i></span></button>
              </div>
              <div class="col-sm">
                <button class="btn bd-btn-field" @click="addSection('images')"><span><i class="fas fa-images fa-3x"></i></span></button>
              </div>
              <div class="col-sm">
                <button class="btn bd-btn-field" @click="addSection('items')"><span><i class="fas fa-id-card fa-3x"></i></span></button>
              </div>
              <div class="col-sm">
                <button class="btn bd-btn-field" @click="addSection('contact')"><span><i class="far fa-envelope fa-3x"></i></span></button>
              </div>
            </div>
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
