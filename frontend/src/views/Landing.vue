<template>
  <div class="min-h-screen bg-slate-50 dark:bg-slate-950 px-4 sm:px-6 lg:px-8 selection:bg-blue-500/30 transition-colors duration-300">
    <!-- Background Effects -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-[20%] -left-[10%] w-[70%] h-[70%] bg-blue-600/5 dark:bg-blue-600/10 rounded-full blur-[120px] animate-pulse"></div>
      <div class="absolute top-[20%] -right-[10%] w-[60%] h-[60%] bg-purple-600/5 dark:bg-purple-600/10 rounded-full blur-[100px] animate-pulse delay-1000"></div>
    </div>

    <!-- Navigation -->
    <nav 
      class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b"
      :class="[
        isScrolled 
          ? 'py-3 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-slate-200 dark:border-slate-800 shadow-sm' 
          : 'py-6 bg-transparent border-transparent'
      ]"
    >
      <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 dark:from-white dark:to-slate-400">SmartTools AI</span>
        </div>
        
        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center space-x-6">
          <div class="flex items-center space-x-4 mr-4">
            <button @click="toggleLocale" class="text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-white font-medium transition flex items-center gap-1">
              <span class="uppercase text-xs tracking-widest border border-slate-300 dark:border-slate-700 px-1.5 rounded">{{ locale }}</span>
            </button>

            <button @click="toggleTheme" class="text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-white transition p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-800">
              <svg v-if="theme === 'dark'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
              </svg>
            </button>
          </div>

          <div class="h-6 w-px bg-slate-200 dark:bg-slate-800"></div>

          <router-link to="/login" class="text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-white font-medium transition">{{ $t('nav.login') }}</router-link>
          <router-link to="/register" class="px-5 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold rounded-xl hover:bg-slate-800 dark:hover:bg-slate-100 transition shadow-lg">
            {{ $t('nav.getStarted') }}
          </router-link>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="md:hidden flex items-center gap-4">
           <button @click="toggleTheme" class="text-slate-600 dark:text-slate-300 p-2">
              <svg v-if="theme === 'dark'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
           </button>
           <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-900 dark:text-white">
              <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
              <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
           </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <transition 
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0 -translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 -translate-y-4"
      >
        <div v-if="mobileMenuOpen" class="md:hidden absolute top-full left-0 right-0 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 p-4 shadow-xl">
           <div class="flex flex-col space-y-4">
             <router-link to="/login" class="text-slate-600 dark:text-slate-300 font-medium p-2">{{ $t('nav.login') }}</router-link>
             <router-link to="/register" class="px-5 py-3 bg-blue-600 text-white font-bold rounded-xl text-center">{{ $t('nav.getStarted') }}</router-link>
             <div class="h-px bg-slate-200 dark:bg-slate-800"></div>
             <button @click="toggleLocale" class="flex items-center justify-between text-slate-600 dark:text-slate-300 font-medium p-2">
                <span>Language</span>
                <span class="uppercase font-bold text-blue-600">{{ locale }}</span>
             </button>
           </div>
        </div>
      </transition>
    </nav>

    <!-- Hero Section -->
    <div class="relative z-10 pt-28 pb-16 lg:pt-40 lg:pb-32 px-4">
      <div class="max-w-7xl mx-auto text-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full border border-blue-500/30 bg-blue-500/10 text-blue-600 dark:text-blue-400 text-xs md:text-sm font-medium mb-8 backdrop-blur-sm">
          <span class="flex h-2 w-2 rounded-full bg-blue-500 dark:bg-blue-400 mr-2 animate-pulse"></span>
          {{ $t('hero.badge') }}
        </div>
        
        <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-8 leading-[1.1]">
          {{ $t('hero.title') }} <br class="hidden sm:block" />
          <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 dark:from-blue-400 dark:via-purple-500 dark:to-pink-500">{{ $t('hero.titleHighlight') }}</span>
        </h1>
        
        <p class="mt-6 text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto mb-10 leading-relaxed px-4">
         {{ $t('hero.subtitle') }}
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 px-4">
          <router-link to="/register" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-700 dark:from-blue-500 dark:to-purple-600 text-white font-bold text-lg rounded-2xl hover:shadow-2xl hover:shadow-blue-500/25 transition transform hover:-translate-y-1 text-center">
            {{ $t('hero.ctaFree') }}
          </router-link>
          <router-link to="/login" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-semibold text-lg rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700 transition flex items-center justify-center group text-center">
            <span>{{ $t('hero.ctaDemo') }}</span>
            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </router-link>
        </div>

        <!-- Social Proof / Stats -->
        <div class="mt-16 pt-8 border-t border-slate-200 dark:border-slate-800/50 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 max-w-4xl mx-auto px-4">
          <div class="p-4 bg-white/50 dark:bg-white/5 rounded-2xl transition-transform hover:scale-105">
            <div class="text-3xl font-bold text-slate-900 dark:text-white">50k+</div>
            <div class="text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-500 mt-1 font-bold">{{ $t('stats.dailyGenerations') }}</div>
          </div>
          <div class="p-4 bg-white/50 dark:bg-white/5 rounded-2xl transition-transform hover:scale-105">
            <div class="text-3xl font-bold text-slate-900 dark:text-white">10+</div>
            <div class="text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-500 mt-1 font-bold">{{ $t('stats.advancedTools') }}</div>
          </div>
          <div class="p-4 bg-white/50 dark:bg-white/5 rounded-2xl transition-transform hover:scale-105">
            <div class="text-3xl font-bold text-slate-900 dark:text-white">99.9%</div>
            <div class="text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-500 mt-1 font-bold">{{ $t('stats.uptime') }}</div>
          </div>
          <div class="p-4 bg-white/50 dark:bg-white/5 rounded-2xl transition-transform hover:scale-105">
            <div class="text-3xl font-bold text-slate-900 dark:text-white">24/7</div>
            <div class="text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-500 mt-1 font-bold">{{ $t('stats.aiAvailability') }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Feature Grid -->
    <div id="features" class="relative z-10 py-24 bg-white/30 dark:bg-slate-900/40 backdrop-blur-3xl px-4 sm:px-6 lg:px-8 border-y border-slate-200 dark:border-slate-800">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4 leading-tight">{{ $t('features.title') }}</h2>
          <p class="text-slate-600 dark:text-slate-400 text-lg max-w-2xl mx-auto">{{ $t('features.subtitle') }}</p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
          <!-- Tool 1 -->
          <div class="group p-8 bg-white/80 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 rounded-[2rem] hover:border-blue-500/50 hover:bg-white dark:hover:bg-slate-800 transition-all duration-500 shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transform hover:-translate-y-2">
            <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500/20 transition-colors">
              <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">{{ $t('features.textGenerator.title') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm md:text-base">
              {{ $t('features.textGenerator.desc') }}
            </p>
          </div>

          <!-- Tool 2 -->
          <div class="group p-8 bg-white/80 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 rounded-[2rem] hover:border-purple-500/50 hover:bg-white dark:hover:bg-slate-800 transition-all duration-500 shadow-sm hover:shadow-2xl hover:shadow-purple-500/10 transform hover:-translate-y-2">
            <div class="w-14 h-14 bg-purple-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-500/20 transition-colors">
              <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">{{ $t('features.summarizer.title') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm md:text-base">
              {{ $t('features.summarizer.desc') }}
            </p>
          </div>

          <!-- Tool 3 -->
          <div class="group p-8 bg-white/80 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 rounded-[2rem] hover:border-pink-500/50 hover:bg-white dark:hover:bg-slate-800 transition-all duration-500 shadow-sm hover:shadow-2xl hover:shadow-pink-500/10 transform hover:-translate-y-2">
            <div class="w-14 h-14 bg-pink-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-pink-500/20 transition-colors">
              <svg class="w-7 h-7 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">{{ $t('features.imageAnalyzer.title') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm md:text-base">
              {{ $t('features.imageAnalyzer.desc') }}
            </p>
            <div class="mt-4">
              <span class="px-3 py-1 bg-pink-500/10 text-pink-600 dark:text-pink-400 text-xs font-bold rounded-full border border-pink-500/20">{{ $t('features.imageAnalyzer.new') }}</span>
            </div>
          </div>

          <!-- Tool 4 -->
          <div class="group p-8 bg-white/80 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 rounded-[2rem] hover:border-orange-500/50 hover:bg-white dark:hover:bg-slate-800 transition-all duration-500 shadow-sm hover:shadow-2xl hover:shadow-orange-500/10 transform hover:-translate-y-2">
            <div class="w-14 h-14 bg-orange-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-500/20 transition-colors">
              <svg class="w-7 h-7 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">{{ $t('features.humanizer.title') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm md:text-base">
              {{ $t('features.humanizer.desc') }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Testimonials Section -->
    <div class="relative z-10 py-24 bg-white dark:bg-slate-950 px-4">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 px-4">
          <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4">Loved by 10,000+ users</h2>
          <p class="text-slate-600 dark:text-slate-400 text-lg">Real stories from creators and professionals.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
          <div class="p-8 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-blue-500/20 transition-all shadow-sm">
             <div class="flex items-center gap-4 mb-6">
               <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">AR</div>
               <div>
                  <div class="font-bold dark:text-white">Alex Rivar</div>
                  <div class="text-xs text-gray-500">Global Content Lead</div>
               </div>
             </div>
             <p class="text-slate-600 dark:text-gray-300 italic leading-relaxed">"The Pro mode is a massive productivity booster. I can generate high-quality drafts for my entire newsletter in minutes instead of hours."</p>
          </div>
          <div class="p-8 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-pink-500/20 transition-all shadow-sm">
             <div class="flex items-center gap-4 mb-6">
               <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center text-white font-bold">SK</div>
               <div>
                  <div class="font-bold dark:text-white">Sara Kim</div>
                  <div class="text-xs text-gray-500">Indie Hacker</div>
               </div>
             </div>
             <p class="text-slate-600 dark:text-gray-300 italic leading-relaxed">"SmartTools AI's humanizer is surprisingly good. It preserves my voice while fixing the awkward AI phrasiology. Pure gold."</p>
          </div>
          <div class="p-8 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 hover:border-orange-500/20 transition-all shadow-sm sm:col-span-2 lg:col-span-1">
             <div class="flex items-center gap-4 mb-6">
               <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-600 rounded-full flex items-center justify-center text-white font-bold">MT</div>
               <div>
                  <div class="font-bold dark:text-white">Mike Toran</div>
                  <div class="text-xs text-gray-500">Fullstack Developer</div>
               </div>
             </div>
             <p class="text-slate-600 dark:text-gray-300 italic leading-relaxed">"I've tried many AI tools, but the clean UI and speed here are unmatched. The Llama 3.3 model on the Pro plan is incredibly smart."</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Pricing Section -->
    <div id="pricing" class="relative z-10 py-24 bg-slate-50 dark:bg-slate-900/20 border-t border-slate-200 dark:border-slate-800 px-4">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 px-4">
          <h2 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4 leading-tight">Ready to boost your creativity?</h2>
          <p class="text-slate-600 dark:text-slate-400 text-lg max-w-2xl mx-auto">Start with 40 generations per day on our Basic plan. No credit card required.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto px-4">
          <!-- Free Plan -->
          <div class="p-8 md:p-12 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2.5rem] shadow-xl hover:shadow-2xl transition-all duration-300 group">
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Basic Starter</h3>
            <div class="flex items-baseline mb-6">
              <span class="text-5xl font-extrabold text-slate-900 dark:text-white">$0</span>
              <span class="text-slate-500 ml-2 font-medium">/forever</span>
            </div>
            <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">Explore the capabilities of SmartTools AI with daily free credits.</p>
            <ul class="space-y-4 mb-10">
              <li class="flex items-center text-slate-700 dark:text-slate-300 font-medium">
                <div class="mr-3 bg-green-500/10 p-1 rounded-full"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                40 free generations per day
              </li>
              <li class="flex items-center text-slate-700 dark:text-slate-300 font-medium">
                <div class="mr-3 bg-green-500/10 p-1 rounded-full"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                Standard processing speed
              </li>
              <li class="flex items-center text-slate-700 dark:text-slate-300 font-medium opacity-50">
                <div class="mr-3 bg-slate-500/10 p-1 rounded-full"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
                No Advanced AI models
              </li>
            </ul>
            <router-link to="/register" class="block w-full py-4 px-6 text-center text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-2xl font-bold transition-all text-lg">
              Get Started Free
            </router-link>
          </div>

          <!-- Pro Plan -->
          <div class="p-8 md:p-12 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-[2.5rem] shadow-2xl relative overflow-hidden transform hover:-translate-y-2 transition-all duration-300 ring-4 ring-blue-500/20">
            <div class="absolute top-0 right-0 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-xs font-black px-6 py-2 rounded-bl-3xl tracking-widest uppercase">Best Value</div>
            <h3 class="text-2xl font-bold mb-2">Pro Unlimited</h3>
            <div class="flex items-baseline mb-6">
              <span class="text-5xl font-extrabold">$9</span>
              <span class="opacity-60 ml-2 font-medium">/month</span>
            </div>
            <p class="opacity-80 mb-8 leading-relaxed text-lg">Unleash full parameters and unlimited creative output.</p>
            <ul class="space-y-4 mb-10">
              <li class="flex items-center font-bold">
                <div class="mr-3 bg-blue-500/20 p-1 rounded-full"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                Unlimited generations
              </li>
              <li class="flex items-center font-bold">
                <div class="mr-3 bg-blue-500/20 p-1 rounded-full"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                Ultra-fast priority processing ⚡
              </li>
              <li class="flex items-center font-bold">
                <div class="mr-3 bg-blue-500/20 p-1 rounded-full"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                Llama 3.3 70B (Advanced Engine)
              </li>
            </ul>
            <router-link to="/register?plan=pro" class="block w-full py-4 px-6 text-center text-white dark:text-slate-950 bg-blue-600 dark:bg-blue-600 rounded-2xl font-black shadow-lg hover:shadow-blue-500/40 transition-all text-xl">
              Go Pro Now
            </router-link>
            <p class="mt-4 text-center text-xs opacity-50 font-medium">7-day free trial included. Cancel anytime.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="relative z-10 py-24">
      <div class="max-w-5xl mx-auto text-center px-4">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-8 md:p-16 relative overflow-hidden text-white">
          <div class="relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold mb-6">{{ $t('cta.title') }}</h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
              {{ $t('cta.subtitle') }}
            </p>
            <router-link to="/register" class="inline-block px-8 py-4 bg-white text-blue-600 font-bold text-lg rounded-xl shadow-xl hover:bg-slate-50 transition transform hover:scale-105">
              {{ $t('cta.button') }}
            </router-link>
            <p class="mt-4 text-sm text-blue-200 opacity-80">{{ $t('cta.note') }}</p>
          </div>
          
          <!-- Decorative circles -->
          <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
          <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-800/20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-slate-200 dark:border-slate-800 py-12 text-center text-slate-500">
      <p>&copy; 2026 {{ $t('footer.rights') }}</p>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useTheme } from '../composables/useTheme';

const { locale } = useI18n();
const { theme, toggleTheme } = useTheme();

const mobileMenuOpen = ref(false);
const isScrolled = ref(false);

const handleScroll = () => {
  isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});

const toggleLocale = () => {
  locale.value = locale.value === 'en' ? 'fr' : 'en';
};
</script>
