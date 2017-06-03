<?php
    $this->assign('title', 'Hello ' . $user_name );
?>
<div class="content index-content">
    <h1><?= $this->fetch('title') ?></h1>
</div>
