// js/admin-tabs.js

// Function to handle tab navigation
function handleTabNavigation() {
    const navButtons = document.querySelectorAll('.nav-button');
    const contentSections = document.querySelectorAll('.content-section');

    navButtons.forEach(button => {
        button.addEventListener('click', () => {
            const contentId = button.getAttribute('data-content');

            // Show the selected content section and hide others
            contentSections.forEach(section => {
                if (section.id === contentId) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });

            // Remove 'active' class from all buttons and add to the clicked button
            navButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        });
    });
}

// Initialize tab navigation on page load
window.onload = function() {
    handleTabNavigation();
    // Optionally, you can set the default tab to be displayed
    document.querySelector('.nav-button[data-content="dashboard"]').click();
};