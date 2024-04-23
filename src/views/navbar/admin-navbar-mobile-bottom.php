<div class="navbar-mobile-bottom">
    <a id="tab-post-management" class="svg-plus-text" href="<?= htmlspecialchars(BASE_URL) ?>admin/postsManagement" <?=(isset($page)&&$page=="postsManagement")?"style='font-weight:bold;'":""?>>
        <img class="svg" src="<?= htmlspecialchars(BASE_URL) ?>public/svg/menu.svg"/>
        <div class="navbar-text">Posts</div>
    </a>
    <a id="tab-comment-management" class="svg-plus-text" href="<?= htmlspecialchars(BASE_URL) ?>admin/commentsManagement" <?=(isset($page)&&$page=="commentsManagement")?"style='font-weight:bold;'":""?>>
        <img class="svg" src="<?= htmlspecialchars(BASE_URL) ?>public/svg/comments.svg"/>
        <div class="navbar-text">Comments</div>
    </a>
    <a id="tab-user-management" class="svg-plus-text" href="<?= htmlspecialchars(BASE_URL) ?>admin/usersManagement" <?=(isset($page)&&$page=="usersManagement")?"style='font-weight:bold;'":""?>>
        <img class="svg" src="<?= htmlspecialchars(BASE_URL) ?>public/svg/people.svg"/>
        <div class="navbar-text">Users</div>
    </a>
</div>
