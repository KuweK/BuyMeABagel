<?php
$title = "Начать сбор";
require("./templates/header.php");

$isLoggedIn = isset($_COOKIE['isLogin']) && $_COOKIE['isLogin'] === "true";
?>

<div class="container mt-5">
  <?php if ($isLoggedIn): ?>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Создайте сбор, <?=$_COOKIE['name']?></h2>
            <form action="/buymeabagle/create_card.php" method="POST">
              <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Создать сбор</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card text-center shadow-sm border-0">
          <div class="card-body">
            <h3 class="card-title mb-4">Доступ закрыт</h3>
            <p class="card-text mb-4">Функция доступна только для авторизованных пользователей.</p>
            <a href="/buymeabagle/register.php" class="btn btn-outline-primary me-3">Регистрация</a>
            <a href="/buymeabagle/login.php" class="btn btn-primary">Вход</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php
require("./templates/footer.php");
?>
