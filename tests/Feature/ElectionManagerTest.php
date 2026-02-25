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
        ->set('newCandidate', 'Alice ; Bob ; Charlie')
        ->call('addCandidate')
        ->assertSet('candidates', ['Alice', 'Bob', 'Charlie'])
        ->assertSet('newCandidate', '');
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
        ->assertSet('methods', ['Schulze Winning'])
        ->call('toggleMethod', 'Schulze Winning')
        ->assertSet('methods', [])
        ->call('toggleMethod', 'Schulze Winning')
        ->assertSet('methods', ['Schulze Winning']);
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
        ->set('methods', ['Schulze Winning'])
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
        ->set('methods', ['Schulze Winning'])
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
        ->set('methods', ['Schulze Winning', 'Copeland'])
        ->call('resetElection')
        ->assertSet('candidates', [])
        ->assertSet('votes', [])
        ->assertSet('methods', ['Schulze Winning']);
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
        ->set('methods', ['Schulze Winning', 'Borda Count', 'Copeland'])
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

// ──────────────────────────────────────────────
// Error validation — invalid values must trigger server-side errors
// ──────────────────────────────────────────────

it('rejects an empty vote ranking', function () {
    Livewire::test(ElectionManager::class)
        ->set('newVoteRanking', '')
        ->call('addVote')
        ->assertHasErrors('newVoteRanking')
        ->assertCount('votes', 0);
});

it('rejects an empty vote ranking with only whitespace', function () {
    Livewire::test(ElectionManager::class)
        ->set('newVoteRanking', '   ')
        ->call('addVote')
        ->assertHasErrors('newVoteRanking')
        ->assertCount('votes', 0);
});

it('rejects bulk add with empty text', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob'])
        ->set('parseVotesText', '')
        ->call('bulkAddVotes')
        ->assertHasErrors('parseVotesText')
        ->assertCount('votes', 0);
});

it('rejects bulk add with only whitespace', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob'])
        ->set('parseVotesText', "   \n  \n  ")
        ->call('bulkAddVotes')
        ->assertHasErrors('parseVotesText')
        ->assertCount('votes', 0);
});

it('rejects bulk add when fewer than 2 candidates', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice'])
        ->set('parseVotesText', 'Alice > Bob')
        ->call('bulkAddVotes')
        ->assertHasErrors('parseVotesText')
        ->assertCount('votes', 0);
});

it('rejects bulk add with only comment lines', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob'])
        ->set('parseVotesText', "# This is a comment\n# Another comment\n")
        ->call('bulkAddVotes')
        ->assertHasErrors('parseVotesText')
        ->assertCount('votes', 0);
});

it('bulk adds votes successfully', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob', 'Charlie'])
        ->set('parseVotesText', "Alice > Bob > Charlie\nBob > Alice > Charlie")
        ->call('bulkAddVotes')
        ->assertHasNoErrors()
        ->assertCount('votes', 2)
        ->assertSet('parseVotesText', '')
        ->assertDispatched('bulk-votes-added');
});

it('bulk adds votes with weight and quantity', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob'])
        ->set('weightAllowed', true)
        ->set('parseVotesText', 'Alice > Bob ^3 * 5')
        ->call('bulkAddVotes')
        ->assertHasNoErrors()
        ->assertCount('votes', 1)
        ->assertSet('votes.0.weight', 3)
        ->assertSet('votes.0.quantity', 5);
});

it('bulk add skips comments and blank lines', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob'])
        ->set('parseVotesText', "# header comment\n\nAlice > Bob\n\n# footer\n")
        ->call('bulkAddVotes')
        ->assertHasNoErrors()
        ->assertCount('votes', 1);
});

it('rejects import with empty text', function () {
    Livewire::test(ElectionManager::class)
        ->set('importText', '')
        ->call('importCvotes')
        ->assertHasErrors('importText');
});

it('rejects import with invalid cvotes format', function () {
    // Duplicate candidates in the directive trigger a library exception
    Livewire::test(ElectionManager::class)
        ->set('importText', '#/Candidates: A;A')
        ->call('importCvotes')
        ->assertHasErrors('importText');
});

it('rejects export with fewer than 2 candidates', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice'])
        ->call('exportCvotes')
        ->assertHasErrors('exportOutput');
});

// ──────────────────────────────────────────────
// updated* hooks — settings changes dispatch syncState
// ──────────────────────────────────────────────

it('dispatches state update when methods property is updated', function () {
    Livewire::test(ElectionManager::class)
        ->set('methods', ['Copeland', 'Borda Count'])
        ->assertDispatched('election-state-updated')
        ->assertSet('methods', ['Copeland', 'Borda Count']);
});

it('dispatches state update when implicitRanking is toggled', function () {
    Livewire::test(ElectionManager::class)
        ->set('implicitRanking', false)
        ->assertDispatched('election-state-updated')
        ->assertSet('implicitRanking', false);
});

it('dispatches state update when weightAllowed is toggled', function () {
    Livewire::test(ElectionManager::class)
        ->set('weightAllowed', false)
        ->assertDispatched('election-state-updated')
        ->assertSet('weightAllowed', false);
});

it('dispatches state update when noTieConstraint is toggled', function () {
    Livewire::test(ElectionManager::class)
        ->set('noTieConstraint', true)
        ->assertDispatched('election-state-updated')
        ->assertSet('noTieConstraint', true);
});

it('marks votes with ties as invalid when NoTie constraint is active', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob', 'Charlie'])
        ->set('noTieConstraint', true)
        ->set('votes', [
            ['ranking' => 'Alice > Bob > Charlie', 'weight' => 1, 'quantity' => 1],
            ['ranking' => 'Alice = Bob > Charlie', 'weight' => 1, 'quantity' => 1],
            ['ranking' => 'Bob > Charlie > Alice', 'weight' => 1, 'quantity' => 1],
        ])
        ->set('methods', ['Schulze Winning'])
        ->assertSee(__('ui.vote_valid'))
        ->assertSee(__('ui.vote_invalid'));
});

it('does not show status column when no constraint is active', function () {
    Livewire::test(ElectionManager::class)
        ->set('candidates', ['Alice', 'Bob', 'Charlie'])
        ->set('noTieConstraint', false)
        ->set('votes', [
            ['ranking' => 'Alice = Bob > Charlie', 'weight' => 1, 'quantity' => 1],
        ])
        ->set('methods', ['Schulze Winning'])
        ->assertDontSee(__('ui.vote_invalid'))
        ->assertDontSee(__('ui.status'));
});

it('clamps seats to minimum 1 on update', function () {
    Livewire::test(ElectionManager::class)
        ->set('seats', 0)
        ->assertSet('seats', 1)
        ->assertDispatched('election-state-updated');
});

it('clamps negative seats to 1', function () {
    Livewire::test(ElectionManager::class)
        ->set('seats', -5)
        ->assertSet('seats', 1);
});

// ──────────────────────────────────────────────
// loadFromLocalStorage — full state hydration
// ──────────────────────────────────────────────

it('loads noTieConstraint from localStorage payload', function () {
    Livewire::test(ElectionManager::class)
        ->call('loadFromLocalStorage', [
            'candidates' => ['A', 'B'],
            'votes' => [],
            'methods' => ['Schulze Winning'],
            'seats' => 1,
            'implicitRanking' => true,
            'weightAllowed' => false,
            'noTieConstraint' => true,
        ])
        ->assertSet('noTieConstraint', true)
        ->assertDispatched('election-state-updated');
});

it('handles partial localStorage payload with safe defaults', function () {
    Livewire::test(ElectionManager::class)
        ->call('loadFromLocalStorage', [
            'candidates' => ['X'],
        ])
        ->assertSet('candidates', ['X'])
        ->assertSet('votes', [])
        ->assertSet('methods', [])
        ->assertSet('seats', 1)
        ->assertSet('implicitRanking', true)
        ->assertSet('weightAllowed', false)
        ->assertSet('noTieConstraint', false);
});

// ──────────────────────────────────────────────
// UI — loading and computing text
// ──────────────────────────────────────────────

it('renders the loading translation key', function () {
    Livewire::test(ElectionManager::class)
        ->assertSeeHtml(__('ui.loading'));
});

it('renders the computing translation key', function () {
    Livewire::test(ElectionManager::class)
        ->assertSeeHtml(__('ui.computing'));
});
