

<?php 
ob_start();
$page = "postsManagement";
?>
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/post-new.css">
<script src="<?= BASE_URL ?>public/js/edit-post.js"></script>

<div class="single-post">
    <form method="post" action="../update/<?= htmlspecialchars($post->getId()) ?>" enctype="multipart/form-data">
        <div class="title1 title1-edit">Edit a post</div>
        <div class="container">
            <div class="left">
                <div style="align-self:center"><img src="<?= BASE_URL ?>public/upload/<?= htmlspecialchars($post->getImg()) ?>" id="imagePreview"></div>
                <div style="display:flex; flex-direction:column; align-items:center"><div>Sélectionnez une autre image</div><input type="file" name="postImg" id="imgPost" class="img-post-single" accept="image/*"></div>
                <div class="container-title">
                    <div class="label">Title</div>
                    <input id="input-title" name="postTitle" type="text" class="title-post-single" value="<?= htmlspecialchars($post->getTitle()) ?>"> 
                </div>
                <div class="container-title">
                    <div class="label">Chapo</div>
                    <textarea id="textarea-chapo" name="postChapo" class="chapo-post-single"><?= htmlspecialchars($post->getChapo()) ?></textarea>
                </div>
                <div class="container-title">
                    <div class="label">Text</div>
                    <textarea id="textarea-text" name="postText" class="text-post-single"><?= htmlspecialchars($post->getText()) ?></textarea>
                </div>
                <button type="submit" id="btn-edit-post" name="submit">Sauvegarder</button>
            </div>
            <div class="right">
                <div class="info-post">
                    <div>Created </div>
                    <input  type="date" id="date-creation" class="date-creation-post-single" value="<?= htmlspecialchars(date("Y-m-d")) ?>" readonly disabled/>
                </div>
                <div class="info-post">
                    <div>Author</div>
                    <select id="author" name="userId" class="date-creation-post-single">
                        <?php foreach ($authors as $author): ?>
                            <option value="<?= htmlspecialchars($author->getId()) ?>" <?= ($author->getId() === $post->getUserId()) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($author->getFirstName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="info-post">
                    <div>Category</div>
                    <select id="category" name="categoryId" class="date-creation-post-single">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category->getId()) ?>" <?= ($category->getId() === $post->getCategoryId()) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>


<?php

$content = ob_get_clean();

require_once "../src/views/adminEditLayout.php";


