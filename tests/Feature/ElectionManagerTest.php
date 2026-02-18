<?php

use App\Livewire\ElectionManager;
use Livewire\Livewire;

it('renders the election manager page', function () {
    $this->get('/')->assertSuccessful();
});

it('adds a single candidate', function () {
    Livewire::test(ElectionManager::class)
        ->set('newCandidate', 'Alice')
        ->call('addCandidate')
        ->assertSet('candidates', ['Alice'])
        ->assertSet('newCandidate', '');
});

it('rejects duplicate candidates', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice'])
        ->set('newCandidate', 'Alice')
        ->call('addCandidate')
        ->assertHasErrors('newCandidate')
        ->assertSet('candidates', ['Alice']);
});

it('rejects empty candidate names', function () {
    Livewire::test(ElectionManager::class)
        ->set('newCandidate', '')
        ->call('addCandidate')
        ->assertHasErrors('newCandidate');
});

it('adds candidates in bulk via semicolons', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidatesBulk', 'Alice ; Bob ; Charlie')
        ->call('addCandidatesBulk')
        ->assertSet('candidates', ['Alice', 'Bob', 'Charlie'])
        ->assertSet('candidatesBulk', '');
});

it('removes a candidate by index', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob', 'Charlie'])
        ->call('removeCandidate', 1)
        ->assertSet('candidates', ['Alice', 'Charlie']);
});

it('adds a vote', function () {
    Livewire::test(ElectionManager::class)
        ->set('newVoteRanking', 'Alice > Bob > Charlie')
        ->call('addVote')
        ->assertCount('votes', 1)
        ->assertSet('newVoteRanking', '');
});

it('adds a vote with weight and quantity', function () {
    Livewire::test(ElectionManager::class)
        ->set('weightAllowed', true)
        ->set('newVoteRanking', 'Alice > Bob')
        ->set('newVoteWeight', 3)
        ->set('newVoteQuantity', 5)
        ->call('addVote')
        ->assertSet('votes.0.ranking', 'Alice > Bob')
        ->assertSet('votes.0.weight', 3)
        ->assertSet('votes.0.quantity', 5);
});

it('removes a vote by index', function () {
    Livewire::test(ElectionManager::class)
        ->set('votes', [
            ['ranking' => 'A > B', 'weight' => 1, 'quantity' => 1],
            ['ranking' => 'B > A', 'weight' => 1, 'quantity' => 1],
        ])
        ->call('removeVote', 0)
        ->assertCount('votes', 1)
        ->assertSet('votes.0.ranking', 'B > A');
});

it('toggles a voting method on and off', function () {
    Livewire::test(ElectionManager::class)
        ->call('toggleMethod', 'Schulze')
        ->assertSet('methods', ['Schulze'])
        ->call('toggleMethod', 'Schulze')
        ->assertSet('methods', []);
});

it('shows empty state when not enough data', function () {
    Livewire::test(ElectionManager::class)
        ->assertSee('No results to display');
});

it('computes results with valid election data', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob', 'Charlie'])
        ->set('votes', [
            ['ranking' => 'Alice > Bob > Charlie', 'weight' => 1, 'quantity' => 1],
            ['ranking' => 'Bob > Alice > Charlie', 'weight' => 1, 'quantity' => 1],
            ['ranking' => 'Alice > Charlie > Bob', 'weight' => 1, 'quantity' => 1],
        ])
        ->set('methods', ['Schulze'])
        ->assertSee('Condorcet Winner')
        ->assertSee('Alice');
});

it('displays the pairwise matrix with valid data', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob', 'Charlie'])
        ->set('votes', [
            ['ranking' => 'Alice > Bob > Charlie', 'weight' => 1, 'quantity' => 1],
            ['ranking' => 'Bob > Charlie > Alice', 'weight' => 1, 'quantity' => 1],
        ])
        ->set('methods', ['Schulze'])
        ->assertSee('Pairwise Comparison Matrix');
});

it('loads state from localStorage payload', function () {
    Livewire::test(ElectionManager::class)
        ->call('loadFromLocalStorage', [
            'candidates' => ['X', 'Y'],
            'votes' => [['ranking' => 'X > Y', 'weight' => 1, 'quantity' => 1]],
            'methods' => ['Copeland'],
            'seats' => 3,
            'implicitRanking' => false,
            'weightAllowed' => true,
        ])
        ->assertSet('candidates', ['X', 'Y'])
        ->assertSet('seats', 3)
        ->assertSet('implicitRanking', false)
        ->assertSet('weightAllowed', true);
});

it('resets the election', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['A', 'B'])
        ->set('votes', [['ranking' => 'A > B', 'weight' => 1, 'quantity' => 1]])
        ->set('methods', ['Schulze'])
        ->call('resetElection')
        ->assertSet('candidates', [])
        ->assertSet('votes', [])
        ->assertSet('methods', []);
});

it('exports to cvotes format', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob'])
        ->set('votes', [
            ['ranking' => 'Alice > Bob', 'weight' => 1, 'quantity' => 1],
        ])
        ->call('exportCvotes')
        ->assertSet('exportOutput', fn ($value) => str_contains($value, 'Alice') && str_contains($value, 'Bob'));
});

it('imports from cvotes format', function () {
    $cvotes = "#/Candidates: Alpha ; Beta ; Gamma\n#/Implicit Ranking: true\n\nAlpha > Beta > Gamma\nBeta > Alpha > Gamma";

    Livewire::test(ElectionManager::class)
        ->set('importText', $cvotes)
        ->call('importCvotes')
        ->assertSet('candidates', ['Alpha', 'Beta', 'Gamma'])
        ->assertCount('votes', 2);
});

it('handles multiple methods simultaneously', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['A', 'B', 'C'])
        ->set('votes', [
            ['ranking' => 'A > B > C', 'weight' => 1, 'quantity' => 3],
            ['ranking' => 'B > C > A', 'weight' => 1, 'quantity' => 2],
            ['ranking' => 'C > A > B', 'weight' => 1, 'quantity' => 1],
        ])
        ->set('methods', ['Schulze', 'Borda Count', 'Copeland'])
        ->assertSee('Schulze')
        ->assertSee('Borda Count')
        ->assertSee('Copeland');
});

it('dispatches state update events on changes', function () {
    Livewire::test(ElectionManager::class)
        ->set('newCandidate', 'TestCandidate')
        ->call('addCandidate')
        ->assertDispatched('election-state-updated');
});
