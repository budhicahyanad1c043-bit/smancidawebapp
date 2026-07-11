<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Construction</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #1a1a1a;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            overflow: hidden;
            color: #fff;
        }

        /* Garis Konstruksi Kuning Hitam di Atas & Bawah */
        .hazard-bar {
            width: 100%;
            height: 15px;
            background: repeating-linear-gradient(
                -45deg,
                #ffcc00,
                #ffcc00 10px,
                #1a1a1a 10px,
                #1a1a1a 20px
            );
        }

        /* Area Utama Crane */
        .construction-zone {
            position: relative;
            width: 100%;
            height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Struktur Utama Overhead Crane */
        .crane-bridge {
            position: absolute;
            top: 40px;
            left: 0;
            width: 100%;
            height: 20px;
            background: #ffcc00;
            border-bottom: 4px solid #ccaa00;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }

        /* Batang Baja Struktur Gantry */
        .crane-bridge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                90deg,
                transparent,
                transparent 40px,
                #ccaa00 40px,
                #ccaa00 45px
            );
        }

        /* Trolley / Derek yang bergeser ke kanan dan kiri */
        .trolley {
            position: absolute;
            top: 15px;
            left: 10%;
            width: 80px;
            height: 30px;
            background: #333;
            border: 2px solid #ffcc00;
            border-radius: 4px;
            animation: moveTrolley 8s ease-in-out infinite alternate;
        }

        /* Kabel Baja */
        .cable {
            position: absolute;
            top: 28px;
            left: 50%;
            width: 2px;
            height: 180px;
            background: #888;
            transform: translateX(-50%);
            animation: adjustCable 8s ease-in-out infinite alternate;
        }

        /* Pengait (Hook) */
        .hook {
            position: absolute;
            bottom: -15px;
            left: 50%;
            width: 16px;
            height: 16px;
            border: 3px solid #ffcc00;
            border-top: none;
            border-radius: 0 0 8px 8px;
            transform: translateX(-50%);
        }

        /* Wadah Beban / Kontainer Teks */
        .load {
            position: absolute;
            top: 210px;
            left: calc(10% - 160px); /* Sinkron dengan posisi awal trolley + offset setengah lebar load */
            width: 400px;
            padding: 20px;
            background: #222;
            border: 4px dashed #ffcc00;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 20px 30px rgba(0,0,0,0.7);
            animation: moveLoad 8s ease-in-out infinite alternate;
        }

        .load h1 {
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #ffcc00;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .load p {
            font-size: 1rem;
            color: #aaa;
        }

        /* Teks Tambahan di Bagian Bawah */
        .info-text {
            text-align: center;
            margin-bottom: 40px;
            padding: 0 20px;
        }

        .info-text p {
            font-size: 1.1rem;
            color: #ccc;
            max-width: 500px;
            line-height: 1.6;
        }

        /* === ANIMASI KEYFRAMES === */
        
        /* Menggerakkan Derek Horisontal */
        @keyframes moveTrolley {
            0% { left: 15%; }
            50% { left: 75%; }
            100% { left: 45%; }
        }

        /* Menggerakkan Beban Mengikuti Derek + Efek Ayunan Halus */
        @keyframes moveLoad {
            0% { 
                left: calc(15% - 160px); 
                transform: rotate(1deg);
            }
            50% { 
                left: calc(75% - 160px); 
                transform: rotate(-1deg);
            }
            100% { 
                left: calc(45% - 160px); 
                transform: rotate(0deg);
            }
        }

        /* Menjaga Kabel Tetap Selaras dan Sedikit Berayun */
        @keyframes adjustCable {
            0% { transform: translateX(-50%) rotate(0.5deg); }
            50% { transform: translateX(-50%) rotate(-0.5deg); }
            100% { transform: translateX(-50%) rotate(0deg); }
        }
    </style>
</head>
<body>

    <!-- Garis Hazard Atas -->
    <div class="hazard-bar"></div>

    <!-- Zona Utama Crane -->
    <div class="construction-zone">
        <!-- Jembatan Crane -->
        <div class="crane-bridge"></div>
        
        <!-- Trolley & Kabel yang bergerak -->
        <div class="trolley">
            <div class="cable">
                <div class="hook"></div>
            </div>
        </div>

        <!-- Beban Teks yang Diangkat -->
        <div class="load">
            <h1>Under Construction!</h1>
            <p>We are building something awesome.</p>
        </div>
    </div>

    <!-- Informasi Tambahan -->
    <div class="info-text">
        <p>Mohon maaf atas ketidaknyamanannya. Saat ini kami sedang melakukan peningkatan sistem. Silakan kembali lagi nanti.</p>
    </div>

    <!-- Garis Hazard Bawah -->
    <div class="hazard-bar"></div>

</body>
</html>