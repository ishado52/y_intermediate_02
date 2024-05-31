

<?php
session_start();
session_regenerate_id(true);
if (!(isset($_SESSION['login']))):
?>
ログインしてください<br/>
<a href="http://localhost/task_app/auth/login.php">ログインページへ</a>
<?php exit(); ?>
<?php endif; ?>

<div class="l-header">
<a href="http://localhost/task_app/index.php"><i class="fa-solid fa-house l-header__icon"></i></a>
    おかえり、<span id="js-modal__open" class="l-header__name"><?php print $_SESSION['name']; ?></span>さん
    <img src="<?php print $_SESSION['path']; ?>" alt="User Avatar" class="l-header__avatar">
</div>
<!-- モーダル -->

<div id="js-modal" class="c-modal">
        <div class="c-modal__content">
            <span class="c-modal__close">×</span>
            <p><?php print $_SESSION['name'];?>としてログイン中です</p>
            <a href="http://localhost/task_app/auth/logout.php">ログアウト</a>
        </div>
    </div>



<!-- スクリプト -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('js-modal');
    const openModalButton = document.getElementById('js-modal__open');
    const closeModalButton = document.querySelector('.c-modal__close');

    openModalButton.onclick = function () {
        modal.style.display = 'block';
    };

    closeModalButton.onclick = function () {
        modal.style.display = 'none';
    };

    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
});
</script>
