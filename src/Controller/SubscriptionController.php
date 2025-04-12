<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Subscription;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class SubscriptionController extends AbstractController
{
    #[Route('/', name: 'app_subscription')]
    public function appSubscription(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        // Create a new User entity
        $user = new User();

        // Create the registration form
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // If the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Change format string "MM/YY" to date
            $expirationString = $form->get('creditCardExpirationDate')->getData();
            $expirationDate = \DateTime::createFromFormat('m/y', $expirationString);
            $user->setCreditCardExpirationDate($expirationDate);

            // Need to fill address.user_id
            $address = $user->getAddress();
            if ($address) {
                $address->setUser($user);
            }

            // If premium, we create a subscription occurrence
            $subscriptionType = $form->get('subscriptionType')->getData();
            if ($subscriptionType === 'premium') {
                $expirationDate = new \DateTime('+1 year -1 day');
                $subscription = new Subscription();
                $subscription->setUser($user);
                $subscription->setType($subscriptionType); //We could associate this field as Enum SubscriptionType
                $subscription->setDateStart(new \DateTime());
                $subscription->setDateEnd($expirationDate);
                
                $entityManager->persist($subscription);
            }

            // Save the user and related entities
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect after successful registration
            return $this->redirectToRoute('app_subscription_success');
        }

        // Render the form in the view
        return $this->render('subscription/subscription.html.twig', [
            'subscriptionForm' => $form->createView(),
        ]);
    }

    #[Route('/subscription/success', name: 'app_subscription_success')]
    public function appSubscriptionSuccess(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        // Render the view
        return $this->render('subscription/subscription_success.html.twig', [
        ]);
    }
}
