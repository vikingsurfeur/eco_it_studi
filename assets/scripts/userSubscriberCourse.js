const userSubscriberCourseForm = document.querySelector('#userSubscriberCourseForm'),
    userSubscriberCourseFormMessage = document.querySelector('#userSubscriberCourseFormMessage');
    userSubscriberCourseFormURL = `${userSubscriberCourseForm.action}`;

const fetchUserSubscriberCourse = async (url) => {
    const formData = new FormData(userSubscriberCourseForm);

    const fetchingOptions = {
        method: "POST",
        body: formData,
    };

    try {
        const response = await fetch(url, fetchingOptions);
        const responseData = await response.json();
        console.log(responseData);

        if (responseData.status === "success") {
            const { message } = responseData;

            userSubscriberCourseFormMessage.innerHTML = message;
            userSubscriberCourseFormMessage.classList.add(
                "alert",
                "alert-success"
            );
        }
    } catch (error) {
        userSubscriberCourseFormMessage.innerHTML = "Désolé, une erreur est survenue";
        userSubscriberCourseFormMessage.classList.add("alert", "alert-danger");
        console.error(error);
    }
};

userSubscriberCourseForm.addEventListener("submit", (event) => {
    event.preventDefault();
    fetchUserSubscriberCourse(userSubscriberCourseFormURL);
});