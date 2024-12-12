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

// Function to handle soft delete of category
function softDeleteCategory(categoryId) {
    if (confirm('Are you sure you want to archive this category?')) {
        $.ajax({
            type: "POST",
            url: 'Services/DeleteService.php',
            data: { action: 'softDelete', type: 'category', id: categoryId },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === "success") {
                    alert('Category archived successfully!');
                    loadMenuLists();
                } else {
                    alert(data.message || 'Failed to archive category.');
                }
            }
        });
    }
}

// Function to handle hard delete of category
function hardDeleteCategory(categoryId) {
    if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
        $.ajax({
            type: "POST",
            url: 'Services/DeleteService.php',
            data: { action: 'hardDelete', type: 'category', id: categoryId },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === "success") {
                    alert('Category deleted successfully!');
                    loadMenuLists();
                } else {
                    alert(data.message || 'Failed to delete category.');
                }
            }
        });
    }
}

// Function to handle soft delete of item
function softDeleteItem(itemId) {
    if (confirm('Are you sure you want to archive this item?')) {
        $.ajax({
            type: "POST",
            url: 'Services/DeleteService.php',
            data: { action: 'softDelete', type: 'item', id: itemId },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === "success") {
                    alert('Item archived successfully!');
                    loadMenuLists();
                } else {
                    alert('Failed to archive item.');
                }
            }
        });
    }
}

// Function to handle hard delete of item
function hardDeleteItem(itemId) {
    if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        $.ajax({
            type: "POST",
            url: 'Services/DeleteService.php',
            data: { action: 'hardDelete', type: 'item', id: itemId },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.status === "success") {
                    alert('Item deleted successfully!');
                    loadMenuLists();
                } else {
                    alert('Failed to delete item.');
                }
            }
        });
    }
}

// Function to load categories and items into the lists
function loadMenuLists() {
    $.ajax({
        type: "GET",
        url: 'Services/GetMenuListsService.php',
        success: function(response) {
            const data = JSON.parse(response);
            const categories = data.categories;
            const items = data.items;

            // Load categories into the table
            const categoryListTable = document.getElementById('categoryListTable').getElementsByTagName('tbody')[0];
            categoryListTable.innerHTML = '';
            categories.forEach(category => {
                const row = categoryListTable.insertRow();
                row.innerHTML = `
                    <td data-label="ID">${category.CategoryID}</td>
                    <td data-label="Category Name">${category.category_name}</td>
                    <td data-label="Description">${category.description}</td>
                    <td data-label="Action">
                        <button onclick="softDeleteCategory('${category.CategoryID}')">Archive</button>
                        <button onclick="hardDeleteCategory('${category.CategoryID}')">Delete</button>
                    </td>
                `;
            });

            // Load categories into the dropdown
            const categoryDropdown = document.getElementById('item-category');
            categoryDropdown.innerHTML = '<option value="" disabled selected>Select a Category</option>';
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.CategoryID;
                option.textContent = category.category_name;
                categoryDropdown.appendChild(option);
            });

            // Load items into the table
            const itemListTable = document.getElementById('itemListTable').getElementsByTagName('tbody')[0];
            itemListTable.innerHTML = '';
            items.forEach(item => {
                const row = itemListTable.insertRow();
                row.innerHTML = `
                    <td data-label="ID">${item.ItemID}</td>
                    <td data-label="Item Name">${item.item_name}</td>
                    <td data-label="Description">${item.description}</td>
                    <td data-label="Price">${item.price}</td>
                    <td data-label="Category ID">${item.CategoryID}</td>
                    <td data-label="Action">
                        <button onclick="softDeleteItem('${item.ItemID}')">Archive</button>
                        <button onclick="hardDeleteItem('${item.ItemID}')">Delete</button>
                    </td>
                `;
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
                loadMenuLists();
            } else {
                alert('Failed to add category.');
            }
        }
    });
});

// Add event listener to handle item form submission
document.getElementById('add-item-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const itemName = document.getElementById('item-name').value;
    const itemCategory = document.getElementById('item-category').value;
    const itemImage = document.getElementById('item-image').files[0];
    const itemDescription = document.getElementById('item-description').value;
    const itemPrice = document.getElementById('item-price').value;

    const formData = new FormData();
    formData.append('itemName', itemName);
    formData.append('itemCategory', itemCategory);
    formData.append('itemImage', itemImage);
    formData.append('itemDescription', itemDescription);
    formData.append('itemPrice', itemPrice);

    $.ajax({
        type: "POST",
        url: 'Services/AddItemService.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert('Item added successfully!');
                loadMenuLists();
            } else {
                alert('Failed to add item.');
            }
        }
    });
});

// Load categories and items on DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    handleTabNavigation();
    loadMenuLists();
});