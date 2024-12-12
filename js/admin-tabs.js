// Function to handle tab navigation
function handleTabNavigation() {
    const navButtons = document.querySelectorAll('.nav-button');
    const contentSections = document.querySelectorAll('.content-section');

    navButtons.forEach(button => {
        button.addEventListener('click', () => {
            const contentId = button.getAttribute('data-content');

            contentSections.forEach(section => {
                if (section.id === contentId) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });

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