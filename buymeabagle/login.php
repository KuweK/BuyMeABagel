<?php
    require("./templates/header.php");
    if(str_contains($_SERVER["REQUEST_URI"], "msg=err")){
        echo "<script>alert('Неправильно введены данные для входа.')</script>";
    }
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Вход в аккаунт</h2>
        <form action="/buymeabagle/login_handler.php" method="POST">
          <div class="mb-3">
            <label for="name" class="form-label">Имя пользователя</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <button type="submit" class="btn btn-success w-100">Войти</button>
        </form>

        <div class="text-center mt-3">
          <small>Нет аккаунта? <a href="/buymeabagle/register.php">Зарегистрируйтесь</a></small>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
    require("./templates/footer.php");
?>