document.addEventListener("DOMContentLoaded", function () {
      const menuToggle = document.getElementById("menu-toggle");
      const Links = document.getElementById("links");

      menuToggle.addEventListener("click", () => {
        Links.classList.toggle("show");
      });
    });