<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Level;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Home - Career180')]
class Home extends Component
{
    use WithPagination;

    public ?int $levelId = null;

    public ?string $search = null;

    public function render()
    {
        return view('pages::home')
            ->with([
                'levels' => Level::all(),
                'courses' => Course::query()
                    ->where('is_published', true)
                    ->when($this->search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
                    ->when($this->levelId, fn ($q, $levelId) => $q->where('level_id', $levelId))
                    ->with('level')
                    ->latest()
                    ->paginate(10),
            ]);
    }
}
