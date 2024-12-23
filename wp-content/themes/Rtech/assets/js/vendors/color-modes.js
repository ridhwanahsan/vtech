// Darkmode

(() => {
   "use strict";

   const getStoredTheme = () => localStorage.getItem("theme");
   const setStoredTheme = (theme) => localStorage.setItem("theme", theme);

   const getPreferredTheme = () => {
      const storedTheme = getStoredTheme();
      if (storedTheme) {
         return storedTheme;
      }

      return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
   };

   const setTheme = (theme) => {
      if (theme === "auto" && window.matchMedia("(prefers-color-scheme: dark)").matches) {
         document.documentElement.setAttribute("data-bs-theme", "dark");
      } else {
         document.documentElement.setAttribute("data-bs-theme", theme);
      }
   };

   const updateDropdownIcon = (theme) => {
      const themeIconActive = document.querySelector(".theme-icon-active");
      const iconElement = document.querySelector(`[data-bs-theme-value="${theme}"] .theme-icon`);

      if (themeIconActive && iconElement) {
         themeIconActive.innerHTML = iconElement.outerHTML;
      }
   };

   setTheme(getPreferredTheme());

   const showActiveTheme = (theme, focus = false) => {
      const themeSwitcherText = document.querySelector(".bs-theme-text");
      const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`);

      document.querySelectorAll("[data-bs-theme-value]").forEach((element) => {
         element.classList.remove("active");
         element.setAttribute("aria-pressed", "false");
      });

      btnToActive.classList.add("active");
      btnToActive.setAttribute("aria-pressed", "true");
      const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`;

      updateDropdownIcon(theme);

      if (focus) {
         btnToActive.focus();
      }
   };

   window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", () => {
      const storedTheme = getStoredTheme();
      if (storedTheme !== "light" && storedTheme !== "dark") {
         setTheme(getPreferredTheme());
      }
   });

   window.addEventListener("DOMContentLoaded", () => {
      showActiveTheme(getPreferredTheme());

      document.querySelectorAll("[data-bs-theme-value]").forEach((toggle) => {
         toggle.addEventListener("click", () => {
            const theme = toggle.getAttribute("data-bs-theme-value");
            setStoredTheme(theme);
            setTheme(theme);
            showActiveTheme(theme, true);
         });
      });
   });
})();
