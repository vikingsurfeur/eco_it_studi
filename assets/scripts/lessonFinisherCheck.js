const inputLessonFinisher   = document.querySelectorAll("#isFinished"),
    currentURL              = window.location.href;

// Template for the message container
const messageContainerTemplate = (lessonId, status, message) => {
    const messageContainer = document.querySelector(`#isFinishedMessage${lessonId}`);
    
    if (status === "success") {
        messageContainer.classList.add("alert", "alert-success", "mt-4");
        messageContainer.attributes = {
            role: "alert"
        };
        messageContainer.innerHTML = `<strong>${message}</strong>`;
    } else {
        messageContainer.classList.add("alert", "alert-danger", "mt-4");
        messageContainer.attributes = {
            role: "alert"
        };
        messageContainer.innerHTML = `<strong>${message}</strong>`;
    }
};

// Fetching lesson finished 
const fetchLessonFinisher = async (lessonId, fetchingURL, inputLessonFinisherCheck) => {
    const fetchingOptions = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: lessonId,
    };

    try {
        const response = await fetch(fetchingURL, fetchingOptions);
        const responseData = await response.json();
        console.log(responseData);

        if (responseData.status === "success") {
            const { message } = responseData;
            messageContainerTemplate(lessonId, responseData.status, message);
            inputLessonFinisherCheck.disabled = true;
            
        } else {
            const { message } = responseData;
            messageContainerTemplate(lessonId, responseData.status, message);
        }
    } catch (error) {
        messageContainerTemplate(lessonId, "error", "Une erreur est survenue");
        console.error(error);
    }
};

// Event listener check if the lesson is finished
inputLessonFinisher.forEach((input) => {
    input.addEventListener("change", (event) => {
        event.preventDefault();
        const lessonId = event.target.value;
        const inputLessonFinisherCheck = document.querySelector(`input[name="isFinished${lessonId}"]`);
        const fetchingURL = `${currentURL}/lesson/${lessonId}/finished`;
        fetchLessonFinisher(lessonId, fetchingURL, inputLessonFinisherCheck);
    });
});
