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

        /* Garis Konstruksi Kuning Hitam */
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
            height: 65vh;
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

        /* Trolley / Derek */
        .trolley {
            position: absolute;
            top: 15px;
            left: 50%;
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
            height: 150px; /* Dikurangi sedikit agar proporsional di layar pendek */
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
            top: 180px;
            left: 50%;
            width: 90%; /* Menggunakan persentase agar responsif */
            max-width: 400px; /* Batas maksimal di layar besar */
            padding: 20px;
            background: #222;
            border: 4px dashed #ffcc00;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 20px 30px rgba(0,0,0,0.7);
            animation: moveLoad 8s ease-in-out infinite alternate;
        }

        .load h1 {
            font-size: 1.6rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #ffcc00;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .load p {
            font-size: 0.95rem;
            color: #aaa;
        }

        /* Teks Tambahan di Bagian Bawah */
        .info-text {
            text-align: center;
            margin-bottom: 40px;
            padding: 0 24px;
        }

        .info-text p {
            font-size: 1rem;
            color: #ccc;
            max-width: 500px;
            line-height: 1.6;
        }

        /* === ANIMASI DEFAULT (DESKTOP & TABLET LEBAR) === */
        @keyframes moveTrolley {
            0% { transform: translateX(-150px); }
            50% { transform: translateX(150px); }
            100% { transform: translateX(0px); }
        }

        @keyframes moveLoad {
            0% { transform: translateX(-50%) translateX(-150px) rotate(1deg); }
            50% { transform: translateX(-50%) translateX(150px) rotate(-1deg); }
            100% { transform: translateX(-50%) translateX(0px) rotate(0deg); }
        }

        @keyframes adjustCable {
            0% { transform: translateX(-50%) rotate(0.8deg); }
            50% { transform: translateX(-50%) rotate(-0.8deg); }
            100% { transform: translateX(-50%) rotate(0deg); }
        }

        /* === MEDIA QUERY: TABLET (Maksimal Lebar 768px) === */
        @media (max-width: 768px) {
            .load h1 {
                font-size: 1.4rem;
            }
            
            /* Jangkauan geser crane dikurangi agar tidak keluar layar tablet */
            @keyframes moveTrolley {
                0% { transform: translateX(-100px); }
                50% { transform: translateX(100px); }
                100% { transform: translateX(0px); }
            }

            @keyframes moveLoad {
                0% { transform: translateX(-50%) translateX(-100px) rotate(1deg); }
                50% { transform: translateX(-50%) translateX(100px) rotate(-1deg); }
                100% { transform: translateX(-50%) translateX(0px) rotate(0deg); }
            }
        }

        /* === MEDIA QUERY: HANDPHONE (Maksimal Lebar 480px) === */
        @media (max-width: 480px) {
            .crane-bridge {
                top: 25px;
            }
            
            .trolley {
                top: 0px;
                width: 65px;
                height: 25px;
            }

            .cable {
                height: 120px;
            }

            .load {
                top: 135px;
                padding: 15px 10px;
            }

            .load h1 {
                font-size: 1.2rem;
                letter-spacing: 0px;
            }

            .load p {
                font-size: 0.85rem;
            }

            .info-text p {
                font-size: 0.9rem;
            }

            /* Jangkauan geser crane diminimalkan khusus untuk layar hp yang sempit */
            @keyframes moveTrolley {
                0% { transform: translateX(-40px); }
                50% { transform: translateX(40px); }
                100% { transform: translateX(0px); }
            }

            @keyframes moveLoad {
                0% { transform: translateX(-50%) translateX(-40px) rotate(1.5deg); }
                50% { transform: translateX(-50%) translateX(40px) rotate(-1.5deg); }
                100% { transform: translateX(-50%) translateX(0px) rotate(0deg); }
            }
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
        
        <!-- Trolley & Kabel -->
        <div class="trolley">
            <div class="cable">
                <div class="hook"></div>
            </div>
        </div>

        <!-- Teks Under Construction -->
        <div class="load">
            <h1>Under Construction!</h1>
            <p>This website is under construction.</p>
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