'use strict';

// Function to set up the confirmation modal (called when user clicks "delete" for an item)
function onDelete(text, itemId) {
    // Set the confirmation text
    document.getElementById("text-question").innerText = `You want to delete ${text}?`;
    
    // Get the "Yes" button
    const yesButton = document.getElementById("modal-delete-yes");
    if (!yesButton) {
        console.error("Yes button not found!");
        return;
    }

    yesButton.setAttribute("data-item-id", itemId);
    
    // Optional: Show the modal here (e.g., if using a library like Bootstrap)
    // const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    // modal.show();
}

// Function to handle the actual deletion (expand as needed)
function onDeleteYes() {
    const yesButton = document.getElementById("modal-delete-yes");
    let itemId = yesButton.getAttribute("data-item-id");
    console.log(`Deleting item with ID: ${itemId}`);
    
    let url = `/language/${itemId}/delete`;
    console.log(url);
    
    fetch(url, {
    method: 'DELETE',
    headers: {
        'Content-Type': 'application/json',
        // Add auth headers if required, e.g., 'Authorization': 'Bearer token'
    }
    })
    .then(response => response.json()) // Parse JSON
    .then(data => {
        if (data.success) {
            console.log(data.message); // Or show a success toast
            // Update UI, e.g., remove the language row from a table
            document.getElementById('language-' + itemId).remove();
            document.getElementById('modal-delete-no').click();
        } else {
            console.error(data.message); // Show error to user
        }
    })
    .catch(error => {
        console.error('Request failed:', error);
    });

    //location.reload(true);
    // Optional: Hide the modal or update UI after deletion
}

// Optional: Ensure DOM is loaded before using (if this script runs early)
document.addEventListener('DOMContentLoaded', function() {
    // Any initial setup here if needed
});
