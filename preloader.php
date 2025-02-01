<style>
#preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      opacity: 1;
      transition: opacity 0.3s ease-in-out;
    }

    #preloader.fade-out {
      opacity: 0;
      pointer-events: none;
    }
</style>
<div id="preloader">
    <img src="img/haleeb.png" alt="">
</svg>
  </div>

<script>
    window.addEventListener('load', function() {
      var preloader = document.getElementById('preloader');
      preloader.classList.add('fade-out');
    });
  </script>