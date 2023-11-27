const carouselImages = document.querySelectorAll('.carousel img');
let currentIndex = 0;

function showImage(index) {
    carouselImages.forEach(image => {
        image.style.display = 'none';
    });
    carouselImages[index].style.display = 'block';
}

function nextImage() {
    currentIndex = (currentIndex + 1) % carouselImages.length;
    showImage(currentIndex);
}

// Auto slide every 5 seconds
setInterval(nextImage, 5000);

// Show the first image initially
showImage(currentIndex);
