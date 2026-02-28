<?php

it('redirects and sets the locale cookie when lang query parameter is present', function () {
    $this->get('/?lang=fr')
        ->assertRedirect('/')
        ->assertPlainCookie('locale', 'fr');
});

it('preserves other query parameters when redirecting for lang', function () {
    $response = $this->get('/?lang=fr&foo=bar');

    $response->assertRedirect()
        ->assertPlainCookie('locale', 'fr');

    // fullUrlWithoutQuery may produce a full URL — just check the parameter is preserved
    expect($response->headers->get('Location'))->toContain('foo=bar')
        ->not->toContain('lang=');
});

it('ignores an unsupported lang query parameter and does not redirect', function () {
    $this->get('/?lang=xx')
        ->assertSuccessful();

    expect(app()->getLocale())->not->toBe('xx');
});

it('sets the locale on subsequent requests after lang redirect', function () {
    // First request: ?lang=ja triggers redirect with a locale cookie
    $this->get('/?lang=ja')
        ->assertRedirect('/')
        ->assertPlainCookie('locale', 'ja');

    // Second request: the cookie is now active
    $this->withUnencryptedCookie('locale', 'ja')
        ->get('/')
        ->assertSuccessful();

    expect(app()->getLocale())->toBe('ja');
});

it('uses the locale cookie when present', function () {
    $this->withUnencryptedCookie('locale', 'fr')
        ->get('/')
        ->assertSuccessful();

    expect(app()->getLocale())->toBe('fr');
});

it('ignores an unsupported locale cookie', function () {
    $this->withUnencryptedCookie('locale', 'xx')
        ->get('/')
        ->assertSuccessful();

    expect(app()->getLocale())->not->toBe('xx');
});

it('detects locale from Accept-Language header when no cookie is set', function () {
    $this->get('/', ['Accept-Language' => 'es-ES,es;q=0.9,en;q=0.8'])
        ->assertSuccessful();

    expect(app()->getLocale())->toBe('es');
});

it('falls back to app default when Accept-Language has no supported match', function () {
    $this->get('/', ['Accept-Language' => 'xx;q=1.0'])
        ->assertSuccessful();

    expect(app()->getLocale())->toBe(config('app.locale'));
});

it('prefers the cookie over Accept-Language header', function () {
    $this->withUnencryptedCookie('locale', 'it')
        ->get('/', ['Accept-Language' => 'fr-FR,fr;q=0.9'])
        ->assertSuccessful();

    expect(app()->getLocale())->toBe('it');
});
