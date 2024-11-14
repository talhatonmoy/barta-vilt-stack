// src/VueCustomDirectives/ClickAway.js
export default {
    beforeMount(el, binding) {
        // Define a function that will handle clicks outside the element
        const clickOutsideHandler = (event) => {
            // Check if the clicked target is outside the element
            if (!(el === event.target || el.contains(event.target))) {
                // If the binding value is a function, call it
                if (typeof binding.value === 'function') {
                    binding.value(event);
                }
                // If the binding value is a string (JavaScript expression), evaluate it
                else if (typeof binding.value === 'string') {
                    // Use eval to execute the expression in the context of the Vue component
                    // Caution: Use eval with care as it can introduce security risks
                    try {
                        const result = eval(binding.value);
                        // You might want to handle result or further actions here
                    } catch (error) {
                        console.error("Error executing expression:", error);
                    }
                }
                // If it's neither, log an error
                else {
                    console.error("v-click-away: Expected a function or a string as the value.");
                }
            }
        };

        // Add the event listener for clicks
        document.addEventListener('click', clickOutsideHandler);

        // Store the handler on the element for cleanup
        el.__clickOutsideHandler__ = clickOutsideHandler;
    },
    unmounted(el) {
        // Remove the event listener when the element is unmounted
        document.removeEventListener('click', el.__clickOutsideHandler__);
        delete el.__clickOutsideHandler__;
    }
};
