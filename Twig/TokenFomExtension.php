<?php
            
namespace Aldaflux\AldafluxDeleteBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

#use Twig\Environment;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Contracts\Translation\TranslatorInterface;



class TokenFomExtension extends AbstractExtension
{
    private $csrfTokenManager;
    private $router;
    private $translator;
    
    public function __construct(CsrfTokenManagerInterface $csrfTokenManager, UrlGeneratorInterface $router, TranslatorInterface $translator)
    {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->router=$router;
        $this->translator=$translator;
    }

    /*
    private $twig;
    public function __construct(CsrfTokenManagerInterface $twig) 
    {
        $this->twig = $twig;
    }
     */

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
//            new TwigFunction('testCrud', [$this, 'testCrud']),
            new TwigFunction('deleteTokenIcon', [$this, 'deleteTokenIcon'], ['is_safe' => ['html']]),
        ];
    }

    
            
    public function deleteTokenIcon($routeName, $key,$idField="id")
    {
        $route=$this->router->generate($routeName, [$idField=>$key]);
        $token=$this->getCsrfToken("delete".$key);
        
        $form="<form class='delete-form' method='post' action='".$route."'";
        $form.= "onsubmit=\"return confirm('".$this->translator->trans("crud.delete.before")."');\"";
        $form.=">";

        $form.='<input type="hidden" name="_method" value="DELETE">';
        $form.='<input type="hidden" name="_token" value="'.$token.'">';
        $form.='<button class="btn-delete">';
            $form.="<i class='btn-delete-icon'></i>";
//            $form.="{% trans %}crud.delete.text{% endtrans %}";
        $form.="</button>";
        $form.="</form>";
        
        
        
        //return($this->twig->render('@AldafluxDeleteBundle/Resources/views/_delete_form.html.twig', ['cartes' => "nddd"]));
        //        return($this->twig->render('../Ressources/views/_delete_form.html.twig', ['cartes' => "nddd"]));
        

        return($form);
        return("<div class='alert alert-danger'> -CA MARCHE ".$form." ROUTER OK</div>");
    }
    

    public function getCsrfToken(string $tokenId): string
    {
        return $this->csrfTokenManager->getToken($tokenId)->getValue();
    }    
    
}
