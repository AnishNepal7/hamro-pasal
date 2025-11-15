<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hamro Pasal - Inventory Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#1a1a2e',
            accent: '#d4af37',
            secondary: '#0f172a',
            light: '#f1f5f9',
            grayish: '#cbd5e1',
          },
          boxShadow: {
            glow: '0 0 25px rgba(212,175,55,0.3)',
          },
          fontFamily: {
            orbitron: ['Orbitron', 'sans-serif'],
            roboto: ['Roboto', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: radial-gradient(circle at top right, #2b2b40, #0f172a 80%);
      color: #f8fafc;
      overflow-x: hidden;
    }
    .glass {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .shine:hover {
      background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, transparent 100%);
      transition: all 0.4s ease;
    }
    .gradient-text {
      background: linear-gradient(to right, #f1f5f9, #d4af37);
      -webkit-background-clip: text;
      color: transparent;
    }
  </style>
</head>
<body class="flex flex-col min-h-screen">

  <!-- Header -->
  <header class="w-full py-6 px-10 flex justify-between items-center backdrop-blur-lg bg-primary/60 border-b border-gray-700 fixed top-0 z-40">
    <h1 class="text-3xl font-orbitron text-accent tracking-wider">Hamro Pasal</h1>
    <div class="flex gap-4">
      <a href="{{ route('login') }}" class="px-6 py-2 rounded-md border border-accent text-accent hover:bg-accent hover:text-primary font-medium transition-all">Log In</a>
      <a href="{{ route('register') }}" class="px-6 py-2 rounded-md bg-accent text-primary font-medium hover:bg-yellow-400 transition-all">Register</a>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="flex flex-col-reverse md:flex-row justify-between items-center w-full px-10 mt-32 md:mt-40 max-w-7xl mx-auto">
    <div class="md:w-1/2 text-center md:text-left">
      <h2 class="text-5xl md:text-6xl font-bold mb-6 font-orbitron gradient-text">Industrial-Grade Inventory Management</h2>
      <p class="text-grayish text-lg mb-8 leading-relaxed">Revolutionizing retail management with AI-powered analytics, smart alerts, and seamless forecasting tools — built for efficiency and accuracy.</p>
      <div class="flex gap-4 justify-center md:justify-start">
        <a href="{{ route('login') }}" class="px-8 py-3 rounded-lg bg-accent text-primary font-bold hover:bg-yellow-400 transition-all">Get Started</a>
        <a href="#features" class="px-8 py-3 rounded-lg border border-accent text-accent font-bold hover:bg-accent hover:text-primary transition-all">Learn More</a>
      </div>
    </div>

    <div class="md:w-1/2 flex justify-center md:justify-end mb-12 md:mb-0">
      <div class="relative">
        <div class="absolute inset-0 bg-accent/20 blur-3xl rounded-full animate-pulse"></div>
        <div class="bg-gradient-to-br from-accent/40 to-primary/40 rounded-full p-8 shadow-glow">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-56 w-56" fill="none" viewBox="0 0 24 24" stroke="#f1f5f9" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 7l10 5 10-5-10-5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M2 12l10 5 10-5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M2 17l10 5 10-5" />
          </svg>
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section id="features" class="mt-32 px-8 md:px-16 lg:px-32 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">
    <div class="glass p-8 rounded-xl hover:shadow-glow transition-all">
      <div class="text-4xl text-accent mb-4">📊</div>
      <h3 class="text-2xl font-semibold mb-2">Real-Time Analytics</h3>
      <p class="text-grayish leading-relaxed">Get up-to-the-minute insights on your sales, stock, and performance with interactive dashboards.</p>
    </div>
    <div class="glass p-8 rounded-xl hover:shadow-glow transition-all">
      <div class="text-4xl text-accent mb-4">🤖</div>
      <h3 class="text-2xl font-semibold mb-2">AI Forecasting</h3>
      <p class="text-grayish leading-relaxed">Use advanced machine learning algorithms to anticipate demand and prevent stockouts.</p>
    </div>
    <div class="glass p-8 rounded-xl hover:shadow-glow transition-all">
      <div class="text-4xl text-accent mb-4">🔔</div>
      <h3 class="text-2xl font-semibold mb-2">Smart Alerts</h3>
      <p class="text-grayish leading-relaxed">Stay informed with intelligent alerts about low inventory, pricing trends, and anomalies.</p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="mt-24 py-10 text-center border-t border-gray-700 text-grayish">
    <p>© {{ date('Y') }} <span class="text-accent font-semibold">Hamro Pasal</span>. All rights reserved.</p>
  </footer>

</body>
</html>
