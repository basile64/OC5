<form class="new-main-comment-container" method="post" action="http://localhost/OC5/mainComment/add">
    <input type="hidden" name="idPost" value="<?= $post->getId() ?>"/>
    <div class="label">Post a new comment</div>
    <textarea class="new-comment-text" name="textComment"></textarea>
    <button type="submit">Publish for review</button>
</form>