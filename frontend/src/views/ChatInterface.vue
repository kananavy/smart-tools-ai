<template>
  <div class="flex h-screen bg-[#212121] text-gray-200 overflow-hidden font-sans">
    <!-- Sidebar -->
    <div 
        :class="['bg-[#171717] flex-shrink-0 flex flex-col transition-all duration-320 ease-in-out border-r border-white/5', sidebarOpen ? 'w-[260px]' : 'w-0']"
    >
      <!-- New Chat -->
      <div class="p-3">
        <button 
            @click="startNewChat" 
            class="flex items-center justify-between w-full px-3 py-2.5 rounded-lg hover:bg-[#2f2f2f] text-sm font-medium transition-all group"
        >
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 bg-white/10 rounded-full flex items-center justify-center p-1 group-hover:bg-white/20 transition-colors">
                    <bot-icon class="w-4 h-4 text-white" />
                </div>
                <span>New chat</span>
            </div>
            <plus-icon class="w-4 h-4 text-gray-400" />
        </button>
      </div>

      <!-- Plan Status Section -->
      <div class="px-3 py-2 border-b border-white/5 space-y-1">
        <router-link 
            v-if="!isPro"
            to="/pricing-modal" 
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm hover:bg-[#2f2f2f] transition-all font-medium group pro-upgrade-card"
        >
            <div class="relative">
                <div class="w-7 h-7 bg-gradient-to-r from-pink-500/20 to-orange-500/20 rounded-full flex items-center justify-center group-hover:from-pink-500/30 group-hover:to-orange-500/30 transition-colors">
                    <sparkles-icon class="w-3.5 h-3.5 text-pink-400" />
                </div>
                <!-- Animated ring for Free users -->
                <div class="absolute -inset-1 rounded-full border border-pink-500/30 animate-ping opacity-20"></div>
            </div>
            <div class="flex-1">
                <div class="font-semibold text-pink-300">Upgrade to Pro</div>
                <div class="text-[10px] text-gray-500 mt-0.5">Unlock unlimited AI</div>
            </div>
            <div class="px-2 py-1 bg-gradient-to-r from-pink-500 to-orange-500 text-white text-[10px] font-bold rounded-full">
                $9/mo
            </div>
        </router-link>
        <div 
            v-else
            class="flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm bg-gradient-to-r from-violet-500/20 to-blue-500/20 border border-violet-500/30 text-violet-300 font-bold pro-badge"
        >
            <div class="flex items-center gap-2">
                <div class="relative">
                    <sparkles-icon class="w-4 h-4 text-violet-400" />
                    <div class="absolute -inset-1 rounded-full bg-violet-500/20 animate-pulse-slow"></div>
                </div>
                <span class="tracking-wider">PRO</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 bg-violet-500 rounded-full animate-pulse"></div>
                <div class="text-[10px] text-violet-400/80 font-normal">ACTIVE</div>
            </div>
        </div>
      </div>

      <!-- History List -->
      <div class="flex-1 overflow-y-auto custom-scrollbar px-3">
        <div class="mt-4 mb-2 px-3 text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Recent</div>
        <div class="space-y-1">
            <div v-if="loadingHistory" class="px-3 py-2 text-xs text-gray-500 animate-pulse">Loading chats...</div>
            <div 
                v-for="chat in history" 
                :key="chat.id"
                class="group relative"
            >
                <button 
                    @click="loadChat(chat.id)"
                    class="flex items-center gap-3 w-full px-3 py-2 rounded-lg text-sm transition-all text-left hover:bg-[#2f2f2f]"
                    :class="{'bg-[#2f2f2f] text-white': currentChatId === chat.id}"
                >
                    <div class="flex-1 truncate">{{ chat.title || 'New Chat' }}</div>
                </button>
                <!-- Actions -->
                <div class="absolute right-2 top-1/2 -translate-y-1/2 hidden group-hover:flex items-center gap-1 bg-[#2f2f2f] pl-2 rounded-r-lg">
                    <button @click.stop="deleteChat(chat.id)" class="p-1 hover:text-red-400 text-gray-500 transition-colors">
                        <trash-icon class="w-3.5 h-3.5" />
                    </button>
                </div>
            </div>
        </div>
      </div>

      <!-- Footer User -->
      <div class="p-3 mt-auto border-t border-white/5 bg-[#121212]/50 backdrop-blur-md">
         <router-link 
            to="/profile"
            class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-[#2f2f2f] cursor-pointer transition-all border mb-1"
            :class="isPro ? 'border-violet-500/30 hover:border-violet-500/50 bg-gradient-to-r from-violet-900/20 to-blue-900/20' : 'border-transparent hover:border-white/5'"
         >
            <div :class="[
              'w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-white uppercase shadow-lg relative',
              isPro 
                ? 'bg-gradient-to-br from-violet-500 to-blue-600 pro-avatar' 
                : 'bg-gradient-to-br from-gray-700 to-gray-900 free-avatar'
            ]">
               {{ userInitial }}
               <!-- Badge Pro sur l'avatar -->
               <div 
                 v-if="isPro"
                 class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-violet-500 to-blue-500 rounded-full border-2 border-[#212121] flex items-center justify-center z-10"
               >
                 <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 24 24">
                   <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                 </svg>
               </div>
            </div>
            <div class="flex-1 truncate min-w-0">
              <div class="text-sm font-medium truncate" :class="isPro ? 'text-violet-200' : 'text-gray-200'">
                {{ userName || 'My Account' }}
              </div>
              <div v-if="!isPro" class="text-[10px] text-yellow-500 font-bold uppercase tracking-tight mt-0.5">
                <span class="inline-flex items-center gap-1 bg-yellow-500/10 px-2 py-0.5 rounded-full">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Free: {{ remaining }} left
                </span>
              </div>
              <div v-else class="text-[10px] font-bold uppercase tracking-tight mt-0.5">
                <span class="inline-flex items-center gap-1 bg-gradient-to-r from-violet-500/20 to-blue-500/20 px-2 py-0.5 rounded-full">
                  <sparkles-icon class="w-3 h-3 text-violet-400" />
                  <span class="bg-gradient-to-r from-violet-400 to-blue-400 bg-clip-text text-transparent">
                    PRO PLAN
                  </span>
                </span>
              </div>
            </div>
         </router-link>
         <button 
            @click="logout"
            class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-500 hover:text-white hover:bg-[#2f2f2f] rounded-lg transition-all mt-2"
         >
            <log-out-icon class="w-4 h-4" />
            <span>Sign Out</span>
         </button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col relative h-full bg-[#212121] overflow-hidden">
        <!-- Background for Pro Mode -->
        <div v-if="isPro" class="absolute inset-0 pointer-events-none overflow-hidden opacity-5 transition-opacity duration-1000">
            <!-- Effets de particules animées pour Pro -->
            <div class="absolute top-0 left-0 w-full h-full">
                <div v-for="i in 20" :key="i"
                  class="absolute w-[2px] h-[2px] bg-violet-500 rounded-full animate-pulse"
                  :style="{
                    top: Math.random() * 100 + '%',
                    left: Math.random() * 100 + '%',
                    animationDelay: Math.random() * 5 + 's',
                    animationDuration: 3 + Math.random() * 2 + 's'
                  }">
                </div>
            </div>
            <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-gradient-to-r from-violet-600/30 to-blue-600/30 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[50%] h-[50%] bg-gradient-to-r from-blue-600/30 to-violet-600/30 rounded-full blur-[120px] animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <!-- Header -->
        <header class="h-14 flex items-center justify-between px-4 sticky top-0 z-40 bg-[#212121]/80 backdrop-blur-sm border-b border-white/5">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-[#2f2f2f] rounded-lg transition-colors text-gray-400 hover:text-white">
                    <menu-icon class="w-5 h-5" />
                </button>

                <!-- Model Selector -->
                <div class="relative group">
                    <button class="flex items-center gap-2 px-3 py-1.5 rounded-xl hover:bg-[#2f2f2f] text-lg font-semibold text-gray-200 transition-all border border-transparent hover:border-white/5">
                        <span>{{ getModeName(currentMode) }}</span>
                        <svg class="w-4 h-4 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute top-full left-0 mt-2 w-72 bg-[#2f2f2f] border border-white/10 rounded-2xl shadow-2xl overflow-hidden hidden group-hover:block animate-in fade-in slide-in-from-top-2 duration-200">
                        <div class="p-2 space-y-1">
                            <button 
                                v-for="mode in modes" 
                                :key="mode.id"
                                @click="selectMode(mode.id)"
                                class="flex items-center gap-4 w-full p-3 hover:bg-[#383838] rounded-xl text-left transition-all group/item"
                            >
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" :class="mode.id === currentMode ? 'bg-[#19c37d]/10 text-[#19c37d]' : 'bg-gray-700/50 text-gray-400 group-hover/item:text-white'">
                                    <component :is="mode.icon" class="w-6 h-6" />
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-white">{{ mode.name }}</div>
                                    <div class="text-[11px] text-gray-400 leading-tight mt-0.5">{{ mode.description }}</div>
                                </div>
                                <div v-if="mode.id === currentMode" class="text-[#19c37d]">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pro Badge in Header -->
                <div v-if="isPro" class="hidden md:flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-violet-500/10 to-blue-500/10 border border-violet-500/20 rounded-full animate-pulse-slow">
                    <sparkles-icon class="w-3.5 h-3.5 text-violet-400" />
                    <span class="text-xs font-bold bg-gradient-to-r from-violet-400 to-blue-400 bg-clip-text text-transparent tracking-wider">
                        PRO MODE
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Usage Indicator for Free users -->
                <div v-if="!isPro && remaining !== null" class="flex items-center gap-2 px-3 py-1 bg-gray-800/50 rounded-full">
                    <div class="text-xs text-yellow-500 font-bold">{{ remaining }}</div>
                    <div class="text-xs text-gray-400">free uses left</div>
                </div>

                <router-link 
                    v-if="!isPro" 
                    to="/upgrade-payment"
                    class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-violet-600 to-blue-600 text-white text-xs font-bold rounded-lg hover:opacity-90 transition-opacity shadow-lg shadow-violet-500/20"
                >
                    <sparkles-icon class="w-3 h-3" />
                    Upgrade
                </router-link>
                
                <!-- Unlimited Badge for Pro -->
                <div v-if="isPro" class="flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-violet-500/10 to-blue-500/10 rounded-full">
                    <div class="text-xs font-bold text-violet-300">Unlimited</div>
                    <div class="text-xs text-violet-400/70">AI generations</div>
                </div>
            </div>
        </header>

        <!-- Messages Area -->
        <main class="flex-1 overflow-y-auto custom-scrollbar flex flex-col items-center" ref="messagesContainer">
            <div v-if="messages.length === 0" class="flex-1 flex flex-col items-center justify-center p-8 text-center max-w-2xl w-full">
                <div 
                    class="w-14 h-14 rounded-full flex items-center justify-center mb-6 border shadow-lg relative overflow-hidden"
                    :class="isPro 
                      ? 'bg-gradient-to-r from-violet-500/20 to-blue-500/20 border-violet-500/30 pro-welcome-icon' 
                      : 'bg-white/5 border-white/10'"
                >
                    <!-- Effet spécial pour Pro -->
                    <div v-if="isPro" class="absolute inset-0 bg-gradient-to-r from-violet-500/10 to-blue-500/10 animate-pulse-slow"></div>
                    <component :is="currentModeIcon" 
                      :class="[
                        'w-7 h-7 relative z-10',
                        isPro ? 'text-violet-300' : 'text-gray-300'
                      ]" 
                    />
                </div>
                <h2 
                    class="text-2xl md:text-3xl font-bold mb-4 transition-all"
                    :class="isPro 
                      ? 'bg-gradient-to-r from-violet-300 via-blue-300 to-violet-300 bg-clip-text text-transparent font-extrabold animate-gradient' 
                      : 'text-white'"
                >
                    {{ isPro ? 'Welcome, Pro Member! 🚀' : 'What can I help you with?' }}
                </h2>
                
                <p v-if="isPro" class="text-violet-300/80 mb-8 text-lg max-w-md">
                    Unlimited AI power with priority processing and advanced features
                </p>
                <div v-else class="mb-8">
                    <p class="text-gray-500 mb-2">You have <span class="text-yellow-500 font-bold">{{ remaining }}</span> free generations left</p>
                    <div class="w-48 h-1.5 bg-gray-800 rounded-full overflow-hidden mx-auto">
                        <div class="h-full bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full" :style="{ width: `${((remaining ?? 0) / 40) * 100}%` }"></div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full max-w-2xl">
                    <button @click="prompt = 'Help me debug this code'" class="p-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl text-left transition-all hover:border-white/10 active:scale-[0.98]">
                        <div class="text-sm font-medium text-gray-200">Help me debug this code</div>
                        <div class="text-xs text-gray-500 mt-1">Paste your snippet below</div>
                    </button>
                    <button @click="prompt = 'Summarize this long article'" class="p-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl text-left transition-all hover:border-white/10 active:scale-[0.98]">
                        <div class="text-sm font-medium text-gray-200">Summarize this long article</div>
                        <div class="text-xs text-gray-500 mt-1">Extract key points instantly</div>
                    </button>
                </div>

                <!-- Pro Features Showcase -->
                <div v-if="isPro" class="mt-12 w-full max-w-2xl">
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-violet-300 mb-2">Pro Features Enabled</h3>
                        <p class="text-sm text-violet-400/70">Experience the full power of SmartTools</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="p-3 bg-gradient-to-br from-violet-500/10 to-blue-500/10 border border-violet-500/20 rounded-xl text-center">
                            <div class="text-2xl font-bold text-violet-400">∞</div>
                            <div class="text-xs text-violet-300/80 mt-1">Unlimited Uses</div>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-violet-500/10 to-blue-500/10 border border-violet-500/20 rounded-xl text-center">
                            <div class="text-2xl font-bold text-violet-400">⚡</div>
                            <div class="text-xs text-violet-300/80 mt-1">Priority Speed</div>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-violet-500/10 to-blue-500/10 border border-violet-500/20 rounded-xl text-center">
                            <div class="text-2xl font-bold text-violet-400">🛡️</div>
                            <div class="text-xs text-violet-300/80 mt-1">Advanced AI</div>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-violet-500/10 to-blue-500/10 border border-violet-500/20 rounded-xl text-center">
                            <div class="text-2xl font-bold text-violet-400">📁</div>
                            <div class="text-xs text-violet-300/80 mt-1">Full History</div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="w-full max-w-3xl flex flex-col pb-48 pt-4">
                <div 
                    v-for="(msg, index) in messages" 
                    :key="index"
                    class="group w-full mb-8 relative px-4 sm:px-0"
                >
                    <div class="flex gap-4 md:gap-6 text-base">
                        <!-- Avatar Container -->
                        <div class="flex-shrink-0 mt-0.5">
                            <div 
                                class="w-7 h-7 rounded-full flex items-center justify-center text-white" 
                                :class="msg.role === 'assistant' ? 'bg-[#19c37d]' : 'bg-gray-600'"
                            >
                                <bot-icon v-if="msg.role === 'assistant'" class="w-4 h-4" />
                                <user v-else class="w-4 h-4" />
                            </div>
                        </div>
                        
                        <!-- Text Content -->
                        <div class="relative flex-1 space-y-2 overflow-hidden">
                            <div v-if="msg.role === 'user'" class="font-bold text-gray-100 mb-1">You</div>
                            <div v-else class="font-bold text-gray-100 mb-1 flex items-center gap-2">
                                SmartTools AI
                                <!-- Pro Badge for AI responses -->
                                <span v-if="isPro" class="text-[10px] bg-gradient-to-r from-violet-500/20 to-blue-500/20 text-violet-400 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">
                                    PRO
                                </span>
                            </div>

                            <div 
                                v-if="msg.role === 'assistant'" 
                                class="prose prose-invert max-w-none text-gray-200 leading-[1.75] font-normal" 
                                v-html="renderMarkdown(msg.content)"
                            ></div>
                            <div v-else class="whitespace-pre-wrap leading-[1.75] text-gray-200 font-normal">{{ msg.content }}</div>

                            <!-- Pro Response Indicator -->
                            <div v-if="isPro && msg.role === 'assistant'" class="mt-2 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="flex items-center gap-1.5 text-[10px] text-violet-400/70 font-semibold uppercase tracking-wide">
                                    <sparkles-icon class="w-3 h-3" />
                                    <span>PRO RESPONSE</span>
                                </div>
                                <div class="text-[10px] text-gray-500">• Priority Processing</div>
                            </div>

                            <!-- Message Actions -->
                            <div v-if="msg.role === 'assistant' && !loading" class="mt-2 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button 
                                    @click="copyContent(msg.content, 'msg-' + index)" 
                                    class="p-1.5 hover:bg-white/5 rounded-lg transition-all flex items-center gap-1.5 text-xs font-medium"
                                    :class="copiedId === 'msg-' + index ? 'text-emerald-500' : 'text-gray-500 hover:text-gray-300'"
                                    title="Copy response"
                                >
                                    <check-icon v-if="copiedId === 'msg-' + index" class="w-3.5 h-3.5" />
                                    <copy-icon v-else class="w-3.5 h-3.5" />
                                    <span>{{ copiedId === 'msg-' + index ? 'Copied' : 'Copy' }}</span>
                                </button>
                            </div>

                            <!-- Image Attachments -->
                            <div v-if="msg.imageUrl" class="mt-4 first:mt-0">
                                <img :src="msg.imageUrl" class="rounded-2xl max-h-[400px] w-auto border border-white/10 shadow-2xl" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- Thinking Indicator -->
            <div v-if="loading && messages.length > 0" class="w-full px-4 sm:px-0 flex gap-4 md:gap-6 mb-8 animate-fade-in">
                <div class="flex-shrink-0 mt-0.5">
                    <div class="w-7 h-7 rounded-full bg-[#19c37d] flex items-center justify-center text-white relative">
                         <bot-icon class="w-4 h-4" />
                         <div v-if="isPro" class="absolute -inset-1 rounded-full border border-violet-500/30 animate-ping"></div>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="text-sm font-semibold text-gray-400">Thinking</span>
                        <div class="w-1 h-1 bg-gray-500 rounded-full animate-bounce"></div>
                        <div class="w-1 h-1 bg-gray-500 rounded-full animate-bounce delay-150"></div>
                        <div class="w-1 h-1 bg-gray-500 rounded-full animate-bounce delay-300"></div>
                    </div>
                     <div v-if="isPro" class="text-xs text-violet-400/70 font-medium">
                        Processing with Pro priority...
                    </div>
                </div>
            </div>
        </main>

        <!-- Input Section -->
        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-[#212121] via-[#212121] to-transparent pt-12 pb-5">
            <div class="max-w-3xl mx-auto px-4 relative">
                
                <!-- Input Container with Plan Indicator -->
                <div class="relative">
                    <!-- Plan Indicator -->
                    <div v-if="isPro" class="absolute -top-7 left-0">
                        <div class="flex items-center gap-2 text-xs text-violet-400/70 font-medium">
                            <sparkles-icon class="w-3.5 h-3.5" />
                            <span>Pro Mode Active • Unlimited AI</span>
                        </div>
                    </div>
                    
                    <!-- Pill Container -->
                    <div :class="[
                        'relative rounded-[26px] py-2 px-3 flex items-center gap-2 border transition-all shadow-xl',
                        isPro 
                          ? 'bg-[#2a2a2a] border-violet-500/20 focus-within:border-violet-500/40' 
                          : 'bg-[#2f2f2f] border-white/5 focus-within:border-white/10'
                    ]">
                        <!-- File Inputs Hidden -->
                        <input type="file" ref="fileInput" class="hidden" accept="image/*" @change="handleFileSelect" />
                        <input type="file" ref="cameraInput" class="hidden" accept="image/*" capture="environment" @change="handleFileSelect" />
                        
                        <!-- Left Side Controls (Attachments) -->
                        <div class="flex items-center gap-0.5">
                            <button 
                                @click="fileInput?.click()" 
                                class="p-2 text-gray-400 hover:text-white hover:bg-white/5 rounded-full transition-all"
                                title="Upload Image"
                            >
                                <paperclip-icon class="w-5 h-5" />
                            </button>
                            <button 
                                @click="cameraInput?.click()" 
                                class="p-2 text-gray-400 hover:text-white hover:bg-white/5 rounded-full transition-all"
                                title="Take Photo"
                            >
                                <camera-icon class="w-5 h-5" />
                            </button>
                        </div>

                        <!-- Text Area -->
                        <div class="flex-1 flex flex-col justify-center min-h-[40px]">
                            <!-- Attachment Preview (Small thumb) -->
                            <div v-if="filePreview" class="absolute bottom-full mb-3 left-4">
                                <div class="relative group">
                                    <img :src="filePreview" class="w-14 h-14 rounded-xl object-cover border border-white/10 shadow-2xl" />
                                    <button @click="clearFile" class="absolute -top-2 -right-2 bg-[#404040] text-gray-300 rounded-full p-1 border border-white/10 hover:text-white shadow-lg">
                                        <x-icon class="w-3 h-3" />
                                    </button>
                                </div>
                            </div>
                            <textarea 
                                ref="textareaRef"
                                v-model="prompt" 
                                @keydown.enter.exact.prevent="sendMessage"
                                @input="adjustTextareaHeight"
                                rows="1" 
                                class="w-full max-h-[25vh] bg-transparent border-0 focus:ring-0 resize-none text-white placeholder-gray-500 py-2 text-[16px] leading-relaxed custom-scrollbar overflow-y-auto"
                                :placeholder="isPro ? 'Message SmartTools Pro AI...' : 'Message SmartTools AI...'"
                                style="min-height: 24px; height: 24px;"
                            ></textarea>
                        </div>

                        <!-- Right Side Controls (Mic & Send) -->
                        <div class="flex items-center gap-1.5 self-end mb-1">
                            <button 
                                @click="toggleSpeech" 
                                class="p-2 rounded-full transition-all"
                                :class="isListening ? 'text-red-500 bg-red-500/10 animate-pulse' : 'text-gray-400 hover:text-white hover:bg-white/5'"
                                title="Voice Input"
                            >
                                <mic-off-icon v-if="isListening" class="w-5 h-5" />
                                <mic-icon v-else class="w-5 h-5" />
                            </button>
                            <button 
                                @click="sendMessage"
                                :disabled="loading || (!prompt && !filePreview)"
                                class="p-2 rounded-full transition-all"
                                :class="[
                                    (prompt || filePreview) && !loading 
                                      ? isPro
                                        ? 'bg-gradient-to-r from-violet-600 to-blue-600 text-white hover:from-violet-700 hover:to-blue-700'
                                        : 'bg-white text-black hover:bg-gray-200'
                                      : 'text-gray-600 bg-white/5 cursor-not-allowed'
                                ]"
                            >
                                <arrow-up-icon class="w-5 h-5" :class="{'opacity-50': loading}" />
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between text-[11px] text-gray-500 tracking-wide font-medium px-2">
                    <div>
                        SmartTools AI can make mistakes. Check important info.
                    </div>
                    <div v-if="!isPro && remaining !== null" class="text-yellow-500/80 font-bold">
                        {{ remaining }} free uses remaining
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick, computed, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { marked } from 'marked';
import hljs from 'highlight.js';
import 'highlight.js/styles/github-dark.css';
import api from '../services/api';
import { 
  Plus as PlusIcon,
  MessageSquare as MessageSquareIcon, 
  Trash as TrashIcon,
  Menu as MenuIcon,
  Bot as BotIcon,
  Paperclip as PaperclipIcon,
  Mic as MicIcon,
  MicOff as MicOffIcon,
  ArrowUp as ArrowUpIcon,
  X as XIcon,
  Image as ImageIcon,
  Sparkles as SparklesIcon,
  LogOut as LogOutIcon,
  Copy as CopyIcon,
  Check as CheckIcon,
  User,
  Camera as CameraIcon
} from 'lucide-vue-next';
import { useAuthStore } from '../stores/auth';
import { useSubscriptionStore } from '../stores/subscription';

// --- State & Stores ---
const authStore = useAuthStore();
const subscriptionStore = useSubscriptionStore();
const router = useRouter();
const route = useRoute();

const sidebarOpen = ref(true);
const prompt = ref('');
const loading = ref(false);
const loadingHistory = ref(false);
const messages = ref<any[]>([]);
const history = ref<any[]>([]);
const currentChatId = ref<number | null>(null);
const fileInput = ref<HTMLInputElement | null>(null);
const cameraInput = ref<HTMLInputElement | null>(null);
const filePreview = ref<string | null>(null);
const messagesContainer = ref<HTMLElement | null>(null);
const textareaRef = ref<HTMLTextAreaElement | null>(null);
const copiedId = ref<string | null>(null);
const isListening = ref(false);

// --- Computed from Stores ---
const userName = computed(() => authStore.user?.name || 'User');
const remaining = computed(() => subscriptionStore.remainingUses);
const isPro = computed(() => subscriptionStore.plan === 'pro');

const userInitial = computed(() => userName.value.charAt(0).toUpperCase());

// Modes (ChatGPT Selection Style)
const currentMode = ref('text-generator');
const modes = [
  { 
    id: 'text-generator', 
    name: 'Smart Chat', 
    description: 'Our most capable model for reasoning and creativity.',
    icon: MessageSquareIcon 
  },
  { 
    id: 'image-analyzer', 
    name: 'Vision Mode', 
    description: 'Understand and analyze images in detail.',
    icon: ImageIcon 
  },
  { 
    id: 'humanizer', 
    name: 'Humanizer', 
    description: 'Refine text to sound more natural and engaging.',
    icon: User 
  },
];

// --- Methods ---
const getModeName = (id: string) => modes.find(m => m.id === id)?.name || 'Chat';
const selectMode = (id: string) => {
    currentMode.value = id;
};
const currentModeIcon = computed(() => modes.find(m => m.id === currentMode.value)?.icon || BotIcon);

// --- Speech Recognition ---
let recognition: any = null;
if (typeof window !== 'undefined' && ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window)) {
    const SpeechRecognition = (window as any).SpeechRecognition || (window as any).webkitSpeechRecognition;
    recognition = new SpeechRecognition();
    recognition.continuous = false;
    recognition.lang = 'en-US';
    recognition.interimResults = true;

    recognition.onresult = (event: any) => {
        const transcript = Array.from(event.results)
            .map((result: any) => result[0])
            .map((result: any) => result.transcript)
            .join('');
        prompt.value = transcript;
    };
    
    recognition.onend = () => isListening.value = false;
}

const toggleSpeech = () => {
    if (!recognition) return alert('Speech recognition not supported.');
    if (isListening.value) {
        recognition.stop();
    } else {
        recognition.start();
        isListening.value = true;
    }
};

// --- API ---
const loadHistory = async () => {
    loadingHistory.value = true;
    try {
        const res = await api.get('/conversations');
        history.value = res.data;
    } catch (e) { console.error(e) }
    finally { loadingHistory.value = false; }
};

const loadChat = async (id: number) => {
    currentChatId.value = id;
    loading.value = true;
    messages.value = [];
    try {
        const res = await api.get(`/conversations/${id}`);
        res.data.tool_requests.forEach((req: any) => {
             let input = req.input_data;
             let output = req.output_data;

             // Handle JSON strings if they come as strings
             if (typeof input === 'string') {
                 try { input = JSON.parse(input); } catch(e) {}
             }
             if (typeof output === 'string') {
                 try { output = JSON.parse(output); } catch(e) {}
             }

             // Extract content
             const inputContent = input?.prompt || (typeof input === 'string' ? input : JSON.stringify(input));
             const outputContent = output?.result || (typeof output === 'string' ? output : JSON.stringify(output));

             messages.value.push({ role: 'user', content: inputContent });
             messages.value.push({ role: 'assistant', content: outputContent });
        });
        scrollToBottom();
    } catch (e) { console.error(e) }
    finally { loading.value = false; }
};

const deleteChat = async (id: number) => {
    if (!confirm('Delete this chat?')) return;
    try {
        await api.delete(`/conversations/${id}`);
        history.value = history.value.filter(h => h.id !== id);
        if (currentChatId.value === id) startNewChat();
    } catch (e) { alert('Failed to delete'); }
};

const startNewChat = () => {
    currentChatId.value = null;
    messages.value = [];
    prompt.value = '';
    router.push('/chat/text-generator');
};

const logout = async () => {
  await authStore.logout();
  router.push('/login');
};

const sendMessage = async () => {
    if ((!prompt.value.trim() && !filePreview.value) || loading.value) return;

    // Check usage limits for free users
    if (remaining.value === 0) {
        if (confirm('You have reached your free generation limit. Upgrade to Pro for unlimited access!')) {
            router.push('/pricing-modal');
        }
        return;
    }

    const text = prompt.value;
    const image = filePreview.value;
    
    messages.value.push({ role: 'user', content: text, imageUrl: image });
    prompt.value = '';
    clearFile();
    await scrollToBottom();

    loading.value = true;
    try {
        const res = await api.post(`/tools/${currentMode.value}/generate`, {
            prompt: text,
            image: image,
            conversation_id: currentChatId.value
        });
        
        messages.value.push({ role: 'assistant', content: res.data.result });
        
        // Update store with new remaining count
        if (typeof res.data.remaining !== 'undefined') {
          subscriptionStore.updateRemaining(res.data.remaining);
        }

        if (!currentChatId.value && res.data.conversation_id) {
            currentChatId.value = res.data.conversation_id;
            loadHistory();
        }
    } catch (err: any) {
        messages.value.push({ role: 'assistant', content: `**Error:** ${err.response?.data?.message || 'Something went wrong.'}` });
    } finally {
        loading.value = false;
        scrollToBottom();
    }
};

// --- Helpers ---
const clearFile = () => { if(fileInput.value) fileInput.value.value = ''; filePreview.value = null; };
const handleFileSelect = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (ev) => filePreview.value = ev.target?.result as string;
    reader.readAsDataURL(file);
    currentMode.value = 'image-analyzer';
};

const scrollToBottom = async () => {
    await nextTick();
    if (messagesContainer.value) messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
};

// --- UX Helpers ---
const adjustTextareaHeight = () => {
    if (!textareaRef.value) return;
    textareaRef.value.style.height = '24px';
    const scrollHeight = textareaRef.value.scrollHeight;
    textareaRef.value.style.height = Math.min(scrollHeight, window.innerHeight * 0.25) + 'px';
};

const copyContent = (text: string, id: string) => {
    navigator.clipboard.writeText(text);
    copiedId.value = id;
    setTimeout(() => {
        if (copiedId.value === id) copiedId.value = null;
    }, 2000);
};

// Global helper for code block copying to avoid attribute issues
if (typeof window !== 'undefined') {
    (window as any).copyCode = (btn: HTMLElement, code: string) => {
        navigator.clipboard.writeText(atob(code));
        const original = btn.innerHTML;
        btn.classList.add('text-emerald-500');
        btn.innerHTML = `
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
            Copied
        `;
        setTimeout(() => {
            btn.classList.remove('text-emerald-500');
            btn.innerHTML = original;
        }, 2000);
    };
}

// Configure marked with highlight.js and custom code blocks
const renderer = new marked.Renderer();
renderer.code = ({ text: code, lang }: any) => {
    const validLang = lang && hljs.getLanguage(lang) ? lang : 'plaintext';
    const highlighted = hljs.highlight(code, { language: validLang }).value;
    const encodedCode = btoa(unescape(encodeURIComponent(code)));
    
    return `
        <div class="my-4 rounded-lg overflow-hidden border border-white/10 bg-[#0d1117]">
            <div class="flex items-center justify-between px-4 py-2 bg-[#161b22] border-b border-white/5 text-[11px] text-gray-400 font-sans uppercase tracking-wider">
                <span>${validLang}</span>
                <button onclick="window.copyCode(this, '${encodedCode}')" class="hover:text-white transition-colors flex items-center gap-1.5 focus:outline-none">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"></path></svg>
                    Copy
                </button>
            </div>
            <pre class="!m-0 !p-4 !bg-transparent"><code class="hljs language-${validLang}">${highlighted}</code></pre>
        </div>
    `;
};

marked.setOptions({
    renderer,
    breaks: true,
    gfm: true
});

const renderMarkdown = (text: string) => {
    try { 
        return marked.parse(text) as string; 
    } catch (e) { 
        console.error('Markdown error:', e);
        return text; 
    }
};

watch(prompt, () => {
    nextTick(() => adjustTextareaHeight());
});

// --- Init ---
onMounted(async () => {
   loadHistory();
   if (window.innerWidth < 768) sidebarOpen.value = false;
   
   // Sync with route if needed
   if (route.params.slug && modes.some(m => m.id === route.params.slug)) {
       currentMode.value = route.params.slug as string;
   }

   // Fetch data via stores
   subscriptionStore.fetchSubscription();
   if (!authStore.user) authStore.fetchUser();

   // Handle welcome message for new Pro users
   if (route.query.plan_upgraded === 'pro') {
       if (messages.value.length === 0) {
           messages.value.push({
               role: 'assistant',
               content: `🎉 **Welcome to SmartTools Pro!** Your account has been upgraded successfully. You now have:\n\n` +
                       `• **Unlimited AI generations**\n` +
                       `• **Priority processing** ⚡\n` +
                       `• **Advanced AI models** (Llama 3.3 70B)\n\n` +
                       `Enjoy your creative freedom!`
           });
       }
       router.replace({ query: {} });
   }
});
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.1);
}

/* Animation de gradient pour le texte Pro */
.animate-gradient {
  background-size: 200% auto;
  animation: gradient 3s ease infinite;
}

@keyframes gradient {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

/* Animation de pulse pour les éléments Pro */
@keyframes subtle-pulse {
  0%, 100% { opacity: 0.7; transform: scale(1); }
  50% { opacity: 1; transform: scale(1.02); }
}

.animate-pulse-slow {
  animation: subtle-pulse 2s ease-in-out infinite;
}

/* Badge Pro avec effet de brillance */
.pro-badge {
  position: relative;
  overflow: hidden;
}

.pro-badge::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: linear-gradient(
    to right,
    transparent,
    rgba(255, 255, 255, 0.1),
    transparent
  );
  transform: rotate(30deg);
  animation: shine 3s infinite;
}

@keyframes shine {
  0% { transform: translateX(-100%) rotate(30deg); }
  100% { transform: translateX(100%) rotate(30deg); }
}

/* Avatar Pro avec effet de halo */
.pro-avatar {
  position: relative;
}

.pro-avatar::after {
  content: '';
  position: absolute;
  inset: -2px;
  background: linear-gradient(45deg, #8b5cf6, #3b82f6, #8b5cf6);
  border-radius: 50%;
  z-index: -1;
  opacity: 0.5;
  animation: rotate 3s linear infinite;
}

@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Icône de bienvenue Pro */
.pro-welcome-icon {
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

/* Card d'upgrade améliorée */
.pro-upgrade-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px -5px rgba(244, 114, 182, 0.1);
}

/* ChatGPT markdown style overrides */
:deep(.prose) {
  --tw-prose-body: #ececf1;
  --tw-prose-headings: #fff;
  --tw-prose-links: #19c37d;
  --tw-prose-bold: #fff;
  --tw-prose-pre-bg: #000;
  --tw-prose-code: #ececf1;
}

:deep(.prose p) {
  margin-top: 1.25em;
  margin-bottom: 1.25em;
}

:deep(.prose pre) {
  padding: 0;
  border-radius: 0.5rem;
  overflow: hidden;
}

:deep(.prose code) {
  font-weight: 500;
  background: rgba(255,255,255,0.1);
  padding: 0.2em 0.4em;
  border-radius: 3px;
}

:deep(.prose pre code) {
  background: transparent;
  padding: 1.5em;
  display: block;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .sidebar-open {
    position: fixed;
    z-index: 50;
    height: 100vh;
  }
}
</style>