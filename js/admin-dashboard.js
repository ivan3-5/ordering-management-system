// DSAHBOARD

// yearly orders graph
const yearlyCtx = document.getElementById('yearlyOrdersGraph').getContext('2d');
const yearlyOrdersGraph = new Chart(yearlyCtx, {
    type: 'line', // Line graph
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Months of the year
        datasets: [{
            label: 'Orders This Year',
            data: [120, 200, 150, 300, 400, 500, 600, 700, 800, 950, 1100, 1200], // Example data for orders each month
            borderColor: 'rgb(75, 192, 192)', // Line color
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color under the line
            fill: true,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// monthly orders graph
const monthlyCtx = document.getElementById('monthlyOrdersGraph').getContext('2d');
const monthlyOrdersGraph = new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], //  data for weeks
        datasets: [{
            label: 'Orders This Month',
            data: [30, 45, 60, 80], // Example for weekly orders in a month
            borderColor: 'rgb(54, 162, 235)', 
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            fill: true,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// quarterly orders graph
const quarterlyCtx = document.getElementById('quarterlyOrdersGraph').getContext('2d');
const quarterlyOrdersGraph = new Chart(quarterlyCtx, {
    type: 'line',
    data: {
        labels: ['September', 'October', 'November', 'December'], // quarters 
        datasets: [{
            label: 'Orders This Quarter',
            data: [120, 150, 180, 220], // quarterly orders
            borderColor: 'rgb(153, 102, 255)',
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            fill: true,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const fetchDashboardData = () => {
    // data
    const data = {
        totalOrders: 120,  
        totalEarnings: 5400,  
        totalTickets: 15,   
        totalRefunds: 3    
    };

    document.getElementById('totalOrders').textContent = data.totalOrders;
    document.getElementById('totalEarnings').textContent = data.totalEarnings;
    document.getElementById('totalTickets').textContent = data.totalTickets;
    document.getElementById('totalRefunds').textContent = data.totalRefunds;
};

// function to update statistics when the page loads
window.onload = function() {
    fetchDashboardData();
    loadCategories();
};