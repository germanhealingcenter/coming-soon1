<?php
// Set the launch date (1 month from now)
$launchDate = strtotime('+1 month');
$currentTime = time();
$timeLeft = $launchDate - $currentTime;

$days = floor($timeLeft / (60 * 60 * 24));
$hours = floor(($timeLeft % (60 * 60 * 24)) / (60 * 60));
$minutes = floor(($timeLeft % (60 * 60)) / 60);
$seconds = $timeLeft % 60;

// Calculate progress percentage
$totalTime = 30 * 24 * 60 * 60; // 30 days in seconds
$progress = (($totalTime - $timeLeft) / $totalTime) * 100;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1a1c20 0%, #0f1115 100%);
            --accent-color: #3498db;
            --accent-gradient: linear-gradient(45deg, #3498db, #2ecc71);
            --text-color: #ffffff;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            background: var(--primary-gradient);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 1rem;
        }

        .container {
            max-width: 800px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            box-shadow: 0 8px 32px var(--shadow-color);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            letter-spacing: 4px;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeInDown 1s ease-out;
        }

        .subtitle {
            font-size: 1.2rem;
            margin-bottom: 3rem;
            opacity: 0.8;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
            margin: 2rem 0;
            animation: fadeIn 1s ease-out 1s both;
        }

        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            min-width: 120px;
            transition: transform 0.3s ease;
        }

        .countdown-item:hover {
            transform: translateY(-5px);
        }

        .countdown-number {
            font-size: 3rem;
            font-weight: bold;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .countdown-label {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 0.5rem;
            opacity: 0.7;
        }

        .progress-container {
            width: 100%;
            max-width: 400px;
            margin: 3rem auto;
            animation: fadeIn 1s ease-out 1.5s both;
        }

        .loading-bar {
            width: 100%;
            height: 6px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            overflow: hidden;
        }

        .loading-progress {
            width: <?php echo $progress; ?>%;
            height: 100%;
            background: var(--accent-gradient);
            border-radius: 3px;
            transition: width 0.5s ease;
            animation: shimmer 2s infinite linear;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        @media (max-width: 768px) {
            .countdown {
                flex-wrap: wrap;
                gap: 1rem;
            }

            .countdown-item {
                min-width: 100px;
                padding: 1rem;
            }

            h1 {
                font-size: 2.5rem;
            }

            .countdown-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Coming Soon</h1>
        <p class="subtitle">Something amazing is in the works</p>
        <div class="countdown">
            <div class="countdown-item">
                <span class="countdown-number"><?php echo str_pad($days, 2, '0', STR_PAD_LEFT); ?></span>
                <span class="countdown-label">Days</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></span>
                <span class="countdown-label">Hours</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number"><?php echo str_pad($minutes, 2, '0', STR_PAD_LEFT); ?></span>
                <span class="countdown-label">Minutes</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number"><?php echo str_pad($seconds, 2, '0', STR_PAD_LEFT); ?></span>
                <span class="countdown-label">Seconds</span>
            </div>
        </div>
        <div class="progress-container">
            <div class="loading-bar">
                <div class="loading-progress"></div>
            </div>
        </div>
    </div>

    <script>
    // Update the countdown every second without page reload
    function updateCountdown() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update countdown numbers
                document.querySelectorAll('.countdown-number').forEach((el, i) => {
                    el.textContent = doc.querySelectorAll('.countdown-number')[i].textContent;
                });
                
                // Update progress bar
                const newProgress = doc.querySelector('.loading-progress').style.width;
                document.querySelector('.loading-progress').style.width = newProgress;
            });
    }

    // Update every second
    setInterval(updateCountdown, 1000);
    </script>
</body>
</html>
