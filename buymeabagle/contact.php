<?php
$title = "Связь со мной";
require("./templates/header.php");
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg border-0 rounded-4 text-center p-4" style="background: linear-gradient(145deg, #fdfbfb, #ebedee);">
        <div class="mx-auto mb-3" style="width: 100px; height: 100px;">
          <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 100%; height: 100%; font-size: 36px; font-weight: bold;">
            K
          </div>
        </div>
        <h3 class="mb-1">Kuwex</h3>
        <p class="text-muted">Создатель проекта</p>

        <hr class="my-4">

        <div class="d-flex flex-column align-items-center gap-3">
          <a href="https://github.com/KuweK" target="_blank" class="btn btn-outline-dark w-100">
            <i class="bi bi-github me-2"></i> GitHub
          </a>
          <a href="https://t.me/qwerty525252" target="_blank" class="btn btn-outline-primary w-100">
            <i class="bi bi-telegram me-2"></i> Telegram
          </a>
        </div>

        <p class="text-muted mt-4" style="font-size: 0.9rem;">Отвечаю быстро, особенно в Telegram 😎</p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<?php require("./templates/footer.php"); ?>
