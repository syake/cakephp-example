<?php
    $this->assign('title', $post->title);
?>
<div class="content">
<?php
    $hoge = $post;
    $hoge = str_replace("\n", '<br>', $hoge);
    $hoge = str_replace(" ", '&nbsp', $hoge);
    var_dump($hoge);
?>
</div>
