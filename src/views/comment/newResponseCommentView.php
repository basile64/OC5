<div class="reply-comment" id="idMainComment<?= htmlspecialchars($mainComment->getMainCommentId()) ?>">Answer</div>
<form class="new-response-comment-container hidden" id="comment<?= htmlspecialchars($mainComment->getMainCommentId()) ?>" method="post" action="<?= BASE_URL ?>responseComment/create">
    <input type="hidden" name="postId" value="<?= htmlspecialchars($post->getId()) ?>"/>
    <input type="hidden" name="mainCommentId" value="<?= htmlspecialchars($mainComment->getMainCommentId()) ?>"/>
    <input type="hidden" name="commentId" value="<?= htmlspecialchars($mainComment->getCommentId()) ?>"/>
    <textarea class="new-response-comment-text" name="textComment"></textarea>
    <button type="submit">Publish for review</button>
</form>
