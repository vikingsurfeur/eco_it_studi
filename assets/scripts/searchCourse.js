const searchForm        = document.querySelector("#searchForm"),
    searchInput         = document.querySelector("#searchInput"),
    searchResult        = document.querySelector("#searchResult"),
    fetchingCourseURL   = `${searchForm.action}`;

// Clear search result function
const clearSearchContainer = (bool) => {
    bool ?
        setTimeout(() => {
            searchResult.innerHTML = "";
        }, 3000) :
        searchResult.innerHTML = "";
}

// HTML template for not found result
const divNotFound = document.createElement("div");
divNotFound.classList.add("alert", "alert-warning", "mt-4");
divNotFound.attributes = {
    role: "alert"
};
divNotFound.innerHTML = `<strong>Désolé, aucun cours ne correspond à votre recherche...</strong>`;

// HTML template for error result
const divError = document.createElement("div");
divError.classList.add("alert", "alert-danger", "mt-4");
divError.attributes = {
    role: "alert"
};
divError.innerHTML = `<strong>Désolé, une erreur est survenue...</strong>`;

// Fetching course async function
const fetchCourseRequest = async (url) => {
    const formData = new FormData(searchForm);

    const fetchingOptions = {
        method: "POST",
        body: formData,
    };

    try {
        // Fetching the data from the server
        const response = await fetch(url, fetchingOptions);
        const htmlResponse = await response.text();

        // Parsing the data and creating a virtual DOM elements
        const createVirtualDOM = new DOMParser().parseFromString(
            htmlResponse,
            "text/html"
        );
        const coursesResult = createVirtualDOM.querySelector("#searchResult").innerHTML;

        // Parsing the response and define if the search are an empty string
        const notFoundCheckingCoursesResult = coursesResult.replace(/\s/g, "");

        // Clear the search result
        clearSearchContainer(false);

        // Add the search result to the DOM
        if (notFoundCheckingCoursesResult.length !== 0) {
            searchResult.innerHTML = coursesResult;
        } else {
            searchResult.appendChild(divNotFound);
            clearSearchContainer(true);
        }
    } catch (error) {
        searchResult.appendChild(divError);
        clearSearchContainer(true);
        console.error(error);
    }
};

// Event listener request search courses
searchForm.addEventListener("submit", (event) => {
    event.preventDefault();
    fetchCourseRequest(fetchingCourseURL);
});
