<template>
  <div class="min-h-screen bg-slate-50 dark:bg-slate-950 px-4 sm:px-6 lg:px-8 selection:bg-blue-500/30 transition-colors duration-300">
    <!-- Background Effects -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-[20%] -left-[10%] w-[70%] h-[70%] bg-blue-600/5 dark:bg-blue-600/10 rounded-full blur-[120px] animate-pulse"></div>
      <div class="absolute top-[20%] -right-[10%] w-[60%] h-[60%] bg-purple-600/5 dark:bg-purple-600/10 rounded-full blur-[100px] animate-pulse delay-1000"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-50 pt-6 pb-2">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 dark:from-white dark:to-slate-400">SmartTools AI</span>
        </div>
        
        <div class="flex items-center space-x-4">
          <!-- Language Switcher -->
          <button @click="toggleLocale" class="text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-white font-medium transition flex items-center">
            <span class="uppercase">{{ locale }}</span>
          </button>

          <!-- Theme Switcher -->
          <button @click="toggleTheme" class="text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-white transition p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-800">
            <svg v-if="theme === 'dark'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
          </button>

          <div class="h-6 w-px bg-slate-300 dark:bg-slate-700 mx-2"></div>

          <router-link to="/login" class="text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-white font-medium transition">{{ $t('nav.login') }}</router-link>
          <router-link to="/register" class="px-5 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold rounded-lg hover:bg-slate-800 dark:hover:bg-slate-100 transition shadow-lg shadow-slate-900/10 dark:shadow-white/10">
            {{ $t('nav.getStarted') }}
          </router-link>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative z-10 pt-20 pb-32 lg:pt-32">
      <div class="max-w-7xl mx-auto text-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full border border-blue-500/30 bg-blue-500/10 text-blue-600 dark:text-blue-400 text-sm font-medium mb-8 backdrop-blur-sm">
          <span class="flex h-2 w-2 rounded-full bg-blue-500 dark:bg-blue-400 mr-2 animate-pulse"></span>
          {{ $t('hero.badge') }}
        </div>
        
        <h1 class="text-5xl md:text-7xl font-bold text-slate-900 dark:text-white tracking-tight mb-8">
          {{ $t('hero.title') }} <br />
          <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 dark:from-blue-400 dark:via-purple-500 dark:to-pink-500">{{ $t('hero.titleHighlight') }}</span>
        </h1>
        
        <p class="mt-6 text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto mb-10 leading-relaxed">
         {{ $t('hero.subtitle') }}
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
          <router-link to="/register" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-700 dark:from-blue-500 dark:to-purple-600 text-white font-bold text-lg rounded-2xl hover:shadow-lg hover:shadow-blue-500/25 transition transform hover:-translate-y-1">
            {{ $t('hero.ctaFree') }}
          </router-link>
          <router-link to="/login" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-semibold text-lg rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700 transition flex items-center justify-center group">
            <span>{{ $t('hero.ctaDemo') }}</span>
            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </router-link>
        </div>

        <!-- Social Proof / Stats -->
        <div class="mt-16 pt-8 border-t border-slate-200 dark:border-slate-800/50 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
          <div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white">50+</div>
            <div class="text-sm text-slate-600 dark:text-slate-500 mt-1">{{ $t('stats.dailyGenerations') }}</div>
          </div>
          <div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white">3+</div>
            <div class="text-sm text-slate-600 dark:text-slate-500 mt-1">{{ $t('stats.advancedTools') }}</div>
          </div>
          <div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white">99%</div>
            <div class="text-sm text-slate-600 dark:text-slate-500 mt-1">{{ $t('stats.uptime') }}</div>
          </div>
          <div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white">24/7</div>
            <div class="text-sm text-slate-600 dark:text-slate-500 mt-1">{{ $t('stats.aiAvailability') }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Feature Grid -->
    <div class="relative z-10 py-24 bg-white/50 dark:bg-slate-900/50 backdrop-blur-3xl -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 border-y border-slate-200 dark:border-slate-800">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4">{{ $t('features.title') }}</h2>
          <p class="text-slate-600 dark:text-slate-400 text-lg">{{ $t('features.subtitle') }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <!-- Tool 1 -->
          <div class="group p-8 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-3xl hover:border-blue-500/50 hover:bg-slate-50 dark:hover:bg-slate-800 transition duration-300 shadow-sm dark:shadow-none">
            <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500/20 transition">
              <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">{{ $t('features.textGenerator.title') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
              {{ $t('features.textGenerator.desc') }}
            </p>
          </div>

          <!-- Tool 2 -->
          <div class="group p-8 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-3xl hover:border-purple-500/50 hover:bg-slate-50 dark:hover:bg-slate-800 transition duration-300 shadow-sm dark:shadow-none">
            <div class="w-14 h-14 bg-purple-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-500/20 transition">
              <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">{{ $t('features.summarizer.title') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
              {{ $t('features.summarizer.desc') }}
            </p>
          </div>

          <!-- Tool 3 -->
          <div class="group p-8 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-3xl hover:border-pink-500/50 hover:bg-slate-50 dark:hover:bg-slate-800 transition duration-300 shadow-sm dark:shadow-none">
            <div class="w-14 h-14 bg-pink-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-pink-500/20 transition">
              <svg class="w-7 h-7 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">{{ $t('features.imageAnalyzer.title') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
              {{ $t('features.imageAnalyzer.desc') }}
            </p>
            <span class="inline-block mt-4 px-3 py-1 bg-pink-500/10 text-pink-600 dark:text-pink-400 text-xs font-semibold rounded-full">{{ $t('features.imageAnalyzer.new') }}</span>
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
import { useI18n } from 'vue-i18n';
import { useTheme } from '../composables/useTheme';

const { locale } = useI18n();
const { theme, toggleTheme } = useTheme();

const toggleLocale = () => {
  locale.value = locale.value === 'en' ? 'fr' : 'en';
};
</script>
