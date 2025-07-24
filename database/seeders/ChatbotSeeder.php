<?php

namespace Database\Seeders;

use App\Models\ChatResponse;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\Produit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChatbotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des réponses prédéfinies pour le chatbot
        $this->createChatResponses();
        
        // Créer quelques sessions de chat d'exemple
        $this->createSampleChatSessions();
    }

    private function createChatResponses(): void
    {
        $responses = [
            // Réponses générales d'accueil
            [
                'trigger' => 'salut|bonjour|hello|bonsoir',
                'response' => 'Bonjour ! Je suis votre assistant vétérinaire virtuel. Comment puis-je vous aider avec votre animal aujourd\'hui ?',
                'keywords' => ['salut', 'bonjour', 'hello', 'bonsoir', 'salutation'],
                'category' => 'general',
                'priority' => 10,
                'is_active' => true,
            ],
            [
                'trigger' => 'aide|help|assistance',
                'response' => 'Je peux vous aider avec des questions sur la santé de votre animal, vous recommander des produits adaptés, et vous donner des conseils vétérinaires généraux. Que souhaitez-vous savoir ?',
                'keywords' => ['aide', 'help', 'assistance', 'comment'],
                'category' => 'general',
                'priority' => 8,
                'is_active' => true,
            ],

            // Problèmes de santé chiens
            [
                'trigger' => 'chien.*diarrhée|diarrhée.*chien|chien.*selles|selles.*chien',
                'response' => 'La diarrhée chez le chien peut avoir plusieurs causes : changement alimentaire, stress, parasites, ou infection. Si cela persiste plus de 24h ou s\'accompagne de vomissements, consultez un vétérinaire. En attendant, donnez-lui beaucoup d\'eau et une alimentation légère.',
                'keywords' => ['chien', 'diarrhée', 'selles', 'digestif', 'intestin'],
                'category' => 'symptom',
                'priority' => 9,
                'is_active' => true,
            ],
            [
                'trigger' => 'chien.*vomit|vomissement.*chien|chien.*nausée',
                'response' => 'Les vomissements chez le chien peuvent être dus à une alimentation trop rapide, un changement de nourriture, ou un problème plus sérieux. Si votre chien vomit plus de 2 fois en 24h, consultez rapidement un vétérinaire.',
                'keywords' => ['chien', 'vomissement', 'nausée', 'estomac'],
                'category' => 'symptom',
                'priority' => 9,
                'is_active' => true,
            ],
            [
                'trigger' => 'chien.*gratte|démangeaison.*chien|chien.*peau|allergie.*chien',
                'response' => 'Les démangeaisons chez le chien peuvent être causées par des allergies alimentaires, des parasites, ou des problèmes de peau. Vérifiez s\'il y a des puces et consultez un vétérinaire pour un diagnostic précis.',
                'keywords' => ['chien', 'gratte', 'démangeaison', 'allergie', 'peau', 'puces'],
                'category' => 'symptom',
                'priority' => 8,
                'is_active' => true,
            ],

            // Problèmes de santé chats
            [
                'trigger' => 'chat.*litière|litière.*chat|chat.*urine|problème.*litière',
                'response' => 'Les problèmes de litière chez le chat peuvent indiquer un stress, une infection urinaire, ou un problème comportemental. Assurez-vous que la litière est propre et consultez un vétérinaire si le problème persiste.',
                'keywords' => ['chat', 'litière', 'urine', 'pipi', 'propreté'],
                'category' => 'symptom',
                'priority' => 9,
                'is_active' => true,
            ],
            [
                'trigger' => 'chat.*mange.*pas|chat.*appétit|chat.*anorexie',
                'response' => 'Un chat qui ne mange pas peut avoir un problème de santé sérieux. Les chats ne doivent pas jeûner plus de 24h. Consultez rapidement un vétérinaire, surtout si votre chat semble léthargique.',
                'keywords' => ['chat', 'mange', 'appétit', 'anorexie', 'nourriture'],
                'category' => 'symptom',
                'priority' => 10,
                'is_active' => true,
            ],
            [
                'trigger' => 'chat.*respiration|chat.*tousse|toux.*chat',
                'response' => 'Les problèmes respiratoires chez le chat peuvent être graves. Si votre chat tousse, a des difficultés à respirer, ou respire la bouche ouverte, consultez immédiatement un vétérinaire.',
                'keywords' => ['chat', 'respiration', 'toux', 'souffle', 'asthme'],
                'category' => 'emergency',
                'priority' => 10,
                'is_active' => true,
            ],

            // Conseils alimentaires
            [
                'trigger' => 'nourriture|alimentation|croquettes|pâtée',
                'response' => 'Une bonne alimentation est essentielle pour la santé de votre animal. Choisissez des aliments adaptés à son âge, sa taille et ses besoins spécifiques. Évitez les changements brusques d\'alimentation.',
                'keywords' => ['nourriture', 'alimentation', 'croquettes', 'pâtée', 'nutrition'],
                'category' => 'general',
                'priority' => 7,
                'is_active' => true,
            ],

            // Urgences
            [
                'trigger' => 'urgence|empoisonnement|accident|blessure|sang',
                'response' => 'URGENCE : En cas d\'empoisonnement, d\'accident grave, de blessure avec saignement important, ou de détresse respiratoire, contactez immédiatement votre vétérinaire ou une clinique d\'urgence !',
                'keywords' => ['urgence', 'empoisonnement', 'accident', 'blessure', 'sang', 'toxique'],
                'category' => 'emergency',
                'priority' => 15,
                'is_active' => true,
            ],

            // Réponse par défaut
            [
                'trigger' => '.*',
                'response' => 'Je comprends votre préoccupation. Pouvez-vous me donner plus de détails sur les symptômes que vous observez chez votre animal ? Depuis quand cela dure-t-il ?',
                'keywords' => ['defaut'],
                'category' => 'general',
                'priority' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($responses as $response) {
            ChatResponse::create($response);
        }
    }

    private function createSampleChatSessions(): void
    {
        // Récupérer quelques utilisateurs pour créer des sessions
        $users = User::limit(3)->get();
        
        if ($users->isEmpty()) {
            return; // Pas d'utilisateurs, on ne peut pas créer de sessions
        }

        foreach ($users as $user) {
            // Créer 1-2 sessions par utilisateur
            for ($i = 0; $i < rand(1, 2); $i++) {
                $session = ChatSession::create([
                    'session_id' => Str::uuid(),
                    'user_id' => $user->id,
                    'status' => rand(0, 1) ? 'active' : 'closed',
                    'context' => [
                        'user_agent' => 'Mozilla/5.0 (compatible; ChatBot)',
                        'ip' => '127.0.0.1',
                        'started_at' => now()->subHours(rand(1, 48))->toISOString(),
                    ],
                ]);

                // Créer quelques messages pour cette session
                $this->createSampleMessages($session);
            }
        }
    }

    private function createSampleMessages(ChatSession $session): void
    {
        $sampleConversations = [
            [
                ['type' => 'user', 'message' => 'Bonjour, mon chien vomit depuis ce matin'],
                ['type' => 'bot', 'message' => 'Bonjour ! Je comprends votre inquiétude. Les vomissements chez le chien peuvent avoir plusieurs causes. Depuis combien de temps votre chien vomit-il exactement ? A-t-il mangé quelque chose d\'inhabituel ?'],
                ['type' => 'user', 'message' => 'Depuis environ 3 heures, et oui il a mangé de l\'herbe hier'],
                ['type' => 'bot', 'message' => 'Il est normal que les chiens mangent de l\'herbe occasionnellement, cela peut les aider à se purger. Si les vomissements persistent ou s\'accompagnent d\'autres symptômes, je recommande de consulter un vétérinaire.'],
            ],
            [
                ['type' => 'user', 'message' => 'Ma chatte ne va plus dans sa litière'],
                ['type' => 'bot', 'message' => 'Les problèmes de litière chez le chat peuvent indiquer un stress, une infection urinaire, ou un problème comportemental. Depuis quand avez-vous remarqué ce comportement ? La litière est-elle propre ?'],
                ['type' => 'user', 'message' => 'Ça fait 2 jours, et oui la litière est propre'],
                ['type' => 'bot', 'message' => 'Je recommande vivement de consulter un vétérinaire rapidement. Cela pourrait être une infection urinaire qui nécessite un traitement antibiotique.'],
            ],
            [
                ['type' => 'user', 'message' => 'Bonjour'],
                ['type' => 'bot', 'message' => 'Bonjour ! Je suis votre assistant vétérinaire virtuel. Comment puis-je vous aider avec votre animal aujourd\'hui ?'],
                ['type' => 'user', 'message' => 'Merci, je reviendrai si j\'ai des questions'],
                ['type' => 'bot', 'message' => 'Parfait ! N\'hésitez pas à revenir si vous avez des questions sur la santé de votre animal. Je suis là pour vous aider !'],
            ],
        ];

        $conversation = $sampleConversations[array_rand($sampleConversations)];
        
        foreach ($conversation as $index => $messageData) {
            ChatMessage::create([
                'session_id' => $session->id,
                'type' => $messageData['type'],
                'message' => $messageData['message'],
                'metadata' => [
                    'timestamp' => now()->subMinutes(count($conversation) - $index * 2)->toISOString(),
                ],
                'created_at' => now()->subMinutes(count($conversation) - $index * 2),
                'updated_at' => now()->subMinutes(count($conversation) - $index * 2),
            ]);
        }
    }
}
