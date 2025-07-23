class VetChatbot {
    constructor() {
        this.isOpen = false;
        this.sessionId = null;
        this.isTyping = false;
        this.init();
    }

    init() {
        this.createWidget();
        this.bindEvents();
        this.initSession();
    }

    createWidget() {
        document.body.classList.add('has-chatbot');
        
        const widget = document.createElement('div');
        widget.className = 'chatbot-widget';
        widget.innerHTML = `
            <div class="chatbot-window" id="chatbot-window">
                <div class="chatbot-header">
                    <h3>🩺 Assistant Vétérinaire</h3>
                    <button class="chatbot-close" id="chatbot-close">×</button>
                </div>
                <div class="chatbot-messages" id="chatbot-messages">
                    <!-- Messages will be added here -->
                </div>
                <div class="chatbot-input-area">
                    <input type="text" class="chatbot-input" id="chatbot-input" 
                           placeholder="Décrivez le problème de votre animal..." maxlength="500">
                    <button class="chatbot-send" id="chatbot-send">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <button class="chatbot-button" id="chatbot-button">
                <span id="chatbot-icon">🩺</span>
            </button>
        `;
        
        document.body.appendChild(widget);
    }

    bindEvents() {
        const button = document.getElementById('chatbot-button');
        const closeBtn = document.getElementById('chatbot-close');
        const input = document.getElementById('chatbot-input');
        const sendBtn = document.getElementById('chatbot-send');

        button.addEventListener('click', () => this.toggleChat());
        closeBtn.addEventListener('click', () => this.closeChat());
        
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });
        
        sendBtn.addEventListener('click', () => this.sendMessage());
    }

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
            
            data.messages.forEach(msg => this.displayMessage(msg));
            
        } catch (error) {
            console.error('Erreur lors de l\'initialisation du chat:', error);
        }
    }

    toggleChat() {
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }

    openChat() {
        const window = document.getElementById('chatbot-window');
        const button = document.getElementById('chatbot-button');
        const icon = document.getElementById('chatbot-icon');
        
        window.classList.add('active');
        button.classList.add('active');
        icon.textContent = '×';
        this.isOpen = true;
        
        setTimeout(() => {
            document.getElementById('chatbot-input').focus();
        }, 300);
    }

    closeChat() {
        const window = document.getElementById('chatbot-window');
        const button = document.getElementById('chatbot-button');
        const icon = document.getElementById('chatbot-icon');
        
        window.classList.remove('active');
        button.classList.remove('active');
        icon.textContent = '🩺';
        this.isOpen = false;
    }

    async sendMessage() {
        const input = document.getElementById('chatbot-input');
        const message = input.value.trim();
        
        if (!message || this.isTyping) return;
        
        input.disabled = true;
        document.getElementById('chatbot-send').disabled = true;
        
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
            
            const data = await response.json();
            
            this.displayMessage(data.user_message);
                        input.value = '';
            
            this.showTypingIndicator();
            
            setTimeout(() => {
                this.hideTypingIndicator();
                this.displayMessage(data.bot_message);
            }, 1000 + Math.random() * 1000);
            
        } catch (error) {
            console.error('Erreur lors de l\'envoi du message:', error);
            this.hideTypingIndicator();
        } finally {
            input.disabled = false;
            document.getElementById('chatbot-send').disabled = false;
            input.focus();
        }
    }

    displayMessage(message) {
        const messagesContainer = document.getElementById('chatbot-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${message.type}`;
        
        let content = `
            <div class="chatbot-message-bubble">
                ${this.formatMessage(message.message)}
            </div>
            <div class="chatbot-message-time">${message.created_at}</div>
        `;
        

        if (message.metadata && message.metadata.products) {
            content += '<div class="chatbot-products">';
            message.metadata.products.forEach(product => {
                content += `
                    <div class="chatbot-product" onclick="window.open('${product.url}', '_blank')">
                        <div class="chatbot-product-name">${product.nom}</div>
                        <div class="chatbot-product-price">${product.prix}</div>
                    </div>
                `;
            });
            content += '</div>';
        }
        
        messageDiv.innerHTML = content;
        messagesContainer.appendChild(messageDiv);
        

        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    formatMessage(message) {

        return message.replace(/\n/g, '<br>');
    }

    showTypingIndicator() {
        if (this.isTyping) return;
        
        this.isTyping = true;
        const messagesContainer = document.getElementById('chatbot-messages');
        const typingDiv = document.createElement('div');
        typingDiv.className = 'chatbot-message bot';
        typingDiv.id = 'typing-indicator';
        typingDiv.innerHTML = `
            <div class="chatbot-typing">
                <div class="chatbot-typing-dot"></div>
                <div class="chatbot-typing-dot"></div>
                <div class="chatbot-typing-dot"></div>
            </div>
        `;
        
        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    hideTypingIndicator() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
        this.isTyping = false;
    }
}


document.addEventListener('DOMContentLoaded', function() {

    if (document.querySelector('meta[name="csrf-token"]')) {
        window.vetChatbot = new VetChatbot();
    }
});
