<?php include "header.php" ?>
<link href="https://unpkg.com/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

<style>
    .pagination a.active {
        background-color: #007bff;
        color: #fff;
    }
    .data-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 300px;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
    }
    
    .data-item:hover {
        transform: scale(1.05);
    }
    
    .data-item img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    
    .category-name {
        background-color: rgba(0, 0, 0, 0.6);
        color: #fff;
        padding: 5px;
        width: 100%;
        text-align: center;
        position: absolute;
        top: 0;
        left: 0;
        box-sizing: border-box;
    }
    .sl-name {
        background-color: rgba(0, 0, 0, 0.6);
        color: #fff;
        padding: 5px;
        width: 100%;
        text-align: center;
        position: absolute;
        bottom: 0;
        left: 0;
        box-sizing: border-box;
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

<!-- Begin page -->

          
            <div class="container my-2">
                <div id="data-container" class="row gy-3"></div>
                <nav class="mt-3" aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination"></ul>
                </nav>
            </div>


<?php include "footer.php" ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
    let currentPage = 1;
    const itemsPerPage = 52;
    let totalPages = 1;
    const maxPageLinks = 5;
    let allData = [];

    document.addEventListener('DOMContentLoaded', function() {
    fetchData();
});

function getCatIdFromUrl() {
    const url = window.location.href;
    const urlObj = new URL(url);
    const id = urlObj.searchParams.get('id');
    return id;
}

function fetchData() {
    const xhr = new XMLHttpRequest();
    const catId = getCatIdFromUrl();

    xhr.open('GET', `https://app.pvcinterior.in/api/fetch-image-pagination.php?cat_id=${catId}&page=${currentPage}&item=${itemsPerPage}`, true);
    xhr.onload = function() {
        if (this.status === 200) {
            const response = JSON.parse(this.responseText);
            allData = response.data;
            totalPages = response.total_pages;

            displayData();
            generatePagination();
        } else {
            console.error('Failed to fetch data:', this.status);
        }
    };
    xhr.onerror = function() {
        console.error('Error fetching data.');
    };
    xhr.send();
}

function displayData() {
    const container = document.getElementById('data-container');
    container.innerHTML = '';

    allData.forEach(item => {
        const div = document.createElement('div');
        div.className = 'col-md-3';
        div.innerHTML = `
            <div class="data-item">
                <a data-fancybox="gallery" data-caption="${item.id}" href="https://admin.pvcinterior.in/api/assets/${item.image}">
                    <img src="https://admin.pvcinterior.in/api/assets/${item.image}" alt="${item.category}">
                </a>
                <div class="category-name">${item.category}</div>
                <div class="sl-name">${item.id}</div>
                <button class="share-button" onclick="shareImage('https://admin.pvcinterior.in/api/assets/${item.image}')">
                    <i class="ri-share-line"></i>
                </button>
            </div>
        `;
        container.appendChild(div);
    });

    $('[data-fancybox="gallery"]').fancybox({
        loop: true,
        buttons: [
            'slideShow',
            'fullScreen',
            'thumbs',
            'close'
        ]
    });

    if (allData.length === 0) {
        container.innerHTML = '<p>No images found for the selected category.</p>';
    }
}

function generatePagination() {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    if (currentPage > 1) {
        const firstLi = document.createElement('li');
        firstLi.className = 'page-item';
        const firstA = document.createElement('a');
        firstA.className = 'page-link';
        firstA.href = '#';
        firstA.innerText = 'First';
        firstA.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = 1;
            fetchData();
        });
        firstLi.appendChild(firstA);
        pagination.appendChild(firstLi);

        const prevLi = document.createElement('li');
        prevLi.className = 'page-item';
        const prevA = document.createElement('a');
        prevA.className = 'page-link';
        prevA.href = '#';
        prevA.innerText = 'Previous';
        prevA.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage--;
            fetchData();
        });
        prevLi.appendChild(prevA);
        pagination.appendChild(prevLi);
    }

    let startPage = Math.max(currentPage - Math.floor(maxPageLinks / 2), 1);
    let endPage = Math.min(startPage + maxPageLinks - 1, totalPages);

    if (endPage - startPage < maxPageLinks - 1) {
        startPage = Math.max(endPage - maxPageLinks + 1, 1);
    }

    for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = '#';
        a.innerText = i;
        a.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = i;
            fetchData();
        });
        li.appendChild(a);
        pagination.appendChild(li);
    }

    if (currentPage < totalPages) {
        const nextLi = document.createElement('li');
        nextLi.className = 'page-item';
        const nextA = document.createElement('a');
        nextA.className = 'page-link';
        nextA.href = '#';
        nextA.innerText = 'Next';
        nextA.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage++;
            fetchData();
        });
        nextLi.appendChild(nextA);
        pagination.appendChild(nextLi);

        const lastLi = document.createElement('li');
        lastLi.className = 'page-item';
        const lastA = document.createElement('a');
        lastA.className = 'page-link';
        lastA.href = '#';
        lastA.innerText = 'Last';
        lastA.addEventListener('click', function(e) {
            e.preventDefault();
            currentPage = totalPages;
            fetchData();
        });
        lastLi.appendChild(lastA);
        pagination.appendChild(lastLi);
    }
}

//  function shareImage(imageUrl) {
//     //alert(imageUrl);
     
//     if (navigator.share) {
//         navigator.share({
//             title: 'Check out this image!',
//             text: 'Here is an amazing image I found.',
//             url: imageUrl
//         })
//         .then(() => console.log('Image shared successfully!'))
//         .catch((error) => console.error('Error sharing the image:', error));
//     } else {
//         console.log('Web Share API is not supported in your browser.');
//     }
// }

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
