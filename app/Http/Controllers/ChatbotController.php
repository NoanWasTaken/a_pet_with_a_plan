<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\ChatResponse;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function initSession(Request $request): JsonResponse
    {
        $sessionId = $request->session()->getId();
        
        $chatSession = ChatSession::firstOrCreate([
            'session_id' => $sessionId,
        ], [
            'user_id' => auth()->id(),
            'status' => 'active',
            'context' => [],
        ]);

        // Message de bienvenue
        if ($chatSession->messages()->count() === 0) {
            $this->addBotMessage($chatSession, "Bonjour ! 👋 Je suis votre assistant vétérinaire virtuel. Comment puis-je vous aider avec votre animal aujourd'hui ?");
        }

        return response()->json([
            'session_id' => $chatSession->id,
            'messages' => $chatSession->latestMessages()->get()->map(function ($message) {
                return [
                    'id' => $message->id,
                    'type' => $message->type,
                    'message' => $message->message,
                    'metadata' => $message->metadata,
                    'created_at' => $message->created_at->format('H:i'),
                ];
            }),
        ]);
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|exists:chat_sessions,id',
            'message' => 'required|string|max:500',
        ]);

        $chatSession = ChatSession::findOrFail($request->session_id);
        
        // Ajouter le message de l'utilisateur
        $userMessage = $this->addUserMessage($chatSession, $request->message);
        
        // Générer la réponse du bot
        $botResponse = $this->generateBotResponse($request->message, $chatSession);
        $botMessage = $this->addBotMessage($chatSession, $botResponse['message'], $botResponse['metadata']);

        return response()->json([
            'user_message' => [
                'id' => $userMessage->id,
                'type' => 'user',
                'message' => $userMessage->message,
                'created_at' => $userMessage->created_at->format('H:i'),
            ],
            'bot_message' => [
                'id' => $botMessage->id,
                'type' => 'bot',
                'message' => $botMessage->message,
                'metadata' => $botMessage->metadata,
                'created_at' => $botMessage->created_at->format('H:i'),
            ],
        ]);
    }

    private function addUserMessage(ChatSession $session, string $message): ChatMessage
    {
        return $session->messages()->create([
            'type' => 'user',
            'message' => $message,
        ]);
    }

    private function addBotMessage(ChatSession $session, string $message, array $metadata = []): ChatMessage
    {
        return $session->messages()->create([
            'type' => 'bot',
            'message' => $message,
            'metadata' => $metadata,
        ]);
    }

    private function generateBotResponse(string $userMessage, ChatSession $session): array
    {
        $message = strtolower($userMessage);
        
        // Rechercher une réponse correspondante dans la base de connaissances
        $response = $this->findMatchingResponse($message);
        
        if ($response) {
            $botMessage = $response->response;
            $metadata = [];
            
            // Ajouter les produits recommandés si disponibles
            if ($response->product_ids) {
                $products = $response->products();
                $metadata['products'] = $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'nom' => $product->nom,
                        'prix' => $product->prix_formate,
                        'url' => route('shop.show', $product),
                    ];
                })->toArray();
                
                if ($products->count() > 0) {
                    $botMessage .= "

Voici quelques produits qui pourraient vous aider :";
                }
            }
            
            return [
                'message' => $botMessage,
                'metadata' => $metadata,
            ];
        }
        
        // Réponse par défaut si aucune correspondance trouvée
        return [
            'message' => "Je comprends votre préoccupation. Pour des conseils spécialisés, je recommande de consulter un vétérinaire. En attendant, puis-je vous aider à trouver des produits pour votre animal ?",
            'metadata' => [],
        ];
    }

    private function findMatchingResponse(string $message): ?ChatResponse
    {
        // Recherche par mots-clés et triggers regex
        $responses = ChatResponse::active()->byPriority()->get();
        
        foreach ($responses as $response) {
            // Vérifier le trigger comme expression régulière
            $pattern = '/(' . $response->trigger . ')/i';
            if (preg_match($pattern, $message)) {
                return $response;
            }
            
            // Vérifier les mots-clés individuels
            if ($response->keywords) {
                foreach ($response->keywords as $keyword) {
                    if (Str::contains($message, strtolower($keyword))) {
                        return $response;
                    }
                }
            }
        }
        
        return null;
    }

    public function getHistory(Request $request): JsonResponse
    {
        $sessionId = $request->session()->getId();
        
        $chatSession = ChatSession::where('session_id', $sessionId)->first();
        
        if (!$chatSession) {
            return response()->json(['messages' => []]);
        }

        return response()->json([
            'messages' => $chatSession->latestMessages()->get()->map(function ($message) {
                return [
                    'id' => $message->id,
                    'type' => $message->type,
                    'message' => $message->message,
                    'metadata' => $message->metadata,
                    'created_at' => $message->created_at->format('H:i'),
                ];
            }),
        ]);
    }
}
