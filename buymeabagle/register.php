<?php require("./templates/header.php"); ?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Регистрация</h2>
        <form action="/buymeabagle/reg.php" method="POST" id="regForm">
          <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="name" name="name" required>
            <div id="nameFeedback" class="form-text text-danger"></div>
          </div>
          
          <div class="mb-3">
            <label for="email" class="form-label">Email адрес</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div id="emailFeedback" class="form-text text-danger"></div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>Зарегистрироваться</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const submitBtn = document.getElementById("submitBtn");
  const nameFeedback = document.getElementById("nameFeedback");
  const emailFeedback = document.getElementById("emailFeedback");

  let nameAvailable = false;
  let emailAvailable = false;

  function updateButtonState() {
    submitBtn.disabled = !(nameAvailable && emailAvailable);
  }

  nameInput.addEventListener("input", () => {
    fetch(`/buymeabagle/check_username.php?name=${encodeURIComponent(nameInput.value)}`)
      .then(res => res.text())
      .then(text => {
        if (text.trim() === "taken") {
          nameFeedback.textContent = "Имя уже занято";
          nameAvailable = false;
        } else {
          nameFeedback.textContent = "";
          nameAvailable = true;
        }
        updateButtonState();
      });
  });

  emailInput.addEventListener("input", () => {
    fetch(`/buymeabagle/check_username.php?email=${encodeURIComponent(emailInput.value)}`)
      .then(res => res.text())
      .then(text => {
        if (text.trim() === "taken") {
          emailFeedback.textContent = "Email уже используется";
          emailAvailable = false;
        } else {
          emailFeedback.textContent = "";
          emailAvailable = true;
        }
        updateButtonState();
      });
  });
</script>
<?php require("./templates/footer.php"); ?>
