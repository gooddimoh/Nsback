// Service
const MODULE_PREFIX = "userData_";
const EMAIL_PREFIX = MODULE_PREFIX + "email";

const saveEmail = email => {
    localStorage.setItem(EMAIL_PREFIX, email);
};
const getEmail = () => {
    return localStorage.getItem(EMAIL_PREFIX);
}

// Client
const init = () => {
    const orderForm = document.getElementById("buy-form");
    const emailInput = document.getElementById("buy_email");

    if (orderForm && emailInput) {
        // Save
        orderForm.addEventListener("submit", () => {
            saveEmail(emailInput.value);
        });

        // Get
        emailInput.value = getEmail();
    }
};

// Call
init();