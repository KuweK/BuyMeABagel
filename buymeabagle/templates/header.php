<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    body {
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1 0 auto;
    }
    footer {
      margin-top: auto;
    }

    /* Поиск - контейнер */
    #searchContainer {
      position: relative;
      max-width: 320px;
      margin-left: auto;
      margin-right: 1rem;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Поле ввода */
    #searchInput {
      border-radius: 25px;
      padding: 8px 20px;
      font-size: 0.9rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
      transition: box-shadow 0.3s ease, border-color 0.3s ease;
      border: 1px solid #ced4da;
    }
    #searchInput:focus {
      outline: none;
      box-shadow: 0 4px 10px rgba(13,110,253,0.6);
      border-color: #0d6efd;
      background-color: #fff;
    }

    /* Список результатов */
    #searchResults {
      position: absolute;
      top: 110%;
      left: 0;
      right: 0;
      background: #fff;
      border-radius: 0 0 15px 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      max-height: 350px;
      overflow-y: auto;
      z-index: 1080;
      display: none;
      animation: fadeInDown 0.25s ease forwards;
    }

    /* Анимация появления */
    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Элемент профиля */
    #searchResults .profile-item {
      display: flex;
      align-items: center;
      padding: 12px 18px;
      cursor: pointer;
      border-bottom: 1px solid #f0f0f0;
      transition: background-color 0.25s ease;
      user-select: none;
    }
    #searchResults .profile-item:last-child {
      border-bottom: none;
    }
    #searchResults .profile-item:hover {
      background-color: #e9f0ff;
    }

    /* Аватар с первой буквой */
    #searchResults .profile-avatar {
      flex-shrink: 0;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
      color: white;
      font-weight: 700;
      font-size: 1.3rem;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    /* Имя профиля */
    #searchResults .profile-name {
      font-weight: 600;
      color: #212529;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 200px;
    }
  </style>
</head>
<body>

  <!-- Навигация -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="/buymeabagle/">BuyMeABagle!</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <div id="searchContainer" class="ms-lg-3">
              <input type="search" id="searchInput" class="form-control form-control-sm" placeholder="Поиск профиля..." autocomplete="off" />
              <div id="searchResults"></div>
            </div>
          </li>
          <li class="nav-item"><a class="nav-link" href="/buymeabagle/about.php">О проекте</a></li>
          <li class="nav-item"><a class="nav-link" href="/buymeabagle/contact.php">Контакты</a></li>
          <li class="nav-item"><a class="nav-link" href="/buymeabagle/register.php">Регистрация</a></li>
          <li class="nav-item"><a class="nav-link" href="/buymeabagle/login.php">Вход</a></li>
          <li class="nav-item"><a id="btnMainAction" class="btn btn-primary ms-lg-3" href="/buymeabagle/become.php">Начать сбор</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Контент страницы -->
  <main class="container mt-4">

<script>
document.addEventListener("DOMContentLoaded", function() {
  // Кнопка главного действия
  const btn = document.getElementById('btnMainAction');
  if (btn) {
    fetch('../buymeabagle/checkdesc.php')
      .then(res => res.text())
      .then(text => {
        if (text.trim() === 'has') {
          btn.textContent = 'Ваш профиль';
          btn.href = '/buymeabagle/profile.php';
        } else if (text.trim() === 'nohas') {
          btn.textContent = 'Начать сбор';
          btn.href = '/buymeabagle/become.php';
        }
      })
      .catch(() => { });
  }

  // Поиск профилей
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');
  let timeoutId;

  function clearResults() {
    searchResults.innerHTML = '';
    searchResults.style.display = 'none';
  }

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.trim();
    clearTimeout(timeoutId);
    if (query.length < 2) {
      clearResults();
      return;
    }
    timeoutId = setTimeout(() => {
      fetch(`/buymeabagle/searching.php?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
          searchResults.innerHTML = '';
          if (!data.length) {
            clearResults();
            return;
          }
          data.forEach(profile => {
            const item = document.createElement('div');
            item.className = 'profile-item';
            item.innerHTML = `
              <div class="profile-avatar">${profile.name.charAt(0).toUpperCase()}</div>
              <div class="profile-name">${profile.name}</div>
            `;
            item.addEventListener('click', () => {
              window.location.href = `/buymeabagle/user.php?usr=${encodeURIComponent(profile.name)}`;
            });
            searchResults.appendChild(item);
          });
          searchResults.style.display = 'block';
        })
        .catch(() => {
          clearResults();
        });
    }, 300);
  });

  // Скрыть результаты при клике вне
  document.addEventListener('click', e => {
    if (!searchResults.contains(e.target) && e.target !== searchInput) {
      clearResults();
    }
  });
});
</script>
