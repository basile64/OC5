<form class="new-main-comment-container" method="post" action="<?= htmlspecialchars(BASE_URL) ?>mainComment/create">
    <input type="hidden" name="postId" value="<?= htmlspecialchars($post->getId()) ?>"/>
    <div class="label">Post a new comment</div>
    <textarea class="new-comment-text" name="textComment"></textarea>
    <button type="submit">Publish for review</button>
</form>
