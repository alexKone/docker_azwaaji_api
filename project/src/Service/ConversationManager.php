<?php

namespace App\Service;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;

class ConversationManager
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function sendMessage(Profile $sender, Profile $receiver, string $content): void
    {
        // Vérifie si une conversation existe déjà entre les deux profils
        $conversation = $this->getConversation($sender, $receiver);

        // Si aucune conversation n'existe, crée une nouvelle conversation
        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->addParticipant($sender);
            $conversation->addParticipant($receiver);
            $this->em->persist($conversation);
        }

        // Crée un nouveau message
        $message = new Message();
        $message->setSender($sender);
        $message->setConversation($conversation);
        $message->setContent($content);
        $this->em->persist($message);

        // Enregistre les changements en base de données
        $this->em->flush();
    }
    public function getMessages(Conversation $conversation): array
    {
        $messages = $this->em->getRepository(Message::class)->findBy(['conversation' => $conversation]);

        return $messages;
    }

    private function getConversation(Profile $profile1, Profile $profile2): ?Conversation
    {
        // Récupère toutes les conversations du premier profil
        $conversations1 = $this->em->getRepository(Conversation::class)->findBy(['participants' => $profile1]);

        // Parcours les conversations du premier profil et vérifie si le second profil y est participant
        foreach ($conversations1 as $conversation) {
            if ($conversation->hasParticipant($profile2)) {
                return $conversation;
            }
        }

        // Aucune conversation n'a été trouvée
        return null;
    }
}
