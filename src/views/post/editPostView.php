<?php 
ob_start();
$page = "postsManagement";
?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/post-edit.css">
    
<div class="single-post">
    <div class="title2">Edit a post</div>
    <div class="post-container-single">
        <form method="post" action="../update/<?= $post->getId()?>">
            <input id="input-title" name="input-title" type="text" class="title-post-single" value="<?=$post->getTitle()?>"/>
            <textarea id="textarea-chapo" name="textarea-chapo" class="chapo-post-single"><?=$post->getChapo()?></textarea>
            <textarea id="textarea-text" name="textarea-text" class="text-post-single"><?=$post->getText()?></textarea>
            <button type="submit" id="btn-edit-post" name="submit">Sauvegarder</button>
        </form>
    </div>

</div>

<div class="right-post">
    <div class="nav-post">
        <a id="post-previous" href="">
            <img class="svg" src="http://localhost/OC5/public/img/arrow-left.svg"/>
        </a>
        <a id="post-next" href="">
            <img class="svg" src="http://localhost/OC5/public/img/arrow-right.svg"/>
        </a>
    </div>
    <div class="infos-post">
        <div class="info-post">
            <div>Created </div>
            <input  type="date" id="date-creation" class="date-creation-post-single" value="<?=$post->getDateCreation()?>" readonly/>
        </div>
        <?php if ($post->getDateModification() != "0000-00-00") :?>
        <div class="info-post">
            <div>Edited</div>
            <input  type="date" id="date-modification" class="date-modification-post-single" value="<?=$post->getDateModification()?>" readonly/>
        </div>
        <?php endif ?>
        <div class="info-post">
            <div>Author</div>
            <select id="author" class="date-creation-post-single">
                <option><?=$post->getAuthor()?></option>
            </select>
        </div>
    </div>
</div>

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/adminEditLayout.php");
