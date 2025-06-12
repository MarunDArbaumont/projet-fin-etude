console.log("_________MOBILE NAV_________");
const burger = document.querySelector(".burger-menu");
const mobileNav = document.querySelector(".header-nav-mobile");
console.log(mobileNav, burger);
burger.addEventListener("click", () => {
  if (mobileNav.style.display == "none") {
    mobileNav.style.display = "flex";
    mobileNav.style.opacity = 1;
  } else {
    mobileNav.style.display = "none";
    mobileNav.style.opacity = 0;
  }
});
