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

// Load categories into the dropdown
function loadCategories() {
    $.ajax({
        type: "GET",
        url: 'Services/GetCategoriesService.php',
        success: function(response) {
            const categories = JSON.parse(response);
            const categorySelect = document.getElementById('product-category');
            categorySelect.innerHTML = '<option value="" disabled selected>Select a Category</option>';
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.CategoryID;
                option.textContent = category.category_name;
                categorySelect.appendChild(option);
            });
        }
    });
}

// Add event listener to handle category form submission
document.getElementById('add-category-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const categoryName = document.getElementById('category-name').value;
    const categoryDescription = document.getElementById('category-description').value;

    $.ajax({
        type: "POST",
        url: 'Services/AddCategoryService.php',
        data: { categoryName, categoryDescription },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert('Category added successfully!');
                loadCategories();
            } else {
                alert('Failed to add category.');
            }
        }
    });
});

// Add event listener to handle product form submission
document.getElementById('add-product-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const productName = document.getElementById('product-name').value;
    const productCategory = document.getElementById('product-category').value;
    const productImage = document.getElementById('product-image').files[0];
    const productDescription = document.getElementById('product-description').value;
    const productPrice = document.getElementById('product-price').value;

    const formData = new FormData();
    formData.append('productName', productName);
    formData.append('productCategory', productCategory);
    formData.append('productImage', productImage);
    formData.append('productDescription', productDescription);
    formData.append('productPrice', productPrice);

    $.ajax({
        type: "POST",
        url: 'Services/AddItemService.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert('Product added successfully!');
            } else {
                alert('Failed to add product.');
            }
        }
    });
});

// Load categories and handle tab navigation on page load
window.onload = function() {
    loadCategories();
    handleTabNavigation();
};