<div class="reply-comment" id="idMainComment<?=$mainComment->getIdMainComment()?>">Answer</div>
<form class="new-response-comment-container hidden" id="comment<?=$mainComment->getIdMainComment()?>" method="post" action="http://localhost/OC5/responseComment/create">
    <input type="hidden" name="idPost" value="<?= $post->getId() ?>"/>
    <input type="hidden" name="idMainComment" value="<?= $mainComment->getIdMainComment() ?>"/>
    <input type="hidden" name="idComment" value="<?= $mainComment->getIdComment() ?>"/>
    <textarea class="new-response-comment-text" name="textComment"></textarea>
    <button type="submit">Publish for review</button>
</form>