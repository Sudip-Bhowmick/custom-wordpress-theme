const lenis = new Lenis();

lenis.on("scroll", (e) => {
  //   console.log(e)
});

function raf(time) {
  lenis.raf(time);
  requestAnimationFrame(raf);
}

requestAnimationFrame(raf);

// header
document.addEventListener("DOMContentLoaded", (event) => {
  document
    .querySelector(".hfe-nav-menu__toggle.hfe-flyout-trigger")
    .addEventListener("click", function () {
      const overlay = document.querySelector(".hfe-flyout-overlay");
      const side = document.querySelector(".hfe-side");
      const ham = document.querySelector(
        ".hfe-nav-menu__toggle.hfe-flyout-trigger"
      );

      if (overlay.style.display === "none" || overlay.style.display === "") {
        overlay.style.display = "block";
        overlay.style.opacity = 0;
        setTimeout(() => {
          overlay.style.opacity = 1;
        }, 10);
      } else {
        overlay.style.opacity = 0;
        overlay.addEventListener(
          "transitionend",
          function () {
            overlay.style.display = "none";
          },
          { once: true }
        );
      }
      side.classList.toggle("visible");
      ham.classList.toggle("visible");
    });
});
