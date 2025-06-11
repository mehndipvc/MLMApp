<?php include "header.php" ?>
<link href="https://unpkg.com/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

<style>
    .pagination a.active {
        background-color: #007bff;
        color: #fff;
    }
    .data-item {
        position: relative; /* Ensure positioning context for absolute child */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        /*height: 300px;*/
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden; /* Ensure images don't overflow */
        transition: transform 0.3s ease-in-out; /* Transition for hover effect */
    }
    
    .data-item:hover {
        transform: scale(1.05); /* Scale up on hover */
    }
    
    .data-item img {
        width: 100%; /* Make images fill the container */
        height: auto;
        object-fit: cover; /* Maintain aspect ratio */
    }
    
    .category-name {
        background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
        color: #fff;
        padding: 5px;
        width: 100%;
        text-align: center;
        position: absolute;
        top: 0;
        left: 0;
        box-sizing: border-box;
    }
.float {
    position: fixed;
    width: 169px;
    height: 60px;
    bottom: 40px;
    right: 40px;
    background-color: #7a000d;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    box-shadow: 2px 2px 3px #999;
    z-index: 99;
    text-decoration: none;
}

.my-float{
	margin-top:22px;
}
.share-button {
    position: absolute;
    top: 25px;
    right: 10px;
    background-color: rgba(0, 0, 0, 0.7);
    color: #fff;
    border: none;
    padding: 10px 14px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s, transform 0.3s;
}

.share-button:hover {
    background-color: rgba(0, 0, 0, 0.9);
    transform: scale(1.1);
}

.share-button i {
    margin: 0;
}
</style>

<div class="container my-2">
    <div id="data-container" class="row gy-3">
        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="float">
            <i class="fa fa-plus my-float"></i> Upload Picture
        </a>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Upload Image</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="uploadForm">
      <div class="modal-body">
        
          <!-- Gallery Category at the top -->
          <div class="mb-3">
            <label for="galleryCategory" class="form-label">Gallery Category</label>
            <select class="form-select" id="galleryCategory" name="cat_id" required>
              <option value="">Select Category</option>
                <?php
                    $fet_cat=$obj->fetch("SELECT * FROM gal_category");
                    
                    foreach($fet_cat as $val_cat){
                ?>
                <option value="<?= $val_cat['id'] ?>"><?= $val_cat['category'] ?></option>
                <?php } ?>
            </select>
          </div>
          <!-- File Upload below the category -->
          <div class="mb-3">
            <label for="fileUpload" class="form-label">Select File</label>
            <input type="file" class="form-control" id="fileUpload" name="image" required>
          </div>
          <div class="mb-3 errorMsg"></div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="uploadBtn">Upload</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php include "footer.php" ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('data-container');
        const xhr = new XMLHttpRequest();
        const apiUrl = 'https://app.pvcinterior.in/api/fetch-categories.php';

        xhr.open('GET', apiUrl, true);

        xhr.onload = function() {
            if (this.status === 200) {
                try {
                    const data = JSON.parse(this.responseText);
                

                    data.data.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'col-md-3 col-sm-6 col-6';
                        const encryptedCatId = btoa(item.cat_id);
                        div.innerHTML = `
                            <div class="data-item">
                                <a href="picture-details.php?id=${item.cat_id}">
                                    <img src="https://app.pvcinterior.in/api/assets/${item.image}" alt="${item.category}">
                                </a>
                                <div class="category-name">${item.category}</div>
                                <button class="share-button" onclick="shareImage('https://app.mehndiinterior.in/picture-category-details/${encryptedCatId}')">
                                    <i class="ri-share-line"></i>
                                </button>
                            </div>
                        `;
                        container.appendChild(div);
                    });
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            } else {
                console.error('Request failed. Status:', this.status);
            }
        };

        xhr.onerror = function() {
            console.error('Request error');
        };

        xhr.send();
    });
</script>
<script>
    $('#uploadForm').on("submit", function(e) {
        e.preventDefault();
        
        // Create a FormData object from the form
        var formData = new FormData(this);
        
        $.ajax({
            url: "upload-gallery.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                $("#uploadBtn").attr('disabled', 'disabled');
                $('#uploadBtn').html('Processing...');
            },
            success: function(response) {
                $('#uploadBtn').html('Upload'); // Reset button text after processing
                
                if(response.trim() === "200") {
                    $('.errorMsg').html('<p class="alert alert-success">Successfully uploaded</p>');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    $('.errorMsg').html('<p class="alert alert-danger">Error: ' + response + '</p>');
                    $("#uploadBtn").removeAttr('disabled');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#uploadBtn').html('Upload'); // Reset button text on error
                $('#errorMsg').html('<p class="alert alert-danger">An error occurred: ' + textStatus + '</p>');
            }
        });
    });
    
    
 function shareImage(imageUrl) {
    if (window.Android && typeof window.Android.shareContent === 'function') {
        window.Android.shareContent(
            "Check out this image!",
            "Here is an amazing image I found.",
            imageUrl // URL to share
       )
    } else {
        alert('Sharing not supported');
    }
}
</script>

