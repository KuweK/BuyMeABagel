<?php
    $title = "Профиль пользователя";
    require("./templates/header.php");

    $fromUser = isset($_COOKIE["name"]) ? htmlspecialchars($_COOKIE["name"]) : "";
    $toUser = isset($_GET["usr"]) ? htmlspecialchars($_GET["usr"]) : "";

    $isLogin = isset($_COOKIE["isLogin"]) ? $_COOKIE["isLogin"] : "false";
    if ($_GET["msg"] === "success") {
        echo "<script>alert('Оплата прошла успешно!')</script>";
    }
?>

<div id="userProfile" class="container mt-5">
  <div class="row justify-content-center">
    <!-- Комментарии -->
    <div class="col-md-4 mb-4">
      <div class="card shadow-sm border-0 rounded-4" style="background: #f8f9fa;">
        <div class="card-body">
          <h5 class="card-title">Комментарии</h5>
          <div id="commentsList" style="max-height: 500px; overflow-y: auto;">
            <p class="text-muted">Загрузка комментариев...</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Профиль -->
    <div class="col-md-6">
      <div id="profileCard" class="card p-4 shadow-lg border-0 rounded-4" style="display: none; background: linear-gradient(to right, #fdfbfb, #ebedee);">
        <div class="card-body">
          <div class="d-flex align-items-center mb-3">
            <div class="avatar bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;" id="avatarLetter">
              K
            </div>
            <h3 class="card-title m-0" id="profileName">Имя</h3>
          </div>
          <hr>
          <p class="card-text" id="profileDesc" style="white-space: pre-line;"></p>
        </div>
      </div>

      <!-- Меню доната -->
      <div id="donateMenu" class="mt-4 text-center" style="display:none;">
        <h5>🛍️ Купить бублики</h5>
        <div class="d-flex justify-content-center align-items-center gap-3 my-3">
          <button type="button" class="btn btn-outline-primary donate-btn" data-count="1">1 🥯</button>
          <button type="button" class="btn btn-outline-primary donate-btn" data-count="5">5 🥯</button>
          <button type="button" class="btn btn-outline-primary donate-btn" data-count="10">10 🥯</button>
        </div>
        <button id="payButton" class="btn btn-success" disabled>Оплатить 💳</button>
      </div>

      <!-- Форма / предупреждение -->
      <div class="mt-5">
        <?php if ($isLogin !== "false"): ?>
          <h5>Оставить комментарий</h5>
          <form action="newcomment.php" method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="from" value="<?= $fromUser ?>">
            <input type="hidden" name="to" value="<?= $toUser ?>">

            <div class="mb-3">
              <label for="commentText" class="form-label">Комментарий</label>
              <textarea class="form-control" id="commentText" name="text" rows="4" placeholder="Введите ваш комментарий..." required></textarea>
              <div class="invalid-feedback">
                Пожалуйста, введите текст комментария.
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Отправить</button>
          </form>
        <?php else: ?>
          <div class="alert alert-warning text-center" role="alert">
            Писать комментарии могут только авторизованные пользователи.<br>
            <a href="/buymeabagle/login.php" class="alert-link">Войти или зарегистрироваться</a>
          </div>
        <?php endif; ?>
      </div>

      <!-- Ошибка -->
      <div class="text-center mt-4" id="errorMessage" style="display: none;">
        <div class="alert alert-danger">Пользователь не найден или произошла ошибка.</div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);
  const user = params.get("usr");

  const profileCard = document.getElementById("profileCard");
  const errorMessage = document.getElementById("errorMessage");
  const donateMenu = document.getElementById("donateMenu");
  const payButton = document.getElementById("payButton");
  const donateButtons = document.querySelectorAll(".donate-btn");
  const commentsList = document.getElementById("commentsList");

  let selectedCount = null;

  // Загрузка комментариев
  fetch(`/buymeabagle/getcomments.php?usr=${encodeURIComponent(user)}`)
    .then(res => res.json())
    .then(data => {
      if (data.success && Array.isArray(data.comments)) {
        if (data.comments.length === 0) {
          commentsList.innerHTML = '<p class="text-muted">Пока нет комментариев.</p>';
        } else {
          commentsList.innerHTML = "";
          data.comments.forEach(comment => {
            const commentEl = document.createElement("div");
            commentEl.className = "mb-3 p-3 bg-white rounded shadow-sm position-relative";

            let deleteBtn = "";
            if (comment.your === true) {
              deleteBtn = `<button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-comment" data-from="${encodeURIComponent(comment.from)}" data-text="${encodeURIComponent(comment.text)}">&times;</button>`;
            }

            commentEl.innerHTML = `
              ${deleteBtn}
              <strong>${comment.from}</strong><br>
              <span style="white-space: pre-line;">${comment.text}</span>
            `;
            commentsList.appendChild(commentEl);
          });

          // Обработчики нажатия на кнопку удаления
          document.querySelectorAll('.delete-comment').forEach(btn => {
            btn.addEventListener('click', () => {
              const from = decodeURIComponent(btn.getAttribute('data-from'));
              const text = decodeURIComponent(btn.getAttribute('data-text'));

              fetch('/buymeabagle/rmcomment.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `from=${encodeURIComponent(from)}&text=${encodeURIComponent(text)}`
              })
              .then(res => res.json())
              .then(result => {
                if (result.success) {
                  btn.parentElement.remove();
                } else {
                  alert('Не удалось удалить комментарий.');
                }
              })
              .catch(() => {
                alert('Ошибка при удалении.');
              });
            });
          });
        }
      } else {
        commentsList.innerHTML = '<p class="text-danger">Ошибка загрузки комментариев.</p>';
      }
    })
    .catch(() => {
      commentsList.innerHTML = '<p class="text-danger">Ошибка загрузки комментариев.</p>';
    });

  // Обновление текста кнопки оплаты
  function updatePayButtonText(count) {
    const price = count * 100;
    payButton.textContent = `Оплатить ${price}₽ 💳`;
  }

  donateButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      donateButtons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      selectedCount = parseInt(btn.getAttribute("data-count"));
      payButton.disabled = false;
      updatePayButtonText(selectedCount);
    });
  });

  payButton.addEventListener("click", () => {
    if (!selectedCount) return;
    window.location.href = `/buymeabagle/payment.php?count=${selectedCount}&usr=${encodeURIComponent(user)}`;
  });

  fetch(`/buymeabagle/searchuser.php?usr=${encodeURIComponent(user)}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById("profileName").textContent = data.name;
        document.getElementById("profileDesc").textContent = data.about;
        document.getElementById("avatarLetter").textContent = data.name.charAt(0).toUpperCase();

        profileCard.style.display = "block";
        donateMenu.style.display = "block";
        errorMessage.style.display = "none";
      } else {
        errorMessage.style.display = "block";
        profileCard.style.display = "none";
        donateMenu.style.display = "none";
      }
    })
    .catch(() => {
      errorMessage.style.display = "block";
      profileCard.style.display = "none";
      donateMenu.style.display = "none";
    });

  // Bootstrap 5 валидация формы
  (function () {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
  })()
});
</script>

<style>
  .donate-btn.active {
    background-color: #0d6efd;
    color: white;
  }
  .donate-btn {
    min-width: 60px;
    font-weight: 600;
    font-size: 1.2rem;
    transition: background-color 0.3s, color 0.3s;
  }
  .donate-btn:hover {
    background-color: #0d6efd;
    color: white;
    cursor: pointer;
  }
</style>

<?php require("./templates/footer.php"); ?>
