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

      <!-- Navigation Links -->
      <div class="px-3 py-2 border-b border-white/5 space-y-1">
        <router-link 
            v-if="remaining !== -1"
            to="/dashboard/pricing" 
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-pink-400 hover:bg-pink-500/10 transition-all font-medium"
        >
            <sparkles-icon class="w-4 h-4" />
            <span>Upgrade to Pro</span>
        </router-link>
        <div 
            v-else
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm bg-gradient-to-r from-violet-500/10 to-blue-500/10 border border-violet-500/20 text-violet-400 font-bold"
        >
            <sparkles-icon class="w-4 h-4" />
            <span>Pro Member</span>
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
            to="/dashboard/profile"
            class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-[#2f2f2f] cursor-pointer transition-all border border-transparent hover:border-white/5 mb-1"
         >
            <div :class="['w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white uppercase shadow-lg', remaining === -1 ? 'bg-gradient-to-br from-violet-500 to-blue-600' : 'bg-gradient-to-br from-indigo-500 to-purple-600']">
               {{ userInitial }}
            </div>
            <div class="flex-1 truncate">
                <div class="text-sm font-medium truncate" :class="remaining === -1 ? 'text-violet-100' : 'text-gray-200'">My Account</div>
                <div v-if="remaining !== -1" class="text-[10px] text-yellow-500 font-bold uppercase tracking-tight">Free: {{ remaining }} left</div>
                <div v-else class="text-[10px] bg-gradient-to-r from-violet-400 to-blue-400 bg-clip-text text-transparent font-bold uppercase tracking-tight">Pro Plan active</div>
            </div>
         </router-link>
         <button 
            @click="logout"
            class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-500 hover:text-white hover:bg-[#2f2f2f] rounded-lg transition-all"
         >
            <log-out-icon class="w-4 h-4" />
            <span>Sign Out</span>
         </button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col relative h-full bg-[#212121] overflow-hidden">
        <!-- Background for Pro Mode -->
        <div v-if="remaining === -1" class="absolute inset-0 pointer-events-none overflow-hidden opacity-10 transition-opacity duration-1000">
            <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] bg-violet-600 rounded-full blur-[120px]"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[50%] h-[50%] bg-blue-600 rounded-full blur-[120px]"></div>
        </div>

        <!-- Header -->
        <header class="h-14 flex items-center justify-between px-4 sticky top-0 z-40 bg-[#212121]/80 backdrop-blur-sm">
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
            </div>

            <div class="flex items-center gap-2">
                <!-- User UI actions like share etc could go here -->
            </div>
        </header>

        <!-- Messages Area -->
        <main class="flex-1 overflow-y-auto custom-scrollbar flex flex-col items-center" ref="messagesContainer">
            <div v-if="messages.length === 0" class="flex-1 flex flex-col items-center justify-center p-8 text-center max-w-2xl w-full">
                <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center mb-6 border border-white/10">
                    <component :is="currentModeIcon" class="w-6 h-6 text-gray-300" />
                </div>
                <h2 
                    class="text-2xl font-bold text-white mb-8 transition-all"
                    :class="{'bg-gradient-to-r from-violet-200 to-blue-200 bg-clip-text text-transparent font-extrabold': remaining === -1}"
                >
                    What can I help you with?
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
                    <button @click="prompt = 'Help me debug this code'" class="p-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl text-left transition-all hover:border-white/10 active:scale-[0.98]">
                        <div class="text-sm font-medium text-gray-200">Help me debug this code</div>
                        <div class="text-xs text-gray-500 mt-1">Paste your snippet below</div>
                    </button>
                    <button @click="prompt = 'Summarize this long article'" class="p-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl text-left transition-all hover:border-white/10 active:scale-[0.98]">
                        <div class="text-sm font-medium text-gray-200">Summarize this long article</div>
                        <div class="text-xs text-gray-500 mt-1">Extract key points instantly</div>
                    </button>
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
                            <div v-else class="font-bold text-gray-100 mb-1">SmartTools AI</div>

                            <div 
                                v-if="msg.role === 'assistant'" 
                                class="prose prose-invert max-w-none text-gray-200 leading-[1.75] font-normal" 
                                v-html="renderMarkdown(msg.content)"
                            ></div>
                            <div v-else class="whitespace-pre-wrap leading-[1.75] text-gray-200 font-normal">{{ msg.content }}</div>

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

                <!-- Loading State -->
                <div v-if="loading" class="w-full px-4 sm:px-0 flex gap-4 md:gap-6">
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="w-7 h-7 rounded-full bg-[#19c37d] flex items-center justify-center text-white">
                            <bot-icon class="w-4 h-4" />
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 mt-2">
                        <div class="w-1.5 h-1.5 bg-gray-500 rounded-full animate-bounce"></div>
                        <div class="w-1.5 h-1.5 bg-gray-500 rounded-full animate-bounce delay-150"></div>
                        <div class="w-1.5 h-1.5 bg-gray-500 rounded-full animate-bounce delay-300"></div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Input Section -->
        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-[#212121] via-[#212121] to-transparent pt-12 pb-5">
            <div class="max-w-3xl mx-auto px-4 relative">
                
                <!-- Pill Container -->
                <div class="relative bg-[#2f2f2f] rounded-[26px] p-2 pr-3 pl-4 flex items-end gap-2 border border-white/5 focus-within:border-white/10 transition-all shadow-xl">
                    <!-- File Input Hidden -->
                    <input type="file" ref="fileInput" class="hidden" accept="image/*" @change="handleFileSelect" />
                    
                    <!-- Paperclip -->
                    <button 
                        @click="fileInput?.click()" 
                        class="mb-1.5 p-1.5 text-gray-400 hover:text-white hover:bg-white/5 rounded-full transition-all"
                    >
                        <paperclip-icon class="w-5 h-5" />
                    </button>

                    <!-- Text Area -->
                    <div class="flex-1 flex flex-col pt-2 min-h-[40px]">
                        <!-- Attachment Preview -->
                        <div v-if="filePreview" class="mb-3 px-1 flex">
                            <div class="relative group">
                                <img :src="filePreview" class="w-12 h-12 rounded-lg object-cover border border-white/10 shadow-md" />
                                <button @click="clearFile" class="absolute -top-1.5 -right-1.5 bg-[#404040] text-gray-300 rounded-full p-0.5 border border-white/10 hover:text-white shadow-lg">
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
                            class="w-full max-h-[25vh] bg-transparent border-0 focus:ring-0 resize-none text-white placeholder-gray-500 py-1 text-[16px] leading-relaxed custom-scrollbar overflow-y-auto"
                            placeholder="Message SmartTools AI..."
                            style="min-height: 24px; height: 24px;"
                        ></textarea>
                    </div>

                    <!-- Right Controls -->
                    <div class="flex items-center gap-2 mb-1">
                        <button v-if="!prompt && !isListening" @click="toggleSpeech" class="p-2 text-gray-400 hover:text-white rounded-full hover:bg-white/5">
                            <mic-icon class="w-5 h-5" />
                        </button>
                        <button v-if="isListening" @click="toggleSpeech" class="p-2 text-red-500 animate-pulse rounded-full hover:bg-red-500/10">
                            <mic-off-icon class="w-5 h-5" />
                        </button>
                        <button 
                            @click="sendMessage"
                            :disabled="loading || (!prompt && !filePreview)"
                            class="p-2 rounded-full transition-all"
                            :class="(prompt || filePreview) && !loading ? 'bg-white text-black hover:bg-gray-200' : 'text-gray-600 bg-white/5 cursor-not-allowed'"
                        >
                            <arrow-up-icon class="w-5 h-5" :class="{'opacity-50': loading}" />
                        </button>
                    </div>
                </div>

                <div class="mt-3 text-[11px] text-gray-500 text-center tracking-wide font-medium">
                    SmartTools AI can make mistakes. Check important info.
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
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
  User
} from 'lucide-vue-next';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

// --- State ---
const sidebarOpen = ref(true);
const prompt = ref('');
const loading = ref(false);
const loadingHistory = ref(false);
const remaining = ref<number | null>(null);
const messages = ref<any[]>([]);
const history = ref<any[]>([]);
const currentChatId = ref<number | null>(null);
const fileInput = ref<HTMLInputElement | null>(null);
const filePreview = ref<string | null>(null);
const messagesContainer = ref<HTMLElement | null>(null);
const textareaRef = ref<HTMLTextAreaElement | null>(null);
const copiedId = ref<string | null>(null);
const isListening = ref(false);

const authStore = useAuthStore();
const router = useRouter();

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

const route = useRoute();

// --- Computed ---
const userInitial = computed(() => 'U'); // Placeholder or from user object

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
            router.push('/dashboard/pricing');
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
        
        if (typeof res.data.remaining !== 'undefined') remaining.value = res.data.remaining;

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

   try {
       const sub = await api.get('/subscription');
       if (sub.data.plan_type === 'pro') {
           remaining.value = -1;
       } else {
            remaining.value = Math.max(0, 5 - (sub.data.usage_count || 0)); 
       }
   } catch (e) {}
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
</style>
