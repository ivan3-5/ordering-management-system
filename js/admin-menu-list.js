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

function loadMenuLists() {
    $.ajax({
        type: "GET",
        url: 'Services/GetMenuListsService.php',
        success: function(response) {
            const data = JSON.parse(response);
            const categories = data.categories;
            const items = data.items;

            const categoryMap = {};
            categories.forEach(category => {
                categoryMap[category.CategoryID] = category.category_name;
            });

            const categoryListTable = document.getElementById('categoryListTable').getElementsByTagName('tbody')[0];
            categoryListTable.innerHTML = '';
            categories.forEach(category => {
                const row = categoryListTable.insertRow();
                row.innerHTML = `
                    <td>${category.CategoryID}</td>
                    <td>${category.category_name}</td>
                    <td>${category.description}</td>
                    <td>
                        <button onclick="showUpdateCategoryModal('${category.CategoryID}', '${category.category_name}', '${category.description}')">Update</button>
                        <button onclick="softDeleteCategory('${category.CategoryID}')">Archive</button>
                        <button onclick="hardDeleteCategory('${category.CategoryID}')">Delete</button>
                    </td>
                `;
            });

            const categoryDropdown = document.getElementById('item-category');
            categoryDropdown.innerHTML = '<option value="" disabled selected>Select a Category</option>';
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.CategoryID;
                option.textContent = category.category_name;
                categoryDropdown.appendChild(option);
            });

            const itemListTable = document.getElementById('itemListTable').getElementsByTagName('tbody')[0];
            itemListTable.innerHTML = '';
            items.forEach(item => {
                const row = itemListTable.insertRow();
                row.innerHTML = `
                    <td>${item.ItemID}</td>
                    <td>${item.item_name}</td>
                    <td><img src="data:image/jpeg;base64,${item.item_image}" alt="Item Image" style="width: 50px; height: 50px;"></td>
                    <td>${item.description}</td>
                    <td>₱${parseFloat(item.price).toFixed(2)}</td>
                    <td>${categoryMap[item.CategoryID]}</td>
                    <td>
                        <button onclick="showUpdateItemModal('${item.ItemID}', '${item.item_name}', '${item.description}', ${item.price}, '${item.CategoryID}', '${item.item_image}')">Update</button>
                        <button onclick="softDeleteItem('${item.ItemID}')">Archive</button>
                        <button onclick="hardDeleteItem('${item.ItemID}')">Delete</button>
                    </td>
                `;
            });
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function showUpdateCategoryModal(categoryId, categoryName, categoryDescription) {
    const modal = document.getElementById('updateCategoryModal');
    const closeBtn = modal.querySelector('.close');

    document.getElementById('update-category-id').value = categoryId;
    document.getElementById('update-category-name').value = categoryName;
    document.getElementById('update-category-description').value = categoryDescription;

    modal.style.display = 'block';

    closeBtn.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
}
function showUpdateItemModal(itemId, itemName, itemDescription, itemPrice, itemCategory, itemImage) {
    const modal = document.getElementById('updateItemModal');
    const closeBtn = modal.querySelector('.close');

    document.getElementById('update-item-id').value = itemId;
    document.getElementById('update-item-name').value = itemName;
    document.getElementById('update-item-description').value = itemDescription;
    document.getElementById('update-item-price').value = itemPrice;

    const categoryDropdown = document.getElementById('update-item-category');
    categoryDropdown.innerHTML = document.getElementById('item-category').innerHTML;
    categoryDropdown.value = itemCategory;

    const previewElement = document.getElementById('update-item-image-preview');
    previewElement.src = `data:image/jpeg;base64,${itemImage}`;
    previewElement.style.display = 'block';

    modal.style.display = 'block';

    closeBtn.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
}

function categoryHasItems(categoryId, callback) {
    $.ajax({
        type: "GET",
        url: 'Services/CheckCategoryItemsService.php',
        data: { categoryId: categoryId },
        success: function(response) {
            const data = JSON.parse(response);
            callback(data.hasItems);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            callback(false);
        }
    });
}

function softDeleteCategory(categoryId) {
    categoryHasItems(categoryId, function(hasItems) {
        if (hasItems) {
            alert('Cannot archive category. There are items associated with this category.');
        } else {
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
                            alert('Failed to archive category.');
                        }
                    }
                });
            }
        }
    });
}

function hardDeleteCategory(categoryId) {
    categoryHasItems(categoryId, function(hasItems) {
        if (hasItems) {
            alert('Cannot delete category. There are items associated with this category.');
        } else {
            if (confirm('Are you sure you want to delete this category permanently?')) {
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
                            alert('Failed to delete category.');
                        }
                    }
                });
            }
        }
    });
}

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

function hardDeleteItem(itemId) {
    if (confirm('Are you sure you want to delete this item permanently?')) {
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

document.getElementById('item-image').addEventListener('change', function() {
    showImagePreview(this, 'add-item-image-preview');
});

document.getElementById('update-item-image').addEventListener('change', function() {
    showImagePreview(this, 'update-item-image-preview');
});

function showImagePreview(input, previewElementId) {
    const previewElement = document.getElementById(previewElementId);
    const file = input.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        previewElement.src = e.target.result;
        previewElement.style.display = 'block';
    };

    if (file) {
        reader.readAsDataURL(file);
    }
}

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

document.getElementById('update-category-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const categoryId = document.getElementById('update-category-id').value;
    const newCategoryName = document.getElementById('update-category-name').value;
    const newCategoryDescription = document.getElementById('update-category-description').value;

    $.ajax({
        type: "POST",
        url: 'Services/UpdateCategoryService.php',
        data: { categoryId, newCategoryName, newCategoryDescription },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert('Category updated successfully!');
                loadMenuLists();
                document.getElementById('updateCategoryModal').style.display = 'none';
            } else {
                alert('Failed to update category.');
            }
        }
    });
});

document.getElementById('update-item-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const itemId = document.getElementById('update-item-id').value;
    const newItemName = document.getElementById('update-item-name').value;
    const newItemDescription = document.getElementById('update-item-description').value;
    const newItemPrice = document.getElementById('update-item-price').value;
    const newItemCategory = document.getElementById('update-item-category').value;
    const newItemImage = document.getElementById('update-item-image').files[0];

    const formData = new FormData();
    formData.append('itemId', itemId);
    formData.append('newItemName', newItemName);
    formData.append('newItemDescription', newItemDescription);
    formData.append('newItemPrice', newItemPrice);
    formData.append('newItemCategory', newItemCategory);
    if (newItemImage) {
        formData.append('newItemImage', newItemImage);
    }

    $.ajax({
        type: "POST",
        url: 'Services/UpdateItemService.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert('Item updated successfully!');
                loadMenuLists();
                document.getElementById('updateItemModal').style.display = 'none';
            } else {
                alert('Failed to update item.');
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    handleTabNavigation();
    loadMenuLists();
});