<div class="navbar">
    <div class="link-container-navbar">
        <a id="tab-post-management" class="svg-plus-text" href="http://localhost/OC5/admin/postsManagement" <?=(isset($page)&&$page=="postsManagement")?"style='font-weight:bold;'":""?>>
            <img class="svg" src="http://localhost/OC5/public/img/menu.svg"/>
            <div>Posts</div>
        </a>
        <a id="tab-comment-management" class="svg-plus-text" href="http://localhost/OC5/admin/commentsManagement" <?=(isset($page)&&$page=="commentsManagement")?"style='font-weight:bold;'":""?>>
            <img class="svg" src="http://localhost/OC5/public/img/comments.svg"/>
            <div>Comments</div>
        </a>
        <a id="tab-user-management" class="svg-plus-text" href="http://localhost/OC5/admin/usersManagement" <?=(isset($page)&&$page=="usersManagement")?"style='font-weight:bold;'":""?>>
            <img class="svg" src="http://localhost/OC5/public/img/people.svg"/>
            <div>Users</div>
        </a>
    </div>
    <div class="login-container-navbar">
        <a id="login" href="http://localhost/OC5/login" class="svg-plus-text">
            <img class="svg" src="http://localhost/OC5/public/img/person.svg"/>
            <div>Login</div>
        </a>
        <a id="back-home" href="http://localhost/OC5" class="svg-plus-text">
            <img class="svg" src="http://localhost/OC5/public/img/arrow-left.svg"/>
            <div>Back home</div>
        </a>
    </div>
</div>