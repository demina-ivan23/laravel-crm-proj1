/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

 const app = createApp({
    data() {
        return {
            showLeadAddition: false,
            showCustomCategoryInput: false,
            showCustomProspectStateInput: false
        };
    },
    methods: {
        async handleCategoryChange() {
            let val = document.getElementById('category_select').value;
            if (val === 'custom') {
                this.showCustomCategoryInput = true;
            } else {
                this.showCustomCategoryInput = false;
            }
        },
        async handleProspectStateChange() {
            let val = document.getElementById('prospect_state_select').value;
            if (val === 'custom') {
                this.showCustomProspectStateInput = true;
            } else {
                this.showCustomProspectStateInput = false;
            }
        },
        async applyFilters() {
            var selectedFilters = {};
            var checkboxes = document.querySelectorAll('.filter-checkbox:checked');
            checkboxes.forEach(function (checkbox) {
                var filterName = checkbox.getAttribute('name');
                var filterValue = checkbox.value;
                if (!selectedFilters.hasOwnProperty(filterName)) {
                    selectedFilters[filterName] = [];
                }
                selectedFilters[filterName].push(filterValue);
            });

            var currentUrl = window.location.href.split('?')[0];
            var queryParams = [];
            for (var key in selectedFilters) {
                queryParams.push(key + '=' + selectedFilters[key].join(',')); 
            }
            var newUrl = currentUrl + '?' + queryParams.join('&');

            window.location.href = newUrl;

            localStorage.clear();
            checkboxes.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        localStorage.setItem(checkbox.value, true);
                    } else {
                        localStorage.removeItem(checkbox.value); // Remove state from localStorage if unchecked
                    }
            });
        },
        async addListenersToFilterCheckboxes() {
            var checkboxes = document.querySelectorAll('.filter-checkbox');

            checkboxes.forEach(function (checkbox) {
                var isChecked = localStorage.getItem(checkbox.value);
                if (isChecked === 'true') {
                    console.log(checkbox);
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', this.applyFilters);
            });
        }
    },
    mounted() {
        this.addListenersToFilterCheckboxes();
    }
});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
