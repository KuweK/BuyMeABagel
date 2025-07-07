<?php
$title = "Ваш профиль";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!empty($_COOKIE["name"]) && $_COOKIE["isLogin"] === "true") {
    $name = htmlspecialchars($_COOKIE["name"]);
    $host = "localhost";
    $who = "kuwek";
    $passs = "passwd";
    $base = "php-test";
    $db = new mysqli($host, $who, $passs, $base);
    $prep = $db->prepare("SELECT aboutchanel FROM users_bmab WHERE name = ?");
    $prep->bind_param("s", $name);
    $prep->execute();
    $prep->bind_result($about);
    $prep->fetch();
    $prep->close();
    $db->close();
} else {
    header("Location: http://localhost/buymeabagle/?err=noauth");
    exit;
}
require("./templates/header.php");
?>

<style>
  .profile-card {
    background: rgba(255, 255, 255, 0.85);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 30px 25px;
    max-width: 600px;
    margin: 40px auto;
    color: #222;
  }

  .bagel-count {
    font-size: 1rem;
    font-weight: 500;
    margin-top: 10px;
    background-color: #fff3cd;
    border: 1px solid #ffeeba;
    border-radius: 8px;
    padding: 8px 12px;
    color: #856404;
    display: inline-block;
  }

  .action-buttons {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 25px;
  }

  textarea.form-control {
    resize: none;
  }
</style>

<div class="profile-card">
  <h3 class="mb-3">👤 Профиль: <?= $name ?></h3>

  <p id="descText"><?= $about ? nl2br(htmlspecialchars($about)) : '<em class="text-muted">Нет описания</em>' ?></p>
  <button id="editBtn" class="btn btn-outline-primary btn-sm">✏ Изменить описание</button>

  <!-- Плашка бубликов -->
  <div class="mt-2">
    <span class="bagel-count">🥯 Ваши бублики: <span id="bagelNum">загрузка...</span></span>
  </div>

  <!-- Форма редактирования -->
  <form id="editForm" class="mt-3 d-none" method="POST" action="update_desc.php">
    <textarea class="form-control" name="newdesc" rows="4" placeholder="Новое описание"><?= htmlspecialchars($about) ?></textarea>
    <input type="hidden" name="name" value="<?= $name ?>">
    <div class="mt-2">
      <button type="submit" class="btn btn-success btn-sm">💾 Сохранить</button>
      <button type="button" id="cancelBtn" class="btn btn-secondary btn-sm ms-2">Отмена</button>
    </div>
  </form>

  <!-- Кнопки выхода и удаления -->
  <div class="action-buttons">
    <a href="reset.php" class="btn btn-danger btn-sm">🚪 Выйти из аккаунта</a>
    <a href="remove.php" class="btn btn-outline-danger btn-sm">🗑 Удалить аккаунт</a>
  </div>
</div>

<script>
document.getElementById('editBtn').addEventListener('click', function () {
  document.getElementById('editForm').classList.remove('d-none');
  this.classList.add('d-none');
});

document.getElementById('cancelBtn').addEventListener('click', function () {
  document.getElementById('editForm').classList.add('d-none');
  document.getElementById('editBtn').classList.remove('d-none');
});

// Загрузка количества бубликов
document.addEventListener("DOMContentLoaded", () => {
  fetch('getbagels.php')
    .then(res => res.json())
    .then(data => {
      if (data && typeof data.bagels === 'number') {
        document.getElementById('bagelNum').textContent = data.bagels;
      } else {
        document.getElementById('bagelNum').textContent = 'нет данных';
      }
    })
    .catch(() => {
      document.getElementById('bagelNum').textContent = 'ошибка';
    });
});
</script>

<?php require("./templates/footer.php"); ?>
