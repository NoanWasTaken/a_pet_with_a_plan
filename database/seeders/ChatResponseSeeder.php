<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatResponse;

class ChatResponseSeeder extends Seeder
{
    public function run(): void
    {
        $responses = [
            // Symptômes généraux
            [
                'trigger' => 'gratte',
                'response' => 'Les démangeaisons peuvent être causées par plusieurs facteurs : puces, allergies, peau sèche ou infections. Voici quelques produits qui peuvent aider à soulager votre animal.',
                'keywords' => ['démangeaison', 'grattage', 'prurit', 'se gratte', 'démangeaisons'],
                'product_ids' => null, // À remplir avec des IDs de produits anti-puces/shampoing
                'category' => 'symptom',
                'priority' => 10,
            ],
            [
                'trigger' => 'vomit',
                'response' => 'Les vomissements peuvent indiquer un problème digestif. Si cela persiste plus de 24h ou s\'accompagne d\'autres symptômes, consultez un vétérinaire. En attendant, une diète légère peut aider.',
                'keywords' => ['vomissement', 'vomit', 'régurgite', 'rend', 'nausée'],
                'product_ids' => null,
                'category' => 'symptom',
                'priority' => 9,
            ],
            [
                'trigger' => 'diarrhée',
                'response' => 'La diarrhée peut être causée par un changement d\'alimentation, du stress ou une infection. Assurez-vous que votre animal reste hydraté. Si cela dure plus de 48h, consultez un vétérinaire.',
                'keywords' => ['diarrhee', 'selles molles', 'transit', 'intestin'],
                'product_ids' => null,
                'category' => 'symptom',
                'priority' => 9,
            ],
            [
                'trigger' => 'boite',
                'response' => 'Si votre animal boite, cela peut indiquer une blessure à la patte, une entorse ou un problème articulaire. Limitez son activité et consultez un vétérinaire si cela persiste.',
                'keywords' => ['boiterie', 'claudique', 'patte', 'marche mal', 'articulation'],
                'product_ids' => null,
                'category' => 'symptom',
                'priority' => 8,
            ],
            [
                'trigger' => 'mange pas',
                'response' => 'Une perte d\'appétit peut être due au stress, à la maladie ou à un changement d\'environnement. Si votre animal ne mange pas depuis plus de 24h (12h pour un chaton/chiot), consultez un vétérinaire.',
                'keywords' => ['appétit', 'mange plus', 'refuse manger', 'anorexie'],
                'product_ids' => null,
                'category' => 'symptom',
                'priority' => 8,
            ],

            // Soins préventifs
            [
                'trigger' => 'vaccin',
                'response' => 'Les vaccinations sont essentielles pour protéger votre animal. Les chiots/chatons ont besoin d\'une série de vaccins, puis de rappels annuels. Consultez votre vétérinaire pour établir un calendrier.',
                'keywords' => ['vaccination', 'vacciner', 'immunisation', 'rappel'],
                'product_ids' => null,
                'category' => 'general',
                'priority' => 7,
            ],
            [
                'trigger' => 'vermifuge',
                'response' => 'Le vermifugage régulier est important. Les chiots/chatons doivent être vermifugés toutes les 2-3 semaines jusqu\'à 6 mois, puis tous les 3-6 mois pour les adultes.',
                'keywords' => ['vers', 'déparasitage', 'parasites internes'],
                'product_ids' => null,
                'category' => 'general',
                'priority' => 7,
            ],
            [
                'trigger' => 'puce',
                'response' => 'Les puces sont un problème fréquent. Un traitement préventif régulier est recommandé. Voici des produits efficaces contre les puces.',
                'keywords' => ['puces', 'tique', 'parasites externes', 'antipuce'],
                'product_ids' => null,
                'category' => 'general',
                'priority' => 7,
            ],

            // Urgences
            [
                'trigger' => 'urgence',
                'response' => '⚠️ URGENCE : Si votre animal présente des signes graves (difficultés respiratoires, convulsions, traumatisme, empoisonnement), contactez immédiatement un vétérinaire d\'urgence !',
                'keywords' => ['urgent', 'grave', 'empoisonnement', 'accident', 'convulsion'],
                'product_ids' => null,
                'category' => 'emergency',
                'priority' => 15,
            ],
            [
                'trigger' => 'respire mal',
                'response' => '⚠️ URGENT : Les difficultés respiratoires sont une urgence vétérinaire. Contactez immédiatement un vétérinaire ou une clinique d\'urgence.',
                'keywords' => ['respiration', 'souffle', 'dyspnée', 'halète'],
                'product_ids' => null,
                'category' => 'emergency',
                'priority' => 15,
            ],

            // Questions générales
            [
                'trigger' => 'alimentation',
                'response' => 'Une alimentation équilibrée est cruciale. Choisissez une nourriture adaptée à l\'âge, la taille et l\'activité de votre animal. Évitez les changements brusques d\'alimentation.',
                'keywords' => ['nourriture', 'croquettes', 'alimentation', 'nutrition'],
                'product_ids' => null,
                'category' => 'general',
                'priority' => 6,
            ],
            [
                'trigger' => 'comportement',
                'response' => 'Les changements de comportement peuvent indiquer un problème de santé ou de bien-être. Observez les habitudes de votre animal et notez tout changement significatif.',
                'keywords' => ['agressif', 'peur', 'stress', 'anxiété', 'comportement'],
                'product_ids' => null,
                'category' => 'general',
                'priority' => 5,
            ],

            // Salutations
            [
                'trigger' => 'bonjour',
                'response' => 'Bonjour ! Je suis ravi de vous aider avec les soins de votre animal. Pouvez-vous me décrire le problème que rencontre votre compagnon ?',
                'keywords' => ['salut', 'hello', 'bonsoir'],
                'product_ids' => null,
                'category' => 'general',
                'priority' => 1,
            ],
            [
                'trigger' => 'merci',
                'response' => 'Je vous en prie ! J\'espère que ces conseils vous seront utiles. N\'hésitez pas si vous avez d\'autres questions sur la santé de votre animal.',
                'keywords' => ['remercie'],
                'product_ids' => null,
                'category' => 'general',
                'priority' => 1,
            ],
        ];

        foreach ($responses as $responseData) {
            ChatResponse::create($responseData);
        }
    }
}
