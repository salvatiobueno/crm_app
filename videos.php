<?php
require 'includes/header.php';
require 'includes/db.php';
require 'includes/functions.php';

$socios = obtenerSocios($pdo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Galería de Videos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
  body {
    background-color: #000;
    color: #fff;
    margin: 0;
    padding: 20px;
    font-family: Arial, sans-serif;
  }

  h1 {
    text-align: center;
    margin-bottom: 30px;
  }

  .gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
  }

  .video-card {
    width: 300px;
    cursor: pointer;
    border: 2px solid #fff;
    border-radius: 10px;
    overflow: hidden;
    background-color: #111;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.2s;
  }

  .video-thumb {
    width: 100%;
    overflow: hidden;
  }

  .video-thumb video {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.4s ease;
  }

  .video-thumb:hover video {
    transform: scale(1.05);
  }

  .video-title {
    padding: 10px;
    text-align: center;
    font-weight: bold;
  }

  /* Modal */
  .modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.9);
    justify-content: center;
    align-items: center;
    padding: 20px;
  }

  .modal-content {
    position: relative;
    width: 90%;
    max-width: 800px;
    background-color: #111;
    padding: 20px;
    border-radius: 10px;
  }

  .modal-content video {
    width: 100%;
    height: auto;
    border: 2px solid #fff;
    border-radius: 10px;
    margin-bottom: 15px;
  }

  .close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    color: #fff;
    cursor: pointer;
  }

  .video-info h2 {
    margin: 10px 0 5px;
  }

  .video-info p {
    margin: 5px 0;
  }
</style>


  <script>
    document.addEventListener('contextmenu', event => event.preventDefault());

    function openModal(src, title, description, views) {
      const modal = document.getElementById('videoModal');
      const modalVideo = document.getElementById('modalVideo');
      const titleEl = document.getElementById('videoTitle');
      const descEl = document.getElementById('videoDescription');
      const viewsEl = document.getElementById('videoViews');

      modalVideo.src = src;
      titleEl.textContent = title;
      descEl.textContent = description;
      viewsEl.textContent = views + ' visualizaciones';

      modal.style.display = 'flex';
      modalVideo.play();
    }

    function closeModal() {
      const modal = document.getElementById('videoModal');
      const modalVideo = document.getElementById('modalVideo');
      modal.style.display = 'none';
      modalVideo.pause();
      modalVideo.currentTime = 0;
    }

    window.addEventListener('click', function(event) {
      const modal = document.getElementById('videoModal');
      if (event.target == modal) {
        closeModal();
      }
    });

    function setupVideoClicks() {
      const cards = document.querySelectorAll('.video-card');
      cards.forEach(card => {
        card.addEventListener('click', function() {
          const videoSrc = this.getAttribute('data-src');
          const title = this.getAttribute('data-title');
          const description = this.getAttribute('data-description');
          const views = this.getAttribute('data-views');
          openModal(videoSrc, title, description, views);
        });
      });
    }

    window.onload = setupVideoClicks;
  </script>
</head>
<body>

  <h1>Galería de Videos</h1>

  <div class="gallery">
    <!-- Tarjeta 1 -->
    <div class="video-card"
         data-src="video.mp4"
         data-title="Video 1"
         data-description="Este es el primer video de prueba."
         data-views="123">
      <div class="video-thumb">
        <video muted>
          <source src="video.mp4" type="video/mp4">
        </video>
      </div>
      <div class="video-title">Video 1</div>
    </div>

    <!-- Tarjeta 2 -->
    <div class="video-card"
         data-src="video.mp4"
         data-title="Video 2"
         data-description="Segundo video con más acción."
         data-views="456">
      <div class="video-thumb">
        <video muted>
          <source src="video.mp4" type="video/mp4">
        </video>
      </div>
      <div class="video-title">Video 2</div>
    </div>
  </div>

  <!-- Modal -->
  <div id="videoModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <video id="modalVideo" controls controlsList="nodownload" oncontextmenu="return false;">
        <source src="" type="video/mp4">
        Tu navegador no soporta la reproducción de video.
      </video>
      <div class="video-info">
        <h2 id="videoTitle"></h2>
        <p id="videoDescription"></p>
        <p id="videoViews"></p>
      </div>
    </div>
  </div>

</body>
</html>
