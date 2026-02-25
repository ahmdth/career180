<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <main class="md:col-span-2">
        @livewire('video-player', ['lesson' => $lesson])
        <div class="flex items-center mb-4">
            @if ($isCompleted)
                <flux:icon.check-circle variant="solid" class="size-6 mr-4 text-green-600 dark:text-green-400" />
            @else
                <flux:button type="button" icon="check-circle" variant="subtle" class="cursor-pointer"
                    icon:variant="outline" wire:click="markAsCompleted">
                </flux:button>
            @endif
            <flux:heading>{{ $lesson->title }}</flux:heading>
        </div>

        <div class="flex items-center justify-between mb-6">
            @if ($previousLesson)
                <flux:button wire:navigate icon="arrow-left"
                    href="{{ route('lessons.show', ['course' => $lesson->course, 'lesson' => $previousLesson]) }}">
                    Previous
                </flux:button>
            @endif
            @if ($nextLesson)
                <flux:button wire:navigate icon:trailing="arrow-right"
                    href="{{ route('lessons.show', ['course' => $lesson->course, 'lesson' => $nextLesson]) }}">
                    Next
                </flux:button>
            @endif
        </div>

        <div x-data="toast()" x-init="
            @if (session('message'))
                showToast('{{ session('message') }}', '{{ session('type', 'default') }}');
            @endif" class="fixed bottom-5 right-5">
            <div x-show="show" x-transition @click="hide" class="px-4 py-2 rounded shadow text-white cursor-pointer"
                :class="{
            'bg-blue-500': type === 'default',
            'bg-green-600': type === 'success',
            'bg-yellow-500': type === 'warning',
            'bg-red-600': type === 'error'
        }">
                <span x-text="message"></span>
            </div>
        </div>
    </main>

    <aside class="md:col-span-1">
        <div class="p-4 bg-stone-100 border dark:border-black/20 dark:bg-black/40 rounded-lg">
            <flux:heading size="lg" class="mb-4">Lessons</flux:heading>
            @foreach($courseLessons as $cl)
                <div
                    @class([
                        "relative w-full text-left px-3 py-2 rounded-md hover:bg-stone-100 dark:hover:bg-stone-800 mb-2",
                        'bg-white border border-stone-200 dark:bg-stone-800 dark:border-stone-700' => request()->routeIs('lessons.show') && request()->route('lesson')->id === $cl->id,
                    ])>
                    <div>
                        <span class="block text-xs text-stone-700 dark:text-stone-400">Lesson {{ $cl->order }}</span>
                        <flux:link href="{{ route('lessons.show', ['course' => $lesson->course, 'lesson' => $cl]) }}" wire:navigate variant="ghost" class="absolute inset-0"></flux:link>
                        <flux:heading size="sm">{{ $cl->title }}</flux:heading>
                    </div>
                    <flux:text class="text-sm text-stone-900 dark:text-stone-100">{{ $cl->time() }}</flux:text>
                </div>
            @endforeach
        </div>
    </aside>
</div>
