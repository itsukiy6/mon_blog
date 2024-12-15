<?php

namespace App\Form\Type;

use App\Entity\Article;
use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu', TextareaType::class, [
                'label' => 'Votre message',
            ])
            ->add('article', HiddenType::class)
            ->add('send', SubmitType::class, [
            'label'=>'Envoyer'
        ]);

        $builder->get('article')
            ->addModelTransformer(new CallbackTransformer(
                fn (Article $article) =>  $article->getId(),
                fn (Article $article) => $article->getTitre()
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
            'csrf_token_id' => 'comment-add',
        ]);
    }
}