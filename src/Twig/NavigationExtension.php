<?php

namespace App\Twig;

use App\Repository\MenuRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavigationExtension extends AbstractExtension
{
    private $menuRepository;
    private $security;

    public function __construct(MenuRepository $menuRepository, Security $security)
    {
        $this->menuRepository = $menuRepository;
        $this->security = $security; // Injecting the security service to access roles
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_navigation', [$this, 'renderNavigation'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function renderNavigation(Environment $twig): string
    {
        // Fetch top-level menu items (without parent)
        $menuItems = $this->menuRepository->findOrderedMenuItems('topmenu');
        $userItems = $this->menuRepository->findOrderedMenuItems('usermenu');

        // Process each menu item and its sub-items
        $menuItems = $this->filterByRoles($menuItems);
        $userItems = $this->filterByRoles($userItems);

        return $twig->render('components/navigation.html.twig', [
            'menu_items' => $menuItems,
            'user_items' => $userItems,
        ]);
    }

    private function filterByRoles(array $menuItems): array
    {
        return array_filter($menuItems, function ($item) {
            foreach ($item->getRoles() as $role) {
                if ($item->getPublicAccess()) {
                    return true; // Publicly accessible menu items
                }

                if ($this->security->isGranted($role)) {
                    return true;
                }
            }
            return false;
        });
    }
}