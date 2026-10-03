<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Navbar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Navbar\UserMenu;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class UserMenuTest extends TestCase
{
    public function test_it_uses_fallback_values_and_standard_navigation(): void
    {
        config(['ladmin.main.livewire.spa_navigation' => false]);
        $this->registerProfileRoute();
        $this->actingAs(new class extends Authenticatable {});

        $menu = new UserMenu;

        $this->assertSame('Guest', $menu->userName);
        $this->assertSame('guest@example.com', $menu->userEmail);
        $this->assertNull($menu->userImageUrl);
        $this->assertSame(
            "window.location='".route('ladmin.profile.show')."'",
            $menu->navigateToProfileScript
        );
    }

    public function test_it_uses_authenticated_user_data(): void
    {
        $this->registerProfileRoute();

        $user = new class extends Authenticatable {};
        $user->name = 'Jane Doe';
        $user->email = 'jane@example.test';
        $this->actingAs($user);

        $menu = new UserMenu;

        $this->assertSame('Jane Doe', $menu->userName);
        $this->assertSame('jane@example.test', $menu->userEmail);
    }

    public function test_it_uses_livewire_navigation_when_enabled(): void
    {
        config(['ladmin.main.livewire.spa_navigation' => true]);
        $this->registerProfileRoute();

        $user = new class extends Authenticatable {};
        $user->name = 'Jane Doe';
        $user->email = 'jane@example.test';
        $this->actingAs($user);

        $menu = new UserMenu;

        $this->assertStringStartsWith(
            'Livewire.navigate(',
            $menu->navigateToProfileScript
        );
    }

    public function test_it_uses_the_profile_image_when_enabled(): void
    {
        config(['ladmin.auth.features.profile_image' => true]);
        $this->registerProfileRoute();

        $user = new class extends Authenticatable
        {
            public function profileImageUrl(): string
            {
                return '/storage/profile.jpg';
            }
        };
        $this->actingAs($user);

        $menu = new UserMenu;

        $this->assertSame('/storage/profile.jpg', $menu->userImageUrl);
    }

    public function test_it_skips_the_profile_image_if_user_does_not_support_it(): void
    {
        config(['ladmin.auth.features.profile_image' => true]);
        $this->registerProfileRoute();
        $this->actingAs(new class extends Authenticatable {});

        $menu = new UserMenu;

        $this->assertNull($menu->userImageUrl);
    }

    public function test_it_skips_the_profile_image_if_feature_disabled(): void
    {
        config(['ladmin.auth.features.profile_image' => false]);
        $this->registerProfileRoute();

        $user = new class extends Authenticatable
        {
            public function profileImageUrl(): string
            {
                return '/storage/profile.jpg';
            }
        };
        $this->actingAs($user);

        $menu = new UserMenu;

        $this->assertNull($menu->userImageUrl);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $this->registerProfileRoute();
        $this->actingAs(new class extends Authenticatable {});

        $view = (new UserMenu)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.navbar.user-menu', $view->getName());
    }

    /**
     * Registers a test profile route.
     */
    private function registerProfileRoute(): void
    {
        Route::get('/test-profile', static fn () => '')
            ->name('ladmin.profile.show');
    }
}
