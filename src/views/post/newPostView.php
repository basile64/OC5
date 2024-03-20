<?php 
ob_start();
$page = "postsManagement";
?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/post-new.css">

<div class="single-post">
    <form method="post" action="./add">
        <div class="title2">Create a new post</div>
        <div class="container">
            <div class="left">
                <input id="input-title" name="titlePost" type="text" class="title-post-single" placeholder="Title"/>
                <textarea id="textarea-chapo" name="chapoPost" class="chapo-post-single" placeholder="Chapo"></textarea>
                <textarea id="textarea-text" name="textPost" class="text-post-single" placeholder="Text"></textarea>
                <button type="submit" id="btn-edit-post" name="submit">Valider la création du post</button>
            </div>
            <div class="right">
                <div class="info-post">
                    <div>Created </div>
                    <input  type="date" id="date-creation" class="date-creation-post-single" value="<?= date("Y-m-d") ?>" readonly/>
                </div>
                <div class="info-post">
                    <div>Author</div>
                    <select id="author" name="idUser" class="date-creation-post-single">
                        <option value="1">Basile</option>
                    </select>
                </div>
                <div class="info-post">
                    <div>Category</div>
                    <select id="category" name="idCategory" class="date-creation-post-single">
                        <option value="1">Coding</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>

</div>

<?php

$content = ob_get_clean();

require_once("../src/views/adminEditLayout.php");
