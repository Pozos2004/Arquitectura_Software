<?php
declare(strict_types=1);
?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function setThemeLabel(){
    const btn = document.getElementById("themeBtn");
    if(!btn) return;

    if(document.body.classList.contains("dark")){
      btn.textContent = "☀️ Modo claro";
    } else {
      btn.textContent = "🌙 Modo oscuro";
    }
  }

  function toggleDarkMode(){
    document.body.classList.toggle("dark");
    localStorage.setItem("darkMode", document.body.classList.contains("dark"));
    setThemeLabel();
  }

  // Mantener modo al recargar
  if(localStorage.getItem("darkMode") === "true"){
    document.body.classList.add("dark");
  }
  setThemeLabel();
</script>

</body>
</html>
