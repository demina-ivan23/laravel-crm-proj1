/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { Chart } from "chart.js/auto";


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
        handleCategoryChange() {
            let val = document.getElementById('category_select').value;
            if (val === 'custom') {
                this.showCustomCategoryInput = true;
            } else {
                this.showCustomCategoryInput = false;
            }
        },
        handleProspectStateChange() {
            let val = document.getElementById('prospect_state_select').value;
            if (val === 'custom') {
                this.showCustomProspectStateInput = true;
            } else {
                this.showCustomProspectStateInput = false;
            }
        },
        applyFilters() {
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

            sessionStorage.clear();
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    sessionStorage.setItem(checkbox.value, true);
                } else {
                    sessionStorage.removeItem(checkbox.value);
                }
            });
        },
        addListenersToFilterCheckboxes() {
            var checkboxes = document.querySelectorAll('.filter-checkbox');

            checkboxes.forEach(function (checkbox) {
                var isChecked = sessionStorage.getItem(checkbox.value);
                if (isChecked === 'true') {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', this.applyFilters);
            });
        },
        getDaysBetweenDates(startDateString, endDateString) {
            const days = [];
            let currentDate = new Date(startDateString);
            let endDate = new Date(endDateString);
            while (currentDate <= endDate) {
                days.push(new Date(currentDate).getDate());
                currentDate.setDate(currentDate.getDate() + 1);
            }

            return days;
        },
        drawSuperadminOrderCharts() {
            const queryVars = this.getQueryVars();
            let days = [];
            let el = '';
            if (queryVars['order_product_chart_to'] != null && queryVars['order_product_chart_from'] != null) {
                days = this.getDaysBetweenDates(queryVars['order_product_chart_from'], queryVars['order_product_chart_to']);
                this.drawSuperadminProductOrderChart(days, document.getElementById('order_product_data').value ?? []);
                document.getElementById('product_category').value = queryVars['product_category'] ?? 'all';
                el = 'product';
            } else if(queryVars['order_prospect_chart_to'] != null && queryVars['order_prospect_chart_from'] != null){
                days = this.getDaysBetweenDates(queryVars['order_prospect_chart_from'], queryVars['order_prospect_chart_to']);
                this.drawSuperadminProspectOrderChart(days, document.getElementById('order_prospect_data').value ?? [])
                el = 'prospect';
                document.getElementById('prospect_state').value = queryVars['prospect_state'] ?? 'all';
            }
            
            document.getElementById('order_'+el+'_chart_from').value = queryVars['order_'+el+'_chart_from'] ?? '';
            document.getElementById('order_'+el+'_chart_to').value = queryVars['order_'+el+'_chart_to'] ?? '';
            

        },
        getQueryVars() {
            const queryString = window.location.search.substring(1);
            const params = new URLSearchParams(queryString);
            const queryVars = {};

            for (const [key, value] of params.entries()) {
                queryVars[key] = value;
            }

            return queryVars;
        },
        rand(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },
        drawSuperadminProductOrderChart(days, jsonedProducts) {
            const orderProductsArray = JSON.parse(jsonedProducts);
            const daysCount = days.length;
            if (daysCount == 0) {
                return;
            }
            const labels = days;
            const datasets = [];
            for (let orderProductArray of orderProductsArray) {
                console.log(orderProductArray);
                let footerInfo = [];
                for (let i = 0; i < orderProductArray.products.length; i++) {
                    let orderStatuses = orderProductArray.order_statuses[i];
                    let statusInfo = {  }; // Initialize status info object with the day
                    for (let status in orderStatuses) {
                        // Iterate over each status dynamically and add it to the status info object
                        statusInfo[status] = orderStatuses[status];
                    }
                    footerInfo.push(statusInfo); // Push the status info object to footerInfo array
                }
                datasets.push({
                    label: orderProductArray.category,
                    data: orderProductArray.products,
                    footer: footerInfo,
                    backgroundColor: `rgba(${this.rand(10, 100)}, ${this.rand(20, 200)}, ${this.rand(20, 200)}, 0.6)`,
                });
            }
            const data = {
                labels: labels,
                datasets: datasets
            };
            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Product-related Chart'
                        },
                        tooltip: {
                            callbacks: {
                                footer: function (tooltipItems) {
                                    const datasetIndex = tooltipItems[0].datasetIndex;
                                    const day = tooltipItems[0].dataIndex; 
                                    const footerObject = tooltipItems[0].chart.data.datasets[datasetIndex].footer[day];
                                    let footerString = 'Order statuses: ';
                                    for (let status in footerObject) {
                                        footerString += `${status}: ${footerObject[status]}, `;
                                    }
                                    footerString = footerString.slice(0, -2);
                                    return footerString;
                                }
                            }
                        }
                        
                        
                    },
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    },

                }
            };

            const productOrderCanvas = document.getElementById('productOrderChartCanvas');
            const productOrderChart = new Chart(productOrderCanvas, config);
        },
        drawSuperadminProspectOrderChart(days, jsonedProspects) {
            const orderProspectsArray = JSON.parse(jsonedProspects);
            const daysCount = days.length;
            if (daysCount == 0) {
                console.log('hi');
                return;
            }
            const labels = days;
            const datasets = [];
            for (let orderProspectArray of orderProspectsArray) {
                console.log(orderProspectArray);
                let footerInfo = [];
                for (let i = 0; i < orderProspectArray.customer.length; i++) {
                    let orderStatuses = orderProspectArray.order_statuses[i];
                    let statusInfo = {  };
                    for (let status in orderStatuses) {
                        statusInfo[status] = orderStatuses[status];
                    }
                    footerInfo.push(statusInfo);
                }
                console.log(footerInfo);
                datasets.push({
                    label: orderProspectArray.state,
                    data: orderProspectArray.customer,
                    footer: footerInfo,
                    backgroundColor: `rgba(${this.rand(10, 100)}, ${this.rand(20, 200)}, ${this.rand(20, 200)}, 0.6)`,
                });
            }
            const data = {
                labels: labels,
                datasets: datasets
            };
            const config = {
                type: 'bar',
                data: data,
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Prospect-related Chart'
                        },
                        tooltip: {
                            callbacks: {
                                footer: function (tooltipItems) {
                                    const datasetIndex = tooltipItems[0].datasetIndex;
                                    const day = tooltipItems[0].dataIndex; 
                                    const footerObject = tooltipItems[0].chart.data.datasets[datasetIndex].footer[day];
                                    let footerString = 'Order statuses: ';
                                    for (let status in footerObject) {
                                        footerString += `${status}: ${footerObject[status]}, `;
                                    }
                                    footerString = footerString.slice(0, -2);
                                    return footerString;
                                }
                            }
                        }  
                        
                    },
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    },

                }
            };

            const prospectOrderCanvas = document.getElementById('prospectOrderChartCanvas');
            const prospectOrderChart = new Chart(prospectOrderCanvas, config);
        },
        incrementDecrementProductCount(productId, action) {
            let productCount = parseInt(document.getElementById('product_count_' + productId).value);
            if (action == 'increment') {
                productCount++;
            } else if (action == 'decrement') {
                productCount--;
                if (productCount <= 0) {
                    productCount = 0;
                }
            }
            if (productCount > 0) {
                let selectedProducts = JSON.parse(sessionStorage.getItem('selected_products')) || {};
                selectedProducts[productId] = productCount;
                sessionStorage.setItem('selected_products', JSON.stringify(selectedProducts));
                document.getElementById('product_' + productId).classList.add('border-info');
                document.getElementById('product_' + productId).classList.add('border-2');
            } else {
                let selectedProducts = JSON.parse(sessionStorage.getItem('selected_products')) || {};
                delete selectedProducts[productId];
                sessionStorage.setItem('selected_products', JSON.stringify(selectedProducts));
                document.getElementById('product_' + productId).classList.remove('border-info');
                document.getElementById('product_' + productId).classList.remove('border-2');
            }
            document.getElementById('product_count_' + productId).value = productCount;
        },
        handleSelectedProductsReload() {
            let selectedProducts = JSON.parse(sessionStorage.getItem('selected_products')) || {};
            Object.entries(selectedProducts).forEach(([productId, productCount]) => {
                if (document.getElementById('product_count_' + productId) ?? false) {
                    document.getElementById('product_count_' + productId).value = productCount;
                    document.getElementById('product_' + productId).classList.add('border-info');
                    document.getElementById('product_' + productId).classList.add('border-2');
                }

            });
        },
        handleProductsArrayTransmission() {
            let selectedProducts = JSON.parse(sessionStorage.getItem('selected_products')) || {};

            // Check if selectedProducts is not empty
            if (Object.keys(selectedProducts).length !== 0) {
                let form = document.getElementById('select_products_form') || null;
                if(form){
                    document.getElementById('selected_products_json').value = sessionStorage.getItem('selected_products');
                    sessionStorage.removeItem('selected_products');
                    form.submit()
                }
            } else {
                return alert('You haven\'t selected any products');
            }

        },
    },
        mounted() {
            this.addListenersToFilterCheckboxes();
            this.drawSuperadminOrderCharts();
            this.handleSelectedProductsReload();
        }
    });

import ExampleComponent from './components/ExampleComponent.vue';
import { EMPTY_OBJ } from '@vue/shared';
import { formToJSON } from 'axios';
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
