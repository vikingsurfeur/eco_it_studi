const quizFormId            = document.querySelector("[data-quiz-id]"),
    quizId                  = quizFormId.dataset.quizId,
    quizSubmitButton        = document.querySelector("#quizSubmitButton"),
    quizCorrectingButton    = document.querySelector("#quizCorrectingButton"),   
    answerCheckboxes        = document.querySelectorAll("[data-correct-answer]"),
    messageContainer        = document.querySelector("#quizResult"),
    currentURL              = window.location.href;

// Initializing the quiz result   
let correctAnswer = 0;
let falseAnswer   = 0;


// Template for the message container
const messageContainerTemplate = (status, message, percentage) => {
    if (status === "success") {
        messageContainer.classList.add("alert", "alert-success", "mt-4");
        messageContainer.attributes = {
            role: "alert"
        };
        messageContainer.innerHTML = `
            <strong>${message}</strong>
            <span>Avec ${parseFloat(percentage).toFixed(2)}% de réussite</span>
        `;
    } else {
        messageContainer.classList.add("alert", "alert-danger", "mt-4");
        messageContainer.attributes = {
            role: "alert"
        };
        messageContainer.innerHTML = `
            <strong>${message}</strong>
            <span>Avec ${parseFloat(percentage).toFixed(2)}% de réussite</span>
        `;
    }
}

// Loop through all the answer checkboxes and count the number of correct answers
const handleCorrectAnswer = () => {
    answerCheckboxes.forEach((answerCheckbox) => {
        answerCheckbox.checked &&
        answerCheckbox.dataset.correctAnswer === "true"
            ? correctAnswer++
            : null;
        
        answerCheckbox.checked &&
        answerCheckbox.dataset.correctAnswer === "false"
            ? falseAnswer++
            : null;
    });
};

// Fetching the quiz result
const fetchQuizResult = async (quizId, fetchingURL) => {
    const fetchingOptions = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            falseAnswer,
            correctAnswer,
        }),
    };

    try {
        const response = await fetch(fetchingURL, fetchingOptions);
        const responseData = await response.json();

        if (responseData.status === "success") {
            const { message, percentage } = responseData;
            correctAnswer = 0;
            falseAnswer = 0;
            messageContainerTemplate(responseData.status, message, percentage);
            quizCorrectingButton.classList.remove("d-none");
        } else {
            const { message, percentage } = responseData;
            correctAnswer = 0;
            falseAnswer = 0;
            messageContainerTemplate(responseData.status, message, percentage);
            quizCorrectingButton.classList.remove("d-none");
        }
    } catch (error) {
        messageContainerTemplate(quizId, "error", "Une erreur est survenue");
        console.error(error);
    }
}

// Event listener for the quiz result
quizSubmitButton.addEventListener("click", (event) => {
    event.preventDefault();
    handleCorrectAnswer();
    const fetchingURL = `${currentURL}/submit/${quizId}`;
    fetchQuizResult(quizId, fetchingURL);
});

// Event listener for the quiz correcting button
quizCorrectingButton.addEventListener("click", (event) => {
    event.preventDefault();

    answerCheckboxes.forEach((answerCheckbox) => {
        !answerCheckbox.checked && answerCheckbox.dataset.correctAnswer === "true" && (
            answerCheckbox.classList.add("is-valid", "bg-success"),
            answerCheckbox.setAttribute("disabled", "disabled"),
            answerCheckbox.setAttribute("checked", "checked")
        );

        answerCheckbox.checked &&
            answerCheckbox.dataset.correctAnswer === "false" &&
            answerCheckbox.classList.add("is-invalid");
    });
});