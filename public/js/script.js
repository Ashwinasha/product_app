
document.addEventListener('DOMContentLoaded', function () {
    const addRowButton = document.getElementById('add-row');
    const tableBody = document.querySelector('.table tbody');
    
    addRowButton.addEventListener('click', function () {
        // Create a new row element
        const newRow = document.createElement('tr');
        
        // Define the new row content
        newRow.innerHTML = `
            <td>
                <input type="number" class="form-control no-border" name="price[]" step="0.01" required>
            </td>
            <td>
                <input type="number" class="form-control no-border" name="weight[]" step="0.01" required>
            </td>
            <td>
                <input type="number" class="form-control no-border" name="qty_of_box[]" required>
            </td>
        `;
        
        // Append the new row to the table body
        tableBody.appendChild(newRow);
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('mainImage');
    const mainImagePreview = document.getElementById('mainImagePreview');
    
    mainImage.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                mainImagePreview.src = e.target.result;
                mainImagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            mainImagePreview.style.display = 'none';
        }
    });

    const smallImages = document.querySelectorAll('input[name="small_images[]"]');
    const smallImagePreviews = [
        document.getElementById('smallImagePreview1'),
        document.getElementById('smallImagePreview2'),
        document.getElementById('smallImagePreview3')
    ];

    smallImages.forEach((input, index) => {
        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    smallImagePreviews[index].src = e.target.result;
                    smallImagePreviews[index].style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                smallImagePreviews[index].style.display = 'none';
            }
        });
    });
});



document.querySelectorAll('input[id^="smallImage"]').forEach(input => {
    input.addEventListener('change', function(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            // Adjust the image preview ID based on the input ID
            const fileInputId = fileInput.id;
            const imagePreviewId = fileInputId.replace('smallImage', 'smallImagePreview').replace('New', 'New');
            const imageElement = document.getElementById(imagePreviewId);

            if (imageElement) {
                imageElement.src = e.target.result;
                imageElement.style.display = 'block'; // Show the image
            }
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });
});


