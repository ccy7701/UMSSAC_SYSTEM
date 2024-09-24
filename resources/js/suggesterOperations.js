document.addEventListener("DOMContentLoaded", function() {
    // Get the steps and their next/previous buttons by ID
    const steps = Array.from(document.querySelectorAll(".form-step"));
    let currentStepIndex = 0;

    // Buttons
    const nextWTC = document.getElementById("next-step-wtc");
    const previousWTC = document.getElementById("previous-step-wtc");

    const nextBFI = document.getElementById("next-step-bfi");
    const previousBFI = document.getElementById("previous-step-bfi");

    // Initialize the button states on load
    initialiseStepButtons();
    updateStepVisibility();

    // Event listeners for the WTC step navigation
    nextWTC.addEventListener("click", () => {
        if (!nextWTC.disabled) {
            changeStep("next");
            scrollToTop();
        }
    });

    previousWTC.addEventListener("click", () => {
        if (!previousWTC.disabled) {
            changeStep("prev");
            scrollToTop();
        }
    });

    // Event listeners for the BFI step navigation
    nextBFI.addEventListener("click", () => {
        if (!nextBFI.disabled) {
            changeStep("next");
            scrollToTop();
        }
    });

    previousBFI.addEventListener("click", () => {
        if (!previousBFI.disabled) {
            changeStep("prev");
            scrollToTop();
        }
    });

    // Function to move between steps
    function changeStep(direction) {
        let currentStep = steps[currentStepIndex];
        currentStep.classList.add("d-none");

        if (direction === "next" && currentStepIndex < steps.length - 1) {
            currentStepIndex++;
        } else if (direction === "prev" && currentStepIndex > 0) {
            currentStepIndex--;
        }

        updateStepVisibility();
    }

    // Function to show the correct step and adjust button states
    function updateStepVisibility() {
        // Hide all steps first
        steps.forEach(step => {
            step.classList.add("d-none");
        });
        
        // Show the current step
        let currentStep = steps[currentStepIndex];
        currentStep.classList.remove("d-none");

        // Enable or disable buttons based on the current step
        initialiseStepButtons();
    }

    // Function to check if all radio groups in a step are filled
    function checkRadioGroupsFilled(step) {
        const radioGroups = step.querySelectorAll('input[type="radio"]');
        const groupNames = [...new Set(Array.from(radioGroups).map(radio => radio.name))];
        
        return groupNames.every(name => {
            const radios = step.querySelectorAll(`input[name="${name}"]`);
            return Array.from(radios).some(radio => radio.checked);
        });
    }

    // Function to initialise and control the Next/Previous button states
    function initialiseStepButtons() {
        const currentStep = steps[currentStepIndex];

        // Handle button states for the WTC step
        if (currentStep.id === "form-step-wtc") {
            const allFilled = checkRadioGroupsFilled(currentStep);
            nextWTC.disabled = !allFilled;
            previousWTC.disabled = currentStepIndex === 0; // Disable "Previous" on first step
        }

        // Handle button states for the BFI step
        if (currentStep.id === "form-step-bfi") {
            const allFilled = checkRadioGroupsFilled(currentStep);
            nextBFI.disabled = !allFilled;
            previousBFI.disabled = currentStepIndex === 0; // Disable "Previous" on first step
        }
    }

    // Function to scroll the page to the top when changing steps
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Check if radio groups are filled when radio buttons change (for enabling/disabling "Next" button)
    function attachRadioChangeListeners(step) {
        const radioInputs = step.querySelectorAll('input[type="radio"]');
        radioInputs.forEach(radio => {
            radio.addEventListener('change', function() {
                initialiseStepButtons(); // Re-check when any radio button is changed
            });
        });
    }

    // Attach listeners to radio inputs on both WTC and BFI steps
    attachRadioChangeListeners(document.getElementById('form-step-wtc'));
    attachRadioChangeListeners(document.getElementById('form-step-bfi'));
});
