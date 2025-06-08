function startSlideshow(containerSelector, interval = 1000) {
    const slides = document.querySelectorAll(`${containerSelector} .slide`);
    let index = 0;
  
    if (slides.length <= 1) return;
  
    setInterval(() => {
      slides[index].classList.remove('active');
      index = (index + 1) % slides.length;
      slides[index].classList.add('active');
    }, interval);
  }
  
  document.addEventListener('DOMContentLoaded', () => {
    startSlideshow('.left-slideshow', 3000);
    startSlideshow('.right-slideshow', 3000);
  });
  