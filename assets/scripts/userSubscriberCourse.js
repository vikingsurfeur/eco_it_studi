const userSubscriberCourseForm = document.querySelector('#userSubscriberCourseForm'),
    userSubscriberCourseFormMessage = document.querySelector('#userSubscriberCourseFormMessage');
    userSubscriberCourseFormURL = `${userSubscriberCourseForm.action}`;

// Template message container
const messageContainerTemplate = (status, message) => {
    if (status === "success") {
        userSubscriberCourseFormMessage.classList.add(
            "alert",
            "alert-success",
            "mt-4"
        );
        userSubscriberCourseFormMessage.attributes = {
            role: "alert",
        };
        userSubscriberCourseFormMessage.innerHTML = `<strong>${message}</strong>`;
    } else {
        userSubscriberCourseFormMessage.classList.add(
            "alert",
            "alert-danger",
            "mt-4"
        );
        userSubscriberCourseFormMessage.attributes = {
            role: "alert",
        };
        userSubscriberCourseFormMessage.innerHTML = `<strong>${message}</strong>`;
    }
};

// Fetching course subscription
const fetchUserSubscriberCourse = async (url) => {
    const formData = new FormData(userSubscriberCourseForm);

    const fetchingOptions = {
        method: "POST",
        body: formData,
    };

    try {
        const response = await fetch(url, fetchingOptions);
        const responseData = await response.json();

        if (responseData.status === "success") {
            const { message } = responseData;
            messageContainerTemplate(responseData.status, message);
        } else {
            const { message } = responseData;
            messageContainerTemplate(responseData.status, message);
        }
    } catch (error) {
        messageContainerTemplate("error", "Une erreur est survenue");
        console.error(error);
    }
};

// Event listener for the form
userSubscriberCourseForm.addEventListener("submit", (event) => {
    event.preventDefault();
    fetchUserSubscriberCourse(userSubscriberCourseFormURL);
});