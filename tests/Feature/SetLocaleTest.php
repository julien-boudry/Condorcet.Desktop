<?php

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
