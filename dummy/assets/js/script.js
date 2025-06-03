const menuBtn = document.getElementById("menuBtn");
const mobileMenu = document.getElementById("mobileMenu");
const menuClose = document.getElementById("menuClose");
const body = document.body;

// Toggle mobile menu
menuBtn.addEventListener("click", function () {
  mobileMenu.classList.toggle("show");
  // Removed body scroll lock since menu is smaller now

  // Change hamburger icon to X when menu is open
  const icon = menuBtn.querySelector("i");
  if (mobileMenu.classList.contains("show")) {
    icon.classList.remove("fa-bars");
    icon.classList.add("fa-times");
  } else {
    icon.classList.remove("fa-times");
    icon.classList.add("fa-bars");
  }
});

// Close menu when close button is clicked
menuClose.addEventListener("click", function () {
  closeMenu();
});

// Close menu function
function closeMenu() {
  mobileMenu.classList.remove("show");
  // Removed body scroll lock removal since menu is smaller now

  const icon = menuBtn.querySelector("i");
  icon.classList.remove("fa-times");
  icon.classList.add("fa-bars");
}

// Close menu when clicking outside
mobileMenu.addEventListener("click", function (event) {
  if (event.target === mobileMenu) {
    closeMenu();
  }
});

// Modal functions (placeholder)
function showModal(modalId) {
  console.log("Show modal:", modalId);
  // Add your modal logic here
}

// Close menu when pressing Escape key
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape" && mobileMenu.classList.contains("show")) {
    closeMenu();
  }
});
