import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  connect() {
    var themeToggleBtn = document.getElementById("theme-toggle");
    if (document.contains(themeToggleBtn) == true) {
      // Change the icons inside the button based on previous settings
      if (
        localStorage.getItem("theme") === "dark" ||
        (!("theme" in localStorage) &&
          window.matchMedia("(prefers-color-scheme: dark)").matches)
      ) {
        document.documentElement.classList.add("dark");
        themeToggleBtn.nextElementSibling.classList.add("translateright");
      } else {
        themeToggleBtn.nextElementSibling.classList.remove("translateright");
        document.documentElement.classList.remove("dark");
      }

      themeToggleBtn.addEventListener("click", function () {
        // toggle icons inside button
        themeToggleBtn.nextElementSibling.classList.toggle("translateright");
        // if set via local storage previously
        if (localStorage.getItem("theme")) {
          if (localStorage.getItem("theme") === "light") {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
          } else {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
          }

          // if NOT set via local storage previously
        } else {
          if (document.documentElement.classList.contains("dark")) {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
          } else {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
          }
        }
      });
    } else {
      if (
        localStorage.getItem("theme") === "dark" ||
        (!("theme" in localStorage) &&
          window.matchMedia("(prefers-color-scheme: dark)").matches)
      ) {
        document.documentElement.classList.add("dark");
      } else {
        document.documentElement.classList.remove("dark");
      }
    }
  }
}