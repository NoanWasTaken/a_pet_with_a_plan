{{-- Chatbot Widget --}}
<div class="fixed bottom-5 right-5" style="position: fixed !important; bottom: 20px !important; right: 20px !important; z-index: 9999 !important;" x-data="chatbot()" @click.away="isOpen = false">
    {{-- Bouton du chatbot --}}
    <button 
        @click="toggleChat()"
        style="width: 64px !important; height: 64px !important; border-radius: 50% !important; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%) !important; color: white !important; border: none !important; cursor: pointer !important; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important; display: flex !important; align-items: center !important; justify-content: center !important; font-size: 1.5rem !important;"
        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center text-2xl transform hover:scale-110"
        :class="{ 'bg-gradient-to-br from-red-500 to-red-600': isOpen }"
    >
        <span x-text="isOpen ? '×' : '🩺'"></span>
    </button>

    {{-- Fenêtre du chatbot --}}
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4"
        class="absolute bottom-20 right-0 w-80 h-96 bg-white rounded-lg shadow-2xl border border-gray-200 flex flex-col overflow-hidden"
    >
        {{-- En-tête --}}
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 flex items-center justify-between">
            <h3 class="font-semibold text-lg">🩺 Assistant Vétérinaire</h3>
            <button @click="isOpen = false" class="text-white hover:text-gray-200 text-xl leading-none">
                ×
            </button>
        </div>

        {{-- Messages --}}
        <div class="flex-1 p-4 overflow-y-auto bg-gray-50" id="chatMessages">
            <div class="space-y-3">
                {{-- Message de bienvenue --}}
                <div class="flex">
                    <div class="bg-white rounded-lg p-3 max-w-xs shadow-sm border">
                        <p class="text-sm text-gray-700">
                            Bonjour ! Je suis votre assistant vétérinaire. Comment puis-je vous aider avec votre animal aujourd'hui ?
                        </p>
                        <span class="text-xs text-gray-500 mt-1 block">{{ now()->format('H:i') }}</span>
                    </div>
                </div>

                {{-- Messages dynamiques seront ajoutés ici --}}
                <template x-for="message in messages" :key="message.id">
                    <div class="flex" :class="message.type === 'user' ? 'justify-end' : ''">
                        <div 
                            class="rounded-lg p-3 max-w-xs shadow-sm"
                            :class="message.type === 'user' ? 
                                'bg-gradient-to-r from-blue-500 to-purple-600 text-white' : 
                                'bg-white text-gray-700 border'"
                        >
                            <p class="text-sm" x-text="message.content"></p>
                            <span class="text-xs mt-1 block" 
                                  :class="message.type === 'user' ? 'text-blue-100' : 'text-gray-500'"
                                  x-text="message.time">
                            </span>
                        </div>
                    </div>
                </template>

                {{-- Indicateur de frappe --}}
                <div x-show="isTyping" class="flex">
                    <div class="bg-white rounded-lg p-3 shadow-sm border">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Zone de saisie --}}
        <form @submit.prevent="sendMessage()" class="p-4 border-t bg-white">
            <div class="flex space-x-2">
                <input 
                    type="text"
                    x-model="newMessage"
                    placeholder="Décrivez le problème de votre animal..."
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    maxlength="500"
                    :disabled="isTyping"
                >
                <button 
                    type="submit"
                    :disabled="!newMessage.trim() || isTyping"
                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white rounded-full flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function chatbot() {
    return {
        isOpen: false,
        isTyping: false,
        newMessage: '',
        messages: [],
        sessionId: null,

        init() {
            this.initSession();
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.$nextTick(() => {
                    const inputElement = this.$el.querySelector('input[type="text"]');
                    if (inputElement) {
                        inputElement.focus();
                    }
                });
            }
        },

        async initSession() {
            try {
                const response = await fetch('/chatbot/init', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                this.sessionId = data.session_id;
                
                // Charger l'historique des messages
                data.messages.forEach(msg => {
                    this.messages.push({
                        id: Date.now() + Math.random(),
                        type: msg.type,
                        content: msg.message,
                        time: new Date(msg.created_at).toLocaleTimeString('fr-FR', { 
                            hour: '2-digit', 
                            minute: '2-digit' 
                        })
                    });
                });
                
            } catch (error) {
                console.error('Erreur lors de l\'initialisation du chat:', error);
            }
        },

        async sendMessage() {
            if (!this.newMessage.trim() || this.isTyping) return;
            
            const message = this.newMessage.trim();
            this.newMessage = '';
            
            // Ajouter le message de l'utilisateur
            this.messages.push({
                id: Date.now(),
                type: 'user',
                content: message,
                time: new Date().toLocaleTimeString('fr-FR', { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                })
            });
            
            this.isTyping = true;
            this.scrollToBottom();
            
            try {
                const response = await fetch('/chatbot/message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        session_id: this.sessionId,
                        message: message
                    })
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const data = await response.json();
                
                // Simuler un délai de réponse
                setTimeout(() => {
                    this.isTyping = false;
                    
                    // Ajouter la réponse du bot
                    this.messages.push({
                        id: Date.now() + 1,
                        type: 'bot',
                        content: data.bot_message.message,
                        time: new Date().toLocaleTimeString('fr-FR', { 
                            hour: '2-digit', 
                            minute: '2-digit' 
                        })
                    });
                    
                    this.scrollToBottom();
                }, 1000 + Math.random() * 1000);
                
            } catch (error) {
                console.error('Erreur lors de l\'envoi du message:', error);
                this.isTyping = false;
                
                // Ajouter un message d'erreur pour l'utilisateur
                this.messages.push({
                    id: Date.now() + 2,
                    type: 'bot',
                    content: 'Désolé, une erreur est survenue. Veuillez réessayer dans quelques instants.',
                    time: new Date().toLocaleTimeString('fr-FR', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    })
                });
                this.scrollToBottom();
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const messagesContainer = document.getElementById('chatMessages');
                if (messagesContainer) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            });
        }
    }
}
</script>
