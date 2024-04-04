<?php 
ob_start();
$page = "postsManagement";
?>
<link rel="stylesheet" href="http://localhost/OC5/public/css/post-new.css">
<script src="http://localhost/OC5/public/js/new-post.js"></script>

<div class="single-post">
    <form method="post" action="./create" enctype="multipart/form-data">
        <div class="title1 title1-edit">Create a new post</div>
        <div class="container">
            <div class="left">
                <div><img src="" id="imagePreview"></div>
                <div><div>Sélectionnez une image</div><input type="file" name="imgPost" id="imgPost" class="img-post-single" accept="image/*"></div>
                <div class="container-title">
                    <div class="label">Title</div>
                    <input id="input-title" name="titlePost" type="text" class="title-post-single">
                </div>
                <div class="container-title">
                    <div class="label">Chapo</div>
                    <textarea id="textarea-chapo" name="chapoPost" class="chapo-post-single"></textarea>
                </div>
                <div class="container-title">
                    <div class="label">Text</div>
                    <textarea id="textarea-text" name="textPost" class="text-post-single"></textarea>
                </div>
                <button type="submit" id="btn-edit-post" name="submit">Validate the creation</button>
            </div>
            <div class="right">
                <div class="info-post">
                    <div>Created </div>
                    <input  type="date" id="date-creation" class="date-creation-post-single" value="<?= date("Y-m-d") ?>" readonly/>
                </div>
                <div class="info-post">
                    <div>Author</div>
                    <select id="author" name="idUser" class="date-creation-post-single">
                    <?php foreach ($authors as $author): ?>
                        <option value="<?php echo $author->getId(); ?>"><?php echo $author->getFirstName(); ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div class="info-post">
                    <div>Category</div>
                    <select id="category" name="idCategory" class="date-creation-post-single">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></option>
                    <?php endforeach; ?>
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
