const btnScrollToTop = document.getElementById("btnScrollToTop");

window.addEventListener("scroll", () => {
    if (window.scrollY > 800) {
        btnScrollToTop.classList.add("btnScrollVisible");
        btnScrollToTop.classList.remove("btnScrollHidde");
    } else {
        btnScrollToTop.classList.remove("btnScrollVisible");
        btnScrollToTop.classList.add("btnScrollHidde");
    }
});

btnScrollToTop.addEventListener("click", (event) => {
    event.preventDefault();

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});
