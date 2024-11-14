// Import necessary functions and libraries from Vue and Inertia
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from '../../vendor/tightenco/ziggy'; // Ziggy for route handling
import NProgress from 'nprogress'; // Progress bar library
import { router } from '@inertiajs/vue3'; // Inertia router

// Importing my custom directive 
import ClickAway from './VueCustomDirectives/ClickAway'; // Import your custom directive

// Create Inertia App
createInertiaApp({
    // Resolves the page components based on their name
    resolve: name => {
        // Use import.meta.glob to dynamically load all Vue components in Pages directory eagerly
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`]; // Return the specific page component
    },
    setup({ el, App, props, plugin }) {
        // Create the Vue application instance with the root component and props
        const app = createApp({
            render: () => h(App, props), // Render the App component with props
        });

        // Register my custom directive 'click-away'
        app.directive('click-away', ClickAway); 

        // Use Inertia plugin for handling navigation and state management
        app.use(plugin);

        // Use ZiggyVue for route management based on Laravel routes
        app.use(ZiggyVue);

        //Outside click detection vue plugin -> v-click-outside="resetTextareaRowNumber"
        app.use(vClickOutside)

        // Mount the Vue application to the DOM element specified by 'el'
        app.mount(el);
    },
});

/**
 * NProgress Setup - Handling progress bar display based on navigation events
 */
router.on('start', () => NProgress.start()); // Start progress bar when navigation starts
router.on('finish', (event) => {
    if (event.detail.visit.completed) {
        NProgress.done(); // Complete progress bar if visit is finished successfully
    } else if (event.detail.visit.interrupted || event.detail.visit.cancelled) {
        NProgress.set(0); // Reset progress bar if visit is interrupted or cancelled
        NProgress.done(); // Complete progress bar in case of interruption or cancellation
    }
});
