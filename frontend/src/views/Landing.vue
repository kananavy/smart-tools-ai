<template>
  <div class="min-h-screen bg-slate-950 px-4 sm:px-6 lg:px-8 selection:bg-blue-500/30">
    <!-- Background Effects -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-[20%] -left-[10%] w-[70%] h-[70%] bg-blue-600/10 rounded-full blur-[120px] animate-pulse"></div>
      <div class="absolute top-[20%] -right-[10%] w-[60%] h-[60%] bg-purple-600/10 rounded-full blur-[100px] animate-pulse delay-1000"></div>
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
          <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">SmartTools AI</span>
        </div>
        <div class="flex items-center space-x-4">
          <router-link to="/login" class="text-slate-300 hover:text-white font-medium transition">Login</router-link>
          <router-link to="/register" class="px-5 py-2.5 bg-white text-slate-900 font-semibold rounded-lg hover:bg-slate-100 transition shadow-lg shadow-white/10">
            Get Started
          </router-link>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative z-10 pt-20 pb-32 lg:pt-32">
      <div class="max-w-7xl mx-auto text-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full border border-blue-500/30 bg-blue-500/10 text-blue-400 text-sm font-medium mb-8 backdrop-blur-sm">
          <span class="flex h-2 w-2 rounded-full bg-blue-400 mr-2 animate-pulse"></span>
          Now with Llama 3.3 70B & Premium Tools
        </div>
        
        <h1 class="text-5xl md:text-7xl font-bold text-white tracking-tight mb-8">
          Unlock your potential with <br />
          <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500">Intelligent AI Tools</span>
        </h1>
        
        <p class="mt-6 text-xl text-slate-400 max-w-3xl mx-auto mb-10 leading-relaxed">
          The all-in-one platform for content generation, summarization, and image analysis. 
          Professional grade AI tools wrapped in a stunning interface.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
          <router-link to="/register" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-500 warm-gray-800 to-purple-600 text-white font-bold text-lg rounded-2xl hover:shadow-lg hover:shadow-blue-500/25 transition transform hover:-translate-y-1">
            Start Creating for Free
          </router-link>
          <router-link to="/login" class="w-full sm:w-auto px-8 py-4 bg-slate-800 border border-slate-700 text-white font-semibold text-lg rounded-2xl hover:bg-slate-700 transition flex items-center justify-center group">
            <span>View Demo</span>
            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </router-link>
        </div>

        <!-- Social Proof / Stats -->
        <div class="mt-16 pt-8 border-t border-slate-800/50 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
          <div>
            <div class="text-3xl font-bold text-white">50+</div>
            <div class="text-sm text-slate-500 mt-1">Daily Generations</div>
          </div>
          <div>
            <div class="text-3xl font-bold text-white">3+</div>
            <div class="text-sm text-slate-500 mt-1">Advanced Tools</div>
          </div>
          <div>
            <div class="text-3xl font-bold text-white">99%</div>
            <div class="text-sm text-slate-500 mt-1">Uptime</div>
          </div>
          <div>
            <div class="text-3xl font-bold text-white">24/7</div>
            <div class="text-sm text-slate-500 mt-1">AI Availability</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Feature Grid -->
    <div class="relative z-10 py-24 bg-slate-900/50 backdrop-blur-3xl -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 border-y border-slate-800">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Powerful Tools Suite</h2>
          <p class="text-slate-400 text-lg">Everything you need to boost productivity</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <!-- Tool 1 -->
          <div class="group p-8 bg-slate-800/50 border border-slate-700 rounded-3xl hover:border-blue-500/50 hover:bg-slate-800 transition duration-300">
            <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500/20 transition">
              <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Text Generator</h3>
            <p class="text-slate-400 leading-relaxed">
              Create SEO-optimized blog posts, engaging social media captions, and professional emails in seconds.
            </p>
          </div>

          <!-- Tool 2 -->
          <div class="group p-8 bg-slate-800/50 border border-slate-700 rounded-3xl hover:border-purple-500/50 hover:bg-slate-800 transition duration-300">
            <div class="w-14 h-14 bg-purple-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-500/20 transition">
              <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Smart Summarizer</h3>
            <p class="text-slate-400 leading-relaxed">
              Condense long articles, reports, and documents into concise, easy-to-read executive summaries.
            </p>
          </div>

          <!-- Tool 3 -->
          <div class="group p-8 bg-slate-800/50 border border-slate-700 rounded-3xl hover:border-pink-500/50 hover:bg-slate-800 transition duration-300">
            <div class="w-14 h-14 bg-pink-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-pink-500/20 transition">
              <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Image Analysis</h3>
            <p class="text-slate-400 leading-relaxed">
              Extract insights, text, and details from images using advanced computer vision technology.
            </p>
            <span class="inline-block mt-4 px-3 py-1 bg-pink-500/20 text-pink-400 text-xs font-semibold rounded-full">New Feature</span>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="relative z-10 py-24">
      <div class="max-w-5xl mx-auto text-center px-4">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-8 md:p-16 relative overflow-hidden">
          <div class="relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Ready to Supercharge Your Workflow?</h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
              Join thousands of creators using SmartTools AI to build better content, faster.
              Start for free today.
            </p>
            <router-link to="/register" class="inline-block px-8 py-4 bg-white text-blue-600 font-bold text-lg rounded-xl shadow-xl hover:bg-slate-50 transition transform hover:scale-105">
              Create Free Account
            </router-link>
            <p class="mt-4 text-sm text-blue-200 opacity-80">No credit card required for free plan</p>
          </div>
          
          <!-- Decorative circles -->
          <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
          <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-800/20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="relative z-10 border-t border-slate-800 py-12 text-center text-slate-500">
      <p>&copy; 2026 SmartTools AI. All rights reserved.</p>
    </footer>
  </div>
</template>

<script setup lang="ts">
// Logic is simple for the landing page, mainly routing
</script>
