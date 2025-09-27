@extends('frontend.main_master')

@section('content')
@php
$alreadyUploaded = false;

if (Auth::check()) {
    // Cek apakah user sudah punya minimal 1 data di tabel game_uploads
    $alreadyUploaded = \App\Models\GameUpload::where('user_id', Auth::id())
        ->exists();
}
@endphp



{{-- Ensure CSRF token is available --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Include GSAP library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>

<div class="game-container">
    <!-- Header / Title -->
    <header>
        <style>
          html, body {
    padding: 0;
    margin: 0;
    height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #87CEEB 0%, #98FB98 50%, #90EE90 100%);
    overflow-x: hidden;
}

/* Game specific styles */
.game-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 100vh;
    padding: 20px;
    box-sizing: border-box;
}

header {
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
    z-index: 10;
}

header h1 {
    font-size: 2.5em;
    color: #2c5530;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    font-weight: 700;
}

header p {
    font-size: 1.2em;
    color: #4a6741;
    margin: 10px 0 0 0;
    font-weight: 300;
}

/* Tree SVG Container */
.tree-container {
    width: 100%;
    max-width: 500px;
    height: 500px;
    margin: 20px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle at center, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 20px;
    position: relative;
    overflow: visible;
}

.tree-container svg {
    width: 100%;
    height: 100%;
    max-width: 400px;
    max-height: 450px;
    display: block;
    filter: drop-shadow(0 10px 20px rgba(0,0,0,0.1));
    opacity: 1;
    transition: opacity 0.3s ease;
}

.tree-container svg.loading {
    opacity: 0.5;
}

/* Ground effect */
.tree-container::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    height: 20px;
    background: linear-gradient(to bottom, transparent, rgba(139, 69, 19, 0.2));
    border-radius: 50%;
    z-index: -1;
}

#menu {
    margin: 20px 0;
    text-align: center;
    background: rgba(255, 255, 255, 0.9);
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

#menu button {
    background: linear-gradient(45deg, #4CAF50, #45a049);
    color: white;
    border: none;
    padding: 15px 30px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    text-transform: uppercase;
    letter-spacing: 1px;
}

#menu button:hover {
    background: linear-gradient(45deg, #45a049, #3d8b40);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
}

#menu button:active {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(76, 175, 80, 0.3);
}

#menu button:disabled {
    background: #cccccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

#menu label {
    display: flex;
    align-items: center;
    color: #2c5530;
    font-weight: 500;
    font-size: 16px;
    cursor: pointer;
    transition: color 0.3s ease;
}

#menu label:hover {
    color: #1a3a1e;
}

#menu input[type="checkbox"] {
    margin-right: 10px;
    transform: scale(1.3);
    accent-color: #4CAF50;
    cursor: pointer;
}

.play-again {
    color: #2196F3;
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    border: 2px solid #2196F3;
    background: rgba(33, 150, 243, 0.1);
    border-radius: 25px;
    text-decoration: none;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.play-again:hover {
    background: #2196F3;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(33, 150, 243, 0.3);
}

.btn-submit {
    background: linear-gradient(45deg, #2196F3, #1976D2);
    color: white;
    border: none;
    padding: 15px 30px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 20px;
}

.btn-submit:hover {
    background: linear-gradient(45deg, #1976D2, #1565C0);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
}

.btn-submit:active {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(33, 150, 243, 0.3);
}

.btn-submit:disabled {
    background: #cccccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}



/* Responsive design */
@media screen and (max-width: 768px) {
    .game-container {
        padding: 15px;
    }
    
    header h1 {
        font-size: 2em;
    }
    
    header p {
        font-size: 1em;
    }
    
    .tree-container {
        max-width: 350px;
        height: 400px;
    }
    
    #menu {
        padding: 20px;
        margin: 15px 0;
    }
    
    #menu button, .btn-submit {
        padding: 12px 24px;
        font-size: 14px;
    }
}

@media screen and (max-width: 480px) {
    .game-container {
        padding: 10px;
    }
    
    header h1 {
        font-size: 1.8em;
    }
    
    .tree-container {
        max-width: 300px;
        height: 350px;
    }
    
    #menu {
        padding: 15px;
        gap: 10px;
    }
    
    #menu button, .btn-submit {
        padding: 10px 20px;
        font-size: 13px;
    }
    
    #menu label {
        font-size: 14px;
    }
}

@media screen and (max-width: 360px) {
    .tree-container {
        max-width: 280px;
        height: 320px;
    }
    
    #menu {
        flex-direction: column;
        align-items: stretch;
    }
    
    #menu label {
        justify-content: center;
        margin: 5px 0;
    }
}

/* Animation enhancements */
.tree-container svg * {
    transform-box: fill-box;
}

/* Loading animation */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

.game-container.loading .tree-container::after {
    content: 'Memuat...';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #4CAF50;
    font-weight: bold;
    font-size: 18px;
    animation: pulse 1.5s infinite;
}



/* Seed styling */
#seed {
  opacity: 1;
}

.seed-state #shadow {
    opacity: 0.2; /* Sedikit bayangan untuk tanah */
}

.seed-state #seed {
    opacity: 1; /* Biji terlihat */
}

.seed-state #tree,
.seed-state #stem,
.seed-state #leaf-top,
.seed-state #leaf-rb,
.seed-state #leaf-rm,
.seed-state #leaf-lb,
.seed-state #leaf-lm {
    opacity: 0; /* Bagian pohon disembunyikan */
}



        </style>
        <h1>🌳 Tree Growing Game 🌳</h1>
        <p>Watch the magical tree grow and flourish!</p>
    </header>

    @if(!Auth::check())
        <div class="login-prompt">
            <p>🌱 Silakan masuk untuk bermain dan menyimpan hasil permainan Anda!</p>
        </div>
    @endif

    <!-- Tree Animation SVG -->
    <div class="tree-container {{ (!Auth::check() || !$alreadyUploaded) ? 'seed-state' : '' }}">

        <svg id="animation" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 302.7 436.37">
            {{-- Semua konten SVG sama --}}
            <defs>
              <linearGradient id="Dégradé_sans_nom_18" data-name="Dégradé sans nom 18" x1="156.31" y1="365.15" x2="246.31" y2="431.81" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#39505d" />
                <stop offset="1" stop-color="#39505d" stop-opacity="0" />
              </linearGradient>
              <linearGradient id="Dégradé_sans_nom_4" data-name="Dégradé sans nom 4" x1="200.34" y1="253.69" x2="176.67" y2="221.09" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#929669" />
                <stop offset="0.23" stop-color="#929669" />
                <stop offset="1" stop-color="#fdfcf1" />
              </linearGradient>
              <linearGradient id="Dégradé_sans_nom_2" data-name="Dégradé sans nom 2" x1="303.2" y1="168.65" x2="213.62" y2="249.02" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#45aa3a" />
                <stop offset="1" stop-color="#3d9439" />
              </linearGradient>
              <linearGradient id="Dégradé_sans_nom_3" data-name="Dégradé sans nom 3" x1="236.83" y1="175.48" x2="254.62" y2="212.29" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#41a83b" />
                <stop offset="1" stop-color="#5ebc44" />
              </linearGradient>
              <linearGradient id="Dégradé_sans_nom_4-2" x1="196.6" y1="195.74" x2="177" y2="178.38" xlink:href="#Dégradé_sans_nom_4" />
              <linearGradient id="Dégradé_sans_nom_3-2" x1="296.11" y1="44.64" x2="176.48" y2="155.68" xlink:href="#Dégradé_sans_nom_3" />
              <linearGradient id="Dégradé_sans_nom_2-2" x1="274.3" y1="150.3" x2="231.97" y2="99.99" xlink:href="#Dégradé_sans_nom_2" />
              <linearGradient id="Dégradé_sans_nom_4-3" x1="-19.56" y1="223.16" x2="218.1" y2="279.92" xlink:href="#Dégradé_sans_nom_4" />
              <linearGradient id="Dégradé_sans_nom_2-3" x1="16.11" y1="204.08" x2="92.18" y2="276.48" xlink:href="#Dégradé_sans_nom_2" />
              <linearGradient id="Dégradé_sans_nom_2-4" x1="106.7" y1="255.03" x2="106.7" y2="255.03" xlink:href="#Dégradé_sans_nom_2" />
              <linearGradient id="Dégradé_sans_nom_3-3" x1="63.36" y1="209.36" x2="54.16" y2="240.65" xlink:href="#Dégradé_sans_nom_3" />
              <linearGradient id="Dégradé_sans_nom_4-4" x1="75.32" y1="182.31" x2="144.32" y2="160.33" xlink:href="#Dégradé_sans_nom_4" />
              <linearGradient id="Dégradé_sans_nom_2-5" x1="19.89" y1="76.27" x2="141.37" y2="193.45" xlink:href="#Dégradé_sans_nom_2" />
              <linearGradient id="Dégradé_sans_nom_3-4" x1="38.58" y1="178.83" x2="83.36" y2="134.66" xlink:href="#Dégradé_sans_nom_3" />
              <linearGradient id="Dégradé_sans_nom_39" data-name="Dégradé sans nom 39" x1="148.36" y1="248.02" x2="163.23" y2="248.02" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#cbccb1" />
                <stop offset="0.69" stop-color="#a8ab84" />
                <stop offset="1" stop-color="#abae89" />
              </linearGradient>
              <linearGradient id="Dégradé_sans_nom_2-6" x1="147.41" y1="4.1" x2="181.15" y2="164.83" xlink:href="#Dégradé_sans_nom_2" />
              <linearGradient id="Dégradé_sans_nom_3-5" x1="98.37" y1="94.42" x2="168.31" y2="80.31" xlink:href="#Dégradé_sans_nom_3" />
              <!-- Seed gradient -->
              <linearGradient id="seed_gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#8B4513" />
                <stop offset="50%" stop-color="#A0522D" />
                <stop offset="100%" stop-color="#654321" />
              </linearGradient>
            </defs>

            <title>mongo-tree</title>

            <!-- Seed element - added at the beginning -->
            <g id="seed">
              <ellipse cx="155" cy="380" rx="8" ry="12" fill="url(#seed_gradient)" />
              <ellipse cx="155" cy="378" rx="5" ry="8" fill="#6B3410" opacity="0.7" />
              <circle cx="157" cy="376" r="2" fill="#8B7355" opacity="0.6" />
            </g>

            <g id="shadow">
              <path d="M172,366c1,6,93.49,68.65,93.49,68.65l-19.53,1s-61.8-40.89-84.32-54.19-19.06-14.2-19.07-14.21c-.46-.45,2-4.64,11.81-4.64S171.88,363.56,172,366Z" transform="translate(-1.14 -2.3)" opacity="0.1" fill="url(#Dégradé_sans_nom_18)" />
            </g>

            <g id="tree">
              <g id="leaf-rb">
                <g>
                  <path d="M226.46,217.24S207.89,223.52,201,229c-2.12,1.69.56,1.74.52,3.5,0,0,30.61,20,66.11-3.15,25.12-18.4,27.8-37.3,30.61-40.42a45.85,45.85,0,0,1,5.32-6.52Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_2)" />
                  <path d="M296.79,182.08c-4.39-2.39-28-14.22-60.31-2s-38.85,46.27-38.85,46.27c3.37,3.66,9.48-1.84,18.58-5,8.63-3,19.24-7.3,30-12.34,5.66-2.66,54.85-23.65,57.66-26.82C301.3,183,300.29,183.34,296.79,182.08Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_3)" />
                </g>
                <path d="M214.36,221.93c-8.15,2.8-14.29,4.4-16.71,4.41-8.73,8.22-47.32,28-47.32,28l.33,3.69s42.57-24.81,47.09-25.68a8.57,8.57,0,0,1,4,.26l-.21-.13C201.6,228.71,208,224.83,214.36,221.93Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_4)" />
              </g>
              <g id="leaf-rm">
                <g>
                  <path d="M278.57,52c-5.14,3.07-32.38,1.65-65.06,31.82-42.24,43.41-22.55,91.82-22.55,91.82,10.05,8.39,28.23-30.77,28.23-30.77l70-98.55A65.5,65.5,0,0,1,278.57,52Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_3-2)" />
                  <path d="M287.76,55.87c-.8-5.26-.08-6.58,1.86-9.89-5.21,3.07-48.13,66.28-53.41,73.48a463.05,463.05,0,0,0-28,43c-2.27,4-8.66,10.5-10.19,13.58-2.21,4.45.88,4.89.52,6.76,0,0,49.56.17,75.53-41.78S289.91,62.69,287.76,55.87Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_2-2)" />
                </g>
                <path d="M209.28,160.51c-5.8,8.06-13,16-18.34,15.1l-.12-.3c-7.31,14.08-39.23,40.24-39.23,40.24l2.08,2.47s30.9-29.42,45-35.26h-.15C199.16,179.4,203.11,171.2,209.28,160.51Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_4-2)" />
              </g>
              <g id="leaf-lb">
                <polygon points="106.7 255.03 106.7 255.03 106.7 255.03 106.7 255.03" fill="url(#Dégradé_sans_nom_2-3)" />
                <g>
                  <path d="M100,250,1.44,217.33a45.85,45.85,0,0,1,5.93,6c3.09,2.83,7.59,21.39,34.37,37.28,37.57,19.65,66.11-3.25,66.11-3.25A7.91,7.91,0,0,0,100,250Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_2-4)" />
                  <path d="M68,208.52c-33.34-9-55.7,5-59.83,7.83-3.37,1.59-4.4,1.37-7,.73,3.1,2.88,54.07,19.08,60,21.12C101,252,104,253,111.12,250.82,111.12,250.82,101.32,217.54,68,208.52Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_3-3)" />
                </g>
                <path d="M151.59,271.16s-26.7-11.72-40.52-20.5l.05.17A63.85,63.85,0,0,1,93,249c6.56,2.28,14.39,4.57,14.84,8.33h0l-.2.15a8.57,8.57,0,0,1,3.94-.64c4.58.43,40,18,40,18Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_4-3)" />
              </g>
              <g id="leaf-lm">
                <g>
                  <path d="M100.8,117C68.12,86.85,40.88,88.27,35.74,85.2a65.5,65.5,0,0,1-10.6-5.68l70,98.55S108.58,201.6,118,210c3.14,2.8,2.73-.7,5.36-1.16C123.36,208.84,143,160.43,100.8,117Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_2-5)" />
                  <path d="M78.1,152.7c-5.28-7.21-48.21-70.41-53.41-73.48,1.94,3.32,2.66,4.63,1.86,9.89-2.15,6.81-12.26,43.16,13.71,85.11S115.79,216,115.79,216c-.38-2-.31-3.08-2.79-8C106.73,195.59,92.83,172.8,78.1,152.7Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_3-4)" />
                </g>
                <path d="M124.21,214.16a12.25,12.25,0,0,1-.73-5.65l-.13.33c-5.34.92-12.54-7-18.34-15.1,6.17,10.68,10.11,18.87,10.77,22.24,12.74,9.65,33.34,37.83,33.34,37.83l5.08-1.47S126.67,220.25,124.21,214.16Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_4-4)" />
              </g>
              <g id="main">
                <g id="leaf-top">
                  <path d="M190.25,76.57c-9.85-43.37-33.1-57.63-35.6-63.08a65.5,65.5,0,0,1-5.52-10.68L151,123.66s-3.84,36.9,5.84,41.35C156.83,165,200.48,136.27,190.25,76.57Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_2-6)" />
                  <path d="M151.33,93.11c.06-8.93.15-85.33-2.4-90.81-.28,3.83-.43,5.32-4.07,9.21-5.63,4.4-34.55,28.63-36.91,77.91s38.59,77.21,38.59,77.21C151,165,151,147,151.33,93.11Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_3-5)" />
                </g>
                <path id="stem" d="M172.18,366.33l0-.12a1.74,1.74,0,0,0-.23-.59C157.31,327.94,153,183,154.53,169.88a9.89,9.89,0,0,1,2.16-4.95A111.2,111.2,0,0,1,151,139s-3,21-4.64,27.5c5.39,21.3,2.7,91.54,1.07,142.46-.94,29.43-3.93,37.31-5.62,57.36h.12a1.48,1.48,0,0,0,0,.16c0,2.57,6.78,4.66,15.14,4.66s15.14-2.09,15.14-4.66a1.48,1.48,0,0,0,0-.16Z" transform="translate(-1.14 -2.3)" fill="url(#Dégradé_sans_nom_39)" />
              </g>
            </g>
        </svg>
    </div>

    <!-- Game Controls -->
    <div id="menu">
        <label>
            <input type="checkbox" id="leaves" checked />
            <span>Dengan Daun</span>
        </label>

      @auth
        <button type="button" onclick="playAgainAndSave()">
          Main Lagi
        </button>
      @endauth        
    </div>

@if(Auth::check())
    <form id="uploadForm" action="{{ route('game.upload') }}" method="POST">
        @csrf

        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <input type="hidden" name="replay" value="0"> {{-- default bukan replay --}}

        {{-- Tombol ini boleh disembunyikan kalau mau; tapi kalau ditampilkan,
             jangan di-disable saat sudah pernah upload, karena sekarang replay juga upload --}}
        <button type="button" onclick="saveAndStartGame()" id="btnSave" class="btn-submit">
            Simpan Hasil Main
        </button>
    </form>
    
@else
    <button type="button" class="btn-submit" disabled>
        Masuk untuk Bermain
    </button>
@endif

        <!-- Reward Modal -->
    <div id="rewardModal" style="display:none; position:fixed; top:0; left:0; 
        width:100%; height:100%; background:rgba(0,0,0,0.5); 
        display:flex; justify-content:center; align-items:center; z-index:9999;">
        <div style="background:#fff; padding:30px; border-radius:15px; text-align:center; max-width:400px;">
            <h2>🎉 Selamat!</h2>
            <p id="rewardText">Anda mendapatkan reward!</p>
            <button onclick="document.getElementById('rewardModal').style.display='none'" 
                style="margin-top:15px; padding:10px 20px; border:none; background:#4CAF50; color:white; border-radius:10px; cursor:pointer;">
                Tutup
            </button>
        </div>
    </div>





</div>

{{-- Tambahin di atas sebelum penutup </body> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){
    const btnSave = document.getElementById("btnSave");
    if(btnSave){
        btnSave.addEventListener("click", function(){
            btnSave.disabled = true;
            btnSave.innerText = "Menyimpan...";

            fetch("{{ route('game.reward') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    
                })
            })
            .then(res => res.json())
              .then(data => {
                  if (data.success) {
                      Swal.fire({
                          title: "🎉 Selamat!",
                          html: `Anda mendapatkan <b>${data.poin_didapat} poin</b> 
                                dan <b>voucher Rp ${new Intl.NumberFormat('id-ID').format(data.voucher_nominal)}</b>`,
                          icon: "success",
                          confirmButtonText: "OK"
                      });
                  } else {
                      Swal.fire("Gagal!", data.message, "error");
                  }
              })

            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan.");
                btnSave.disabled = false;
                btnSave.innerText = "Simpan Hasil Main";
            });
        });
    }
});
</script>

<script>
function playAgainAndSave() {
  console.log('Main Lagi + Save');

  // Animasi mulai dari biji
  setupSeedState();
  setTimeout(() => animateGrowth(), 100);

  // Upload replay
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const form = document.getElementById('uploadForm');
  const uploadUrl = form ? form.action : "{{ route('game.upload') }}";

  const data = new FormData();
  data.append('_token', token);
  data.append('replay', '1');

  fetch(uploadUrl, {
    method: 'POST',
    body: data,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': token
    }
  })
  .then(res => res.json())
  .then(json => {
    console.log('Replay upload response:', json);

    if (!json.success) {
      // Limit upload harian / error lain
      if (window.Swal) Swal.fire("Gagal", json.message || "Gagal menyimpan replay.", "warning");
      else alert(json.message || "Gagal menyimpan replay.");
      return;
    }

    // Upload sukses → minta reward
    return fetch("{{ route('game.reward') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": token
      },
      body: JSON.stringify({})
    })
    .then(r => r.json())
    .then(reward => {
      console.log('Reward response:', reward);
      if (reward.success) {
        window.alreadyUploaded = true;
        if (window.Swal) {
          Swal.fire({
            title: "🎉 Selamat!",
            html: `Anda mendapatkan <b>${reward.poin_didapat} poin</b> 
                   dan <b>voucher Rp ${new Intl.NumberFormat('id-ID').format(reward.voucher_nominal)}</b>
                   `,
            icon: "success",
            confirmButtonText: "OK"
          });
        } else {
          alert(`Poin: ${reward.poin_didapat}, Voucher: Rp ${reward.voucher_nominal}`);
        }
      } else {
        // Limit reward harian / error
        if (window.Swal) Swal.fire("Limit Harian", reward.message || "Batas reward tercapai.", "info");
        else alert(reward.message || "Batas reward tercapai.");
      }
    });
  })
  .catch(err => {
    console.error(err);
    if (window.Swal) Swal.fire("Error", "Terjadi kesalahan saat menyimpan replay / mengambil reward.", "error");
    else alert("Terjadi kesalahan saat menyimpan replay / mengambil reward.");
  });
}
</script>



{{-- JS Initialization --}}
<script>
    window.alreadyUploaded = @json($alreadyUploaded);

    document.addEventListener("DOMContentLoaded", () => {
        init(window.alreadyUploaded);
    });
</script>

<script>
/* ===========================
   TREE GROWTH ANIMATION FIX
=========================== */

let currentAnimation = null;
let isAnimating = false;

/* ===========================
   RESET ALL ELEMENTS
=========================== */
function resetAllElements() {
  // Kill all existing animations
  TweenMax.killAll(false, true, false);
  if (currentAnimation) {
    currentAnimation.kill();
    currentAnimation = null;
  }
  
  // Clear all properties and reset to initial state
  const elements = [
    "#tree", "#shadow", "#stem", "#leaf-top", "#seed",
    "#leaf-rb", "#leaf-rm", "#leaf-lb", "#leaf-lm",
    "#leaf-rb g", "#leaf-rm g", "#leaf-lb g", "#leaf-lm g", "#leaf-top g"
  ];
  
  elements.forEach(selector => {
    TweenMax.set(selector, { clearProps: "all" });
  });
}

/* ===========================
   SETUP SEED STATE
=========================== */
function setupSeedState() {
  console.log('Setting up seed state');
  
  // Remove any CSS state classes
  const treeContainer = document.querySelector('.tree-container');
  treeContainer.classList.remove('seed-state');
  
  // Reset all elements first
  resetAllElements();
  
  // Hide all tree parts completely
  TweenMax.set("#shadow", { 
    autoAlpha: 0, 
    scale: 0, 
    transformOrigin: "center bottom" 
  });
  
  TweenMax.set("#tree", { 
    autoAlpha: 0, 
    scale: 0, 
    transformOrigin: "center bottom" 
  });
  
  TweenMax.set("#stem", { 
    autoAlpha: 0, 
    scaleY: 0, 
    transformOrigin: "center bottom" 
  });
  
  TweenMax.set("#leaf-rb", { 
    autoAlpha: 0, 
    scale: 0, 
    rotation: -60, 
    transformOrigin: "center center" 
  });
  
  TweenMax.set("#leaf-rm", { 
    autoAlpha: 0, 
    scale: 0, 
    rotation: -50, 
    transformOrigin: "center center" 
  });
  
  TweenMax.set("#leaf-lb", { 
    autoAlpha: 0, 
    scale: 0, 
    rotation: 60, 
    transformOrigin: "center center" 
  });
  
  TweenMax.set("#leaf-lm", { 
    autoAlpha: 0, 
    scale: 0, 
    rotation: 40, 
    transformOrigin: "center center" 
  });
  
  TweenMax.set("#leaf-top", { 
    autoAlpha: 0, 
    scale: 0, 
    transformOrigin: "center bottom" 
  });

  // Hide leaf detail groups
  TweenMax.set("#leaf-rb g, #leaf-rm g, #leaf-lb g, #leaf-lm g, #leaf-top g", {
    autoAlpha: 0,
    scale: 0,
    transformOrigin: "center center"
  });

  // Show only seed
  TweenMax.set("#seed", { 
    autoAlpha: 1, 
    scale: 1, 
    opacity: 1 
  });
  
  // Add seed state class back
  treeContainer.classList.add('seed-state');
}

/* ===========================
   SETUP FULL TREE STATE
=========================== */
function setupFullTreeState() {
  console.log('Setting up full tree state');
  
  // Remove CSS state classes
  const treeContainer = document.querySelector('.tree-container');
  treeContainer.classList.remove('seed-state');
  
  // Reset all elements first
  resetAllElements();
  
  // Hide seed completely
  TweenMax.set("#seed", { 
    autoAlpha: 0, 
    scale: 0, 
    opacity: 0 
  });
  
  // Show all tree parts in full grown state
  TweenMax.set("#shadow", { 
    autoAlpha: 1, 
    scale: 1, 
    opacity: 0.3, 
    transformOrigin: "center bottom" 
  });
  
  TweenMax.set("#tree", { 
    autoAlpha: 1, 
    scale: 1, 
    transformOrigin: "center bottom" 
  });
  
  TweenMax.set("#stem", { 
    autoAlpha: 1, 
    scaleY: 1, 
    transformOrigin: "center bottom" 
  });
  
  TweenMax.set("#leaf-top, #leaf-rb, #leaf-rm, #leaf-lb, #leaf-lm", {
    autoAlpha: 1,
    scale: 1,
    rotation: 0,
    transformOrigin: "center center"
  });
  
  TweenMax.set("#leaf-top g, #leaf-rb g, #leaf-rm g, #leaf-lb g, #leaf-lm g", { 
    autoAlpha: 1, 
    scale: 1,
    transformOrigin: "center center"
  });

  // Start gentle swaying
  startSwaying();
}

/* ===========================
   START SWAYING ANIMATION
=========================== */
function startSwaying() {
  TweenMax.to("#leaf-top", 2, { 
    rotation: "3_short", 
    yoyo: true, 
    repeat: -1, 
    ease: Power2.easeInOut 
  });
  
  TweenMax.to("#leaf-rb", 2.2, { 
    rotation: "-2_short", 
    yoyo: true, 
    repeat: -1, 
    ease: Power2.easeInOut 
  });
  
  TweenMax.to("#leaf-rm", 2.4, { 
    rotation: "2_short", 
    yoyo: true, 
    repeat: -1, 
    ease: Power2.easeInOut 
  });
  
  TweenMax.to("#leaf-lb", 2.1, { 
    rotation: "2_short", 
    yoyo: true, 
    repeat: -1, 
    ease: Power2.easeInOut 
  });
  
  TweenMax.to("#leaf-lm", 2.3, { 
    rotation: "-1_short", 
    yoyo: true, 
    repeat: -1, 
    ease: Power2.easeInOut 
  });
}

/* ===========================
   ANIMATE TREE GROWTH
=========================== */
function animateGrowth() {
  if (isAnimating) return;
  
  console.log('Starting growth animation');
  isAnimating = true;

  // Remove CSS state classes
  const treeContainer = document.querySelector('.tree-container');
  treeContainer.classList.remove('seed-state');

  const showLeaves = document.getElementById("leaves").checked;

  currentAnimation = new TimelineMax({
    onComplete: function () {
      console.log('Animation completed');
      isAnimating = false;
      
      // Show Play Again button after animation completes
      const playAgainBtn = document.querySelector('.play-again');
      if (playAgainBtn) {
        playAgainBtn.style.display = 'inline-flex';
      }
      
      // Start swaying if leaves are enabled
      if (showLeaves) {
        startSwaying();
      }
    }
  });

  // Phase 0: Hide seed
  currentAnimation.to("#seed", 0.5, { 
    autoAlpha: 0, 
    scale: 0, 
    ease: Power2.easeOut 
  }, 0);

  // Phase 1: Show shadow and tree container, then grow stem
  currentAnimation
    .set("#shadow, #tree", { autoAlpha: 1 }, 0.5)
    .to("#shadow", 1, { 
      scale: 1, 
      opacity: 0.3, 
      ease: Power2.easeOut 
    }, 0.5)
    .to("#tree", 0.1, { 
      scale: 1, 
      ease: Power2.easeOut 
    }, 0.5)
    .set("#stem", { autoAlpha: 1 }, 0.7)
    .to("#stem", 2, { 
      scaleY: 1, 
      ease: Power2.easeOut 
    }, 0.7);

  if (showLeaves) {
    // Phase 2: Grow main leaves
    currentAnimation
      .set("#leaf-top, #leaf-rb, #leaf-rm, #leaf-lb, #leaf-lm", { autoAlpha: 1 }, 2)
      .to("#leaf-top", 1.5, { 
        scale: 1, 
        ease: Back.easeOut.config(1.2) 
      }, 2)
      .to("#leaf-rb", 1, { 
        scale: 1, 
        rotation: 0, 
        ease: Back.easeOut.config(1.2) 
      }, 2.5)
      .to("#leaf-rm", 1, { 
        scale: 1, 
        rotation: 0, 
        ease: Back.easeOut.config(1.2) 
      }, 2.7)
      .to("#leaf-lb", 1, { 
        scale: 1, 
        rotation: 0, 
        ease: Back.easeOut.config(1.2) 
      }, 2.9)
      .to("#leaf-lm", 1, { 
        scale: 1, 
        rotation: 0, 
        ease: Back.easeOut.config(1.2) 
      }, 3.1);

    // Phase 3: Show leaf details
    currentAnimation
      .set("#leaf-top g, #leaf-rb g, #leaf-rm g, #leaf-lb g, #leaf-lm g", { autoAlpha: 1 }, 3.5)
      .to("#leaf-top g", 0.8, { 
        scale: 1, 
        ease: Back.easeOut.config(1.1) 
      }, 3.5)
      .to("#leaf-rb g", 0.8, { 
        scale: 1, 
        ease: Back.easeOut.config(1.1) 
      }, 3.7)
      .to("#leaf-rm g", 0.8, { 
        scale: 1, 
        ease: Back.easeOut.config(1.1) 
      }, 3.9)
      .to("#leaf-lb g", 0.8, { 
        scale: 1, 
        ease: Back.easeOut.config(1.1) 
      }, 4.1)
      .to("#leaf-lm g", 0.8, { 
        scale: 1, 
        ease: Back.easeOut.config(1.1) 
      }, 4.3);
  }
}

/* ===========================
   MAIN CONTROL FUNCTIONS
=========================== */
function startGrowth(alreadyUploaded = false) {
  console.log('Starting growth, alreadyUploaded:', alreadyUploaded);
  
  if (!alreadyUploaded) {
    // Start from seed and animate growth
    setupSeedState();
    setTimeout(() => {
      animateGrowth();
    }, 100); // Small delay to ensure seed state is set
  } else {
    // Show fully grown tree immediately
    setupFullTreeState();
  }
}

function playAgain() {
  console.log('Play again clicked');
  
  // Reset to seed state
  setupSeedState();
  
  // Hide Play Again button if user hasn't uploaded
  const playAgainBtn = document.querySelector('.play-again');
  if (playAgainBtn && !window.alreadyUploaded) {
    playAgainBtn.style.display = 'none';
  }
  
  isAnimating = false;
}

function saveAndStartGame() {
  console.log('Save and start game clicked');
  
  // Disable button immediately
  const submitBtn = document.querySelector('.btn-submit');
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.textContent = 'Menyimpan...';
  }
  
  // Start the tree growth animation immediately
  console.log('Starting animation...');
  setupSeedState();
  setTimeout(() => {
    animateGrowth();
  }, 100);
  
  // Submit the form via AJAX
  const form = document.getElementById('uploadForm');
  const formData = new FormData(form);
  
  fetch(form.action, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => response.json())
  .then(data => {
    console.log('Server response:', data);
    if (data.success) {
      // Update button state
      if (submitBtn) {
        submitBtn.textContent = 'Sudah Upload';
        submitBtn.disabled = true;
      }
      
      // Update global state
      window.alreadyUploaded = true;
      
      console.log('Game result saved successfully!');
    } else {
      // Handle error
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Simpan Hasil Main';
      }
      alert('Terjadi kesalahan saat menyimpan. Silakan coba lagi.');
      
      // Reset to seed state if save failed
      setupSeedState();
    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Simpan Hasil Main';
    }
    alert('Terjadi kesalahan saat menyimpan. Silakan coba lagi.');
    
    // Reset to seed state if save failed
    setupSeedState();
  });
}

/* ===========================
   INITIALIZATION
=========================== */
function init(alreadyUploaded = false) {
  console.log('Initializing with alreadyUploaded:', alreadyUploaded);
  
  if (alreadyUploaded) {
    setupFullTreeState();
    
    // Show "Lihat Animasi" button for uploaded users
    const animationBtn = document.querySelector('button[onclick="startGrowth(true)"]');
    if (animationBtn) {
      animationBtn.style.display = 'block';
    }
  } else {
    setupSeedState();
  }

  // Update submit button state
  const submitBtn = document.querySelector(".btn-submit");
  if (submitBtn) {
    submitBtn.disabled = alreadyUploaded;
    submitBtn.textContent = alreadyUploaded ? "Sudah Upload" : "Simpan Hasil Main";
  }
}

/* ===========================
   DOM READY HANDLER
=========================== */
document.addEventListener("DOMContentLoaded", () => {
  console.log('DOM loaded, window.alreadyUploaded:', window.alreadyUploaded);
  
  // Wait for GSAP to be ready
  setTimeout(() => {
    if (window.alreadyUploaded === true || window.alreadyUploaded === "true") {
      setupFullTreeState();
    } else {
      setupSeedState();
    }
  }, 100);
});
</script>
@endsection