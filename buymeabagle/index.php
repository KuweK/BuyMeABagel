<?php
    $title = "Главная";
    require("./templates/header.php");
?>

<?php
if (str_contains($_SERVER['REQUEST_URI'], "?err=nodesc")) {
    echo "<script>alert('Введите описание профиля!')</script>";
}
if (str_contains($_SERVER['REQUEST_URI'], "?msg=success")) {
    echo "<script>alert('Оплата произведена!')</script>";
}
if (str_contains($_SERVER['REQUEST_URI'], "?err=noname")) {
    echo "<script>alert('Такого профиля не существует!')</script>";
}
if (str_contains($_SERVER["REQUEST_URI"], "?err=noauth")) {
    echo "<script>alert('Вы не авторизованы!')</script>";
}
if (str_contains($_SERVER["REQUEST_URI"], "?err=noautherize")) {
    echo "<script>alert('Неправильно введён пароль или время сессии истекло!')</script>";
}

if (isset($_COOKIE["isLogin"]) && $_COOKIE["isLogin"] === "true") {
    echo "<h1 class='fw-bold text-dark'>Вы авторизовались, " . htmlspecialchars($_COOKIE['name']) . "</h1>";
} else {
    echo "<h1 class='text-danger'>Вы не авторизованы!</h1>";
}
?>

<h3 class="mt-5 mb-4 display-6 fw-semibold">Случайные профили с описанием</h3>
<div id="profiles" class="row gy-4"></div>

<style>
  .card-profile {
    background: linear-gradient(145deg, #f5f8ff, #ffffff);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #dee2e6;
    position: relative;
    overflow: hidden;
  }

  .card-profile:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
    border-color: #ced4da;
  }

  .user-icon {
    font-size: 2rem;
    color: #0d6efd;
    margin-bottom: 0.5rem;
  }

  .card-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #343a40;
    margin-bottom: 0.75rem;
  }

  .card-text {
    color: #495057;
    font-size: 1rem;
    line-height: 1.5;
    flex-grow: 1;
    margin-bottom: 1.25rem;
  }

.btn-view {
  border-radius: 30px;
  font-size: 1rem; /* увеличен с 0.95rem */
  font-weight: 500;
  padding: 10px 20px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background-color: #0d6efd;
  color: #fff;
  border: none;
  text-decoration: none; /* УБРАЛИ подчеркивание */
  transition: background-color 0.2s ease;
  align-self: start;
}

  .btn-view:hover {
    background-color: #0b5ed7;
    color: #fff;
  }

  .btn-view i {
    font-size: 1.1rem;
  }

  @media (max-width: 576px) {
    .card-profile {
      padding: 1.25rem;
    }
    .card-title {
      font-size: 1.2rem;
    }
    .card-text {
      font-size: 0.95rem;
    }
  }
</style>

<!-- FontAwesome (для иконки пользователя) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
  function renderProfiles(profiles) {
    const container = document.getElementById('profiles');
    container.innerHTML = '';

    if (!profiles.length) {
      container.innerHTML = '<p>Профили с описанием пока отсутствуют.</p>';
      return;
    }

    profiles.forEach(profile => {
      const col = document.createElement('div');
      col.className = 'col-md-4 d-flex';

      col.innerHTML = `
        <div class="card-profile w-100">
          <div>
            <div class="user-icon"><i class="fas fa-user-circle"></i></div>
            <h5 class="card-title">${profile.name}</h5>
            <p class="card-text">${profile.short_desc}...</p>
          </div>
          <a href="/buymeabagle/user.php?usr=${encodeURIComponent(profile.name)}" class="btn-view">
            <i class="fas fa-eye"></i> Посмотреть профиль
          </a>
        </div>
      `;
      container.appendChild(col);
    });
  }

  fetch('/buymeabagle/get_profiles.php')
    .then(response => response.json())
    .then(data => {
      renderProfiles(data);
    })
    .catch(() => {
      document.getElementById('profiles').innerHTML = '<p>Ошибка загрузки профилей.</p>';
    });
</script>

<?php
    require("./templates/footer.php");
?>
