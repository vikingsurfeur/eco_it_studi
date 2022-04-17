const btnScrollToTop = document.getElementById("btnScrollToTop");

// If the first time of scrolling, the button will be hidden
window.addEventListener("scroll", () => {
    if (window.scrollY > 800) {
        btnScrollToTop.classList.add("btnScrollVisible");
    } else {
        btnScrollToTop.classList.remove("btnScrollVisible");
    }
});

btnScrollToTop.addEventListener("click", (event) => {
    event.preventDefault();

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});
