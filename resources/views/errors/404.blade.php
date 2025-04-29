{{-- resources/views/errors/404.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404 — TERMINAL HELL</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    /* Reset */
    * { margin:0; padding:0; box-sizing:border-box; }

    body {
      background: #111;
      font-family: 'Courier New', monospace;
      color: #eee;
      overflow: hidden;
    }

    /* Glitch overlay */
    @keyframes screen-glitch {
      0%   { clip: rect(0, 9999px, 0, 0); }
      5%   { clip: rect(10px, 9999px, 80px, 0); }
      10%  { clip: rect(50px, 9999px, 100px, 0); }
      15%  { clip: rect(0, 9999px, 50px, 0); }
      20%  { clip: rect(30px, 9999px, 90px, 0); }
      25%  { clip: rect(20px, 9999px, 40px, 0); }
      30%  { clip: rect(60px, 9999px, 110px, 0); }
      35%  { clip: rect(0, 9999px, 30px, 0); }
      40%  { clip: rect(40px, 9999px, 120px, 0); }
      45%  { clip: rect(10px, 9999px, 70px, 0); }
      50%  { clip: rect(0, 9999px, 20px, 0); }
      55%  { clip: rect(20px, 9999px, 60px, 0); }
      60%  { clip: rect(0, 9999px, 10px, 0); }
      65%  { clip: rect(30px, 9999px, 100px, 0); }
      70%  { clip: rect(50px, 9999px, 130px, 0); }
      75%  { clip: rect(0, 9999px, 25px, 0); }
      80%  { clip: rect(40px, 9999px, 110px, 0); }
      85%  { clip: rect(10px, 9999px, 80px, 0); }
      90%  { clip: rect(0, 9999px, 20px, 0); }
      95%  { clip: rect(25px, 9999px, 90px, 0); }
      100% { clip: rect(0, 9999px, 0, 0); }
    }
    .glitch {
      position:absolute; top:0; left:0; width:100%; height:100%;
      background: rgba(255,255,255,0.05);
      animation: screen-glitch 2s infinite;
      pointer-events:none;
    }

    .container {
      position: relative;
      width:100vw; height:100vh;
      display:flex; flex-direction:column;
      justify-content:center; align-items:center;
      text-align:center;
    }

    h1 {
      font-size: 6rem;
      color: #fff;
      text-shadow:
        1px 0 #aaa, -1px 0 #aaa,
        0 1px #aaa, 0 -1px #aaa;
    }

    p {
      margin: 1rem 0;
      font-size: 1.25rem;
      color: #ccc;
    }

    .monster {
      width: 200px; height: 200px;
      background: url('{{ asset("images/pixel-monster.png") }}') no-repeat center/contain;
      margin-bottom: 2rem;
      animation: monster-entrance 1s ease-out forwards;
      opacity: 0;
    }
    @keyframes monster-entrance {
      0%   { transform: scale(0) rotate(-45deg); opacity:0; }
      70%  { transform: scale(1.2) rotate(15deg); opacity:1; }
      100% { transform: scale(1) rotate(0); }
    }

    .btn-home {
      padding: .75rem 1.5rem;
      background: #eee;
      color: #111;
      text-decoration:none;
      font-weight:bold;
      display:inline-block;
      margin-top:2rem;
      box-shadow: 0 0 10px rgba(255,255,255,0.3);
      transition: transform .2s, background .2s;
    }
    .btn-home:hover {
      transform: scale(1.1);
      background: #fff;
    }

    .cmd {
      font-family: 'Press Start 2P', cursive;
      color: #fff;
      letter-spacing: 2px;
      animation: flicker 1.5s infinite;
    }
    @keyframes flicker {
      0%,19%,21%,23%,25%,54%,56%,100% { opacity:1; }
      20%,24%,55%                    { opacity:0; }
    }
  </style>

  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
  <div class="glitch"></div>
  <div class="container">
    <div class="monster"></div>
    <h1 class="cmd">404</h1>
    <p class="cmd">SYSTEM BREACH DETECTED</p>
    <p>> WARNING: Unauthorized monster infiltration</p>
    <p>> MONSTER EMERGING: Engage lockdown protocol...</p>
    <a href="{{ url('/') }}" class="btn-home">RETURN TO SAFETY</a>
  </div>
</body>
</html>
