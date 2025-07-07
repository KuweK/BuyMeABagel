<?php
$title = "Удаление аккаунта";
require("./templates/header.php");

if (empty($_COOKIE["name"])) {
    header("Location: /buymeabagle/?err=noauth");
    exit;
}

$name = htmlspecialchars($_COOKIE["name"]);
?>

<style>
  .delete-card {
    max-width: 600px;
    margin: 40px auto;
    padding: 30px 25px;
    background-color: #fff5f5;
    border: 1px solid #f5c2c7;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    color: #842029;
  }

  .form-check-label {
    cursor: pointer;
  }

  .form-control:disabled {
    background-color: #e9ecef;
  }
</style>

<div class="delete-card">
  <h3 class="mb-3">❗ Удаление аккаунта</h3>
  <p>Вы действительно хотите удалить аккаунт <strong><?= $name ?></strong>?</p>
  <ul>
    <li>Это действие <strong>невозможно отменить</strong>.</li>
    <li>Все ваши данные и 🥯 бублики будут безвозвратно удалены.</li>
  </ul>

  <form id="deleteForm" method="POST" action="remove_handler.php" class="mt-4">
    <div class="mb-3">
      <label for="email" class="form-label">📧 Email:</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" required disabled>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">🔒 Пароль:</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль" required disabled>
    </div>

    <input type="hidden" name="name" value="<?= $name ?>">

    <div class="form-check mb-3">
      <input type="checkbox" class="form-check-input" id="confirmCheck">
      <label class="form-check-label" for="confirmCheck">Я ознакомлен с информацией об удалении</label>
    </div>

    <button type="submit" class="btn btn-danger w-100" id="deleteBtn" disabled>🗑 Удалить аккаунт</button>
  </form>
</div>

<script>
  const checkbox = document.getElementById("confirmCheck");
  const deleteBtn = document.getElementById("deleteBtn");
  const emailInput = document.getElementById("email");
  const passInput = document.getElementById("password");

  checkbox.addEventListener("change", () => {
    const enabled = checkbox.checked;
    deleteBtn.disabled = !enabled;
    emailInput.disabled = !enabled;
    passInput.disabled = !enabled;
  });
</script>

<?php require("./templates/footer.php"); ?>
